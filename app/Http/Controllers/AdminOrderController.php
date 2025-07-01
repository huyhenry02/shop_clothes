<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Services\PaymentService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AdminOrderController extends Controller
{
    public function showIndex(): View
    {
        $orders = Order::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.pages.order.index', [
            'orders' => $orders,
        ]);
    }

    public function filter(Request $request): JsonResponse
    {
        $query = Order::orderBy('created_at', 'desc')->with(['customer.user']);

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('order_code', 'like', "%$keyword%")
                    ->orWhere('shipping_name', 'like', "%$keyword%")
                    ->orWhere('shipping_phone', 'like', "%$keyword%");
            });
        }

        if ($request->filled('phone_order')) {
            $phone = $request->phone_order;
            $query->whereHas('customer.user', function ($q) use ($phone) {
                $q->where('phone', 'like', "%$phone%");
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

        $orders = $query->get();

        return response()->json([
            'html' => view('admin.pages.order.table', compact('orders'))->render()
        ]);
    }
    public function showCreate(): View
    {
        return view('admin.pages.order.create');
    }

    public function showUpdate(Order $order): View
    {
        return view('admin.pages.order.update', [
            'order' => $order,
        ]);
    }

    public function getProductByCode($code): JsonResponse
    {
        $product = Product::where('code', $code)->firstOrFail();
        $sizes = explode(',', $product->category->sizes ?? 'M,L,XL');

        return response()->json([
            'name' => $product->name,
            'image_url' => $product->image ?? '/customer/images/products/default.jpg',
            'price' => $product->discount_price,
            'sizes' => $sizes
        ]);
    }

    public function postOrder(Request $request, PaymentService $paymentService): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $input = $request->all();
            $orderDetails = $input['order_details'] ?? [];
            $totalAmount = $input['total_amount'] ?? 0;
            $employeeId = auth()->user()->employee->id;

            $orderCode = 'DH' . date('Ymd') . '-' . $employeeId . '/' . random_int(1, 100);
            $paymentMethod = $request->input('payment_method', Order::PAYMENT_METHOD_COD);

            $order = Order::create([
                'order_code' => $orderCode,
                'updated_by' => $employeeId,
                'customer_id' => $input['customer_id'] ?? null,
                'total_amount' => $totalAmount,
                'status' => Order::STATUS_PENDING,
                'payment_status' => Order::PAYMENT_STATUS_UNPAID,
                'payment_method' => $paymentMethod,
                'shipping_name' => $input['shipping_name'],
                'shipping_phone' => $input['shipping_phone'],
                'shipping_email' => $input['shipping_email'] ?? null,
                'shipping_address' => $input['shipping_address'],
            ]);

            // Save order details
            foreach ($orderDetails as $detail) {
                $product = Product::where('code', $detail['code'])->firstOrFail();
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'size' => $detail['size'],
                    'quantity' => $detail['quantity'],
                    'price' => $product->discount_price,
                    'total_price' => $detail['total_price'],
                ]);

                // Update inventory
                $paymentService->handleInventory($product, $detail['quantity'], 'create');
                $product->save();
            }

            DB::commit();
            return redirect()->route('admin.order.showIndex')->with('success', 'Đơn hàng đã được tạo thành công!');
        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function putOrder(Request $request, Order $order, PaymentService $paymentService): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $employeeId = auth()->user()->employee->id;
            $input = $request->all();
            $input['updated_by'] = $employeeId;
            $oldStatus = $order->status;
            if ($input['status'] === Order::STATUS_COMPLETED) {
                $order->completed_at = now();
            }
            if ($input['payment_status'] === Order::PAYMENT_STATUS_PAID) {
                $order->payment_time = now();
            }
            $order->fill($input)->save();
            if ($order->status === Order::STATUS_CANCELLED && $oldStatus !== Order::STATUS_CANCELLED) {
                $orderDetails = $order->orderDetails;

                foreach ($orderDetails as $detail) {
                    $paymentService->handleInventory($detail->product, $detail->quantity, 'cancel');
                }
            }
            DB::commit();
            return redirect()->route('admin.order.showIndex')->with('success', 'Cập nhật đơn hàng thành công');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Cập nhật đơn hàng thất bại');
        }
    }
}
