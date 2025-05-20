<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    public function showUpdate(Order $order): View
    {
        return view('admin.pages.order.update', [
            'order' => $order,
        ]);
    }

    public function putOrder(Request $request, Order $order): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $input = $request->all();
            $order->fill($input)->save();
            DB::commit();
            return redirect()->route('admin.order.showIndex')->with('success', 'Cập nhật đơn hàng thành công');
        }catch (Exception $e){
            return redirect()->back()->with('error', 'Cập nhật đơn hàng thất bại');
        }
    }
}
