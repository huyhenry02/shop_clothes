<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Product;
use App\Services\PaymentService;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminInvoiceController extends Controller
{
    public function showIndex(): View
    {
        $invoices = Invoice::orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.pages.invoice.index', [
            'invoices' => $invoices,
        ]);
    }

    public function filter(Request $request): JsonResponse
    {
        $query = Invoice::orderBy('created_at', 'desc')->query();

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('invoice_code', 'like', "%$keyword%")
                    ->orWhere('customer_name', 'like', "%$keyword%")
                    ->orWhere('customer_phone', 'like', "%$keyword%");
            });
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $invoices = $query->get();

        return response()->json([
            'html' => view('admin.pages.invoice.table', compact('invoices'))->render()
        ]);
    }

    public function showUpdate(Invoice $invoice): View
    {
        return view('admin.pages.invoice.update', [
            'invoice' => $invoice,
        ]);
    }

    public function showCreate(): View
    {
        return view('admin.pages.invoice.create');
    }

    public function getProductByCode($code): JsonResponse
    {
        $product = Product::where('code', $code)->firstOrFail();
        $sizes = explode(',', $product->category->sizes ?? 'M,L,XL');

        return response()->json([
            'name' => $product->name,
            'image_url' => $product->image ?? '/customer/images/products/default.jpgg',
            'discount_price' => $product->discount_price,
            'sizes' => $sizes
        ]);
    }

    public function postInvoice(Request $request, PaymentService $paymentService): RedirectResponse
    {
        try {
            $input = $request->input();
            $invoiceDetails = $input['invoice_details'] ?? [];
            $totalAmount = $input['total_amount'] ?? 0;
            $employeeId = auth()->user()->employee->id;

            $invoiceCode = 'HD' . date('Ymd') . '-' . $employeeId . '/' . random_int(1, 100);
            $paymentMethod = $request->input('payment_method', Invoice::PAYMENT_METHOD_CASH);
            if ($paymentMethod === Invoice::PAYMENT_METHOD_CASH) {
                // code sử dụng cho việc thanh toán tiền mặt
                DB::beginTransaction();
                $invoice = Invoice::create([
                    'invoice_code' => $invoiceCode,
                    'customer_name' => $input['customer_name'],
                    'customer_phone' => $input['customer_phone'],
                    'total_amount' => $totalAmount,
                    'status' => $input['status'],
                    'payment_method' => $paymentMethod,
                    'payment_status' => $input['payment_status'],
                    'payment_time' => now(),
                    'employee_id' => $employeeId,
                ]);
                foreach ($invoiceDetails as $item) {
                    $product = Product::where('code', $item['code'])->firstOrFail();
                    InvoiceDetail::create([
                        'invoice_id' => $invoice->id,
                        'product_id' => $product->id,
                        'size' => $item['size'],
                        'quantity' => $item['quantity'],
                        'total_price' => $item['total_price'],
                    ]);
                    $paymentService->handleInventory($product, $item['quantity'], 'create');
                    $product->save();
                }
                DB::commit();
                return redirect()->route('admin.invoice.showIndex')->with('success', 'Hóa đơn của bạn đã được ghi nhận!');
            }
            // code sử dụng cho việc thanh toán qua VNPay
            session([
                'checkout' => [
                    'code' => $invoiceCode,
                    'customer_name' => $input['customer_name'],
                    'customer_phone' => $input['customer_phone'],
                    'total_amount' => $totalAmount,
                    'status' => $input['status'],
                    'payment_method' => $paymentMethod,
                    'payment_status' => $input['payment_status'],
                    'employee_id' => $employeeId,
                    'invoice_details' => $invoiceDetails,
                ]
            ]);
            $returnUrl = route('admin.invoice.vnpay.return');
            // Tạo hóa đơn và chuyển hướng đến VNPay
            return $paymentService->createVnpayRedirectUrl($totalAmount, $invoiceCode, $returnUrl);
        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function vnpayReturn(Request $request, PaymentService $paymentService)
    {
//        hàm này sẽ xử lý việc trả về từ VNPay sau khi thanh toán
        return $paymentService->handleVnpayReturn(
            $request,
            'checkout',
            function ($checkoutData, $req) use ($paymentService) {
                $invoice = Invoice::create([
                    'invoice_code' => $checkoutData['code'],
                    'customer_name' => $checkoutData['customer_name'],
                    'customer_phone' => $checkoutData['customer_phone'],
                    'total_amount' => $checkoutData['total_amount'],
                    'status' => $checkoutData['status'],
                    'payment_method' => $checkoutData['payment_method'],
                    'payment_status' => $checkoutData['payment_status'],
                    'employee_id' => $checkoutData['employee_id'],
                    'payment_time' => now(),
                ]);

                foreach ($checkoutData['invoice_details'] as $item) {
                    $product = Product::where('code', $item['code'])->firstOrFail();
                    InvoiceDetail::create([
                        'invoice_id' => $invoice->id,
                        'product_id' => $product->id,
                        'size' => $item['size'],
                        'quantity' => $item['quantity'],
                        'total_price' => $item['total_price'],
                    ]);
                    $paymentService->handleInventory($product, $item['quantity'], 'create');
                    $product->save();

                }

                return redirect()->route('admin.invoice.showIndex')->with('success', 'Thanh toán thành công!');
            },
            fn($msg) => redirect()->route('admin.invoice.showCreate')->with('error', $msg)
        );
    }

    public function putInvoice(Request $request, Invoice $invoice, PaymentService $paymentService): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $input = $request->input();
            $invoice->fill($input)->save();
            $newDetails = $input['invoice_details'] ?? [];
            $oldDetails = InvoiceDetail::where('invoice_id', $invoice->id)->get();

            foreach ($oldDetails as $oldItem) {
                $paymentService->handleInventory($oldItem->product, $oldItem->quantity, 'cancel');
                $oldItem->product->save();
            }

            InvoiceDetail::where('invoice_id', $invoice->id)->delete();

            foreach ($newDetails as $item) {
                $product = Product::where('code', $item['code'])->firstOrFail();
                $paymentService->handleInventory($product, $item['quantity'], 'create');
                $product->save();
                InvoiceDetail::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $product->id,
                    'size' => $item['size'],
                    'quantity' => $item['quantity'],
                    'total_price' => $item['total_price'],
                ]);
            }

            DB::commit();
            return redirect()->route('admin.invoice.showIndex')->with('success', 'Cập nhật hóa đơn thành công!');
        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Cập nhật hóa đơn thất bại');
        }
    }

    public function delete(Invoice $invoice, PaymentService $paymentService): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $details = InvoiceDetail::where('invoice_id', $invoice->id)->get();
            foreach ($details as $detail) {
                $paymentService->handleInventory($detail->product, $detail->quantity, 'cancel');
                $detail->product->save();
            }
            InvoiceDetail::where('invoice_id', $invoice->id)->delete();
            $invoice->delete();
            DB::commit();
            return redirect()->route('admin.invoice.showIndex')->with('success', 'Xóa hóa đơn thành công!');
        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Xóa hóa đơn thất bại');
        }
    }

    public function exportInvoicePdf(Invoice $invoice): Response
    {
        $invoice->load(['invoiceDetails.product']);

        $cleanedCode = preg_replace('/[^A-Za-z0-9_\-]/', '-', $invoice->invoice_code);
        $filename = 'HoaDon-' . $cleanedCode . '.pdf';

        return PDF::loadView('admin.pages.invoice.pdf', compact('invoice'))->stream($filename);
    }
}
