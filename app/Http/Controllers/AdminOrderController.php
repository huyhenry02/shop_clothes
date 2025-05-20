<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminOrderController extends Controller
{
    public function showIndex(): View
    {
        $orders = Order::paginate(10);
        return view('admin.pages.order.index', [
            'orders' => $orders,
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
