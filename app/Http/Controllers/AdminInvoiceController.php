<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Product;
use App\Services\PaymentService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
                }

                DB::commit();
                return redirect()->route('admin.invoice.showIndex')->with('success', 'Hóa đơn của bạn đã được ghi nhận!');
            }
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
            return $paymentService->createVnpayRedirectUrl($totalAmount, $invoiceCode, $returnUrl);
        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', ' Tạo hóa đơn thất bại');
        }
    }

    public function vnpayReturn(Request $request, PaymentService $paymentService)
    {
        return $paymentService->handleVnpayReturn(
            $request,
            'checkout',
            function ($checkoutData, $req) {
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
                }

                return redirect()->route('admin.invoice.showIndex')->with('success', 'Thanh toán thành công!');
            },
            fn($msg) => redirect()->route('admin.invoice.showCreate')->with('error', $msg)
        );
    }

    public function putInvoice(Request $request, Invoice $invoice): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $input = $request->input();
            $invoice->fill($input)->save();
            $invoiceDetails = $input['invoice_details'] ?? [];
            if ($invoiceDetails) {
                foreach ($invoiceDetails as $item) {
                    $product = Product::where('code', $item['code'])->firstOrFail();
                    InvoiceDetail::updateOrCreate(
                        [
                            'invoice_id' => $invoice->id,
                            'product_id' => $product->id,
                            'size' => $item['size'],
                        ],
                        [
                            'quantity' => $item['quantity'],
                            'total_price' => $item['total_price'],
                        ]
                    );
                }
            }
            DB::commit();
            return redirect()->route('admin.invoice.showIndex')->with('success', 'Cập nhật hóa đơn thành công!');
        } catch (Exception $exception) {
            return redirect()->back()->with('error', 'Cập nhật hóa đơn thất bại');
        }
    }

    public function delete(Invoice $invoice): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $invoice->delete();
            InvoiceDetail::where('invoice_id', $invoice->id)->delete();
            DB::commit();
            return redirect()->route('admin.invoice.showIndex')->with('success', 'Xóa hóa đơn thành công!');
        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Xóa hóa đơn thất bại');
        }
    }
}
