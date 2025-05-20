<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminCustomerController extends Controller
{
    public function showIndex(): View
    {
        $customers = Customer::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.pages.customer.index',
            [
                'customers' => $customers,
            ]);
    }

    public function filter(Request $request): JsonResponse
    {
        $keyword = $request->keyword;

        $customers = Customer::where(function ($query) use ($keyword) {
            $query->where('full_name', 'like', "%$keyword%")
                ->orWhereHas('user', function ($q) use ($keyword) {
                    $q->where('phone', 'like', "%$keyword%");
                });
        })->get();

        return response()->json([
            'html' => view('admin.pages.customer.table', compact('customers'))->render()
        ]);
    }

    public function showCreate(): View
    {
        return view('admin.pages.customer.create');
    }

    public function showUpdate(Customer $customer): View
    {
        return view('admin.pages.customer.update',
            [
                'customer' => $customer,
            ]);
    }

    public function postCustomer(Request $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $customer = new Customer();
            $input = $request->all();
            $user = User::create([
                'phone' => $input['phone'],
                'password' => bcrypt($input['password']),
                'role' => User::ROLE_CUSTOMER,
            ]);
            $customer->user_id = $user->id;
            $customer->fill($input);
            $customer->save();
            DB::commit();
            if ($input['type_create'] === 'customer_register') {
                return redirect()->route('auth.showLogin')->with('success', 'Thêm khách hàng thành công');
            }
            return redirect()->route('admin.customer.showIndex')->with('success', 'Thêm khách hàng thành công');

        }catch (Exception $exception){
            DB::rollBack();
            $input = $request->all();
            if ($input['type_create'] === 'customer_register') {
                return redirect()->route('customer.showIndex')->with('success', 'Thêm khách hàng thất bại');
            }
            return redirect()->route('admin.customer.showIndex')->with('success', 'Thêm khách hàng thất bại');
        }
    }

    public function putCustomer(Request $request, Customer $customer): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $input = $request->all();
            $customer->fill($input);
            $customer->save();
            $user = User::find($customer->user_id);
            $user->phone = $input['phone'];
            if (isset($input['password'])) {
                $user->password = bcrypt($input['password']);
            }
            $user->save();
            DB::commit();
            return redirect()->route('admin.customer.showIndex')->with('success', 'Cập nhật khách hàng thành công');
        }catch (Exception $exception){
            DB::rollBack();
            return redirect()->route('admin.customer.showIndex')->with('error', 'Cập nhật khách hàng thất bại');
        }
    }

    public function delete(Customer $customer): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $customer->delete();
            $customer->user()->delete();
            DB::commit();
            return redirect()->route('admin.customer.showIndex')->with('success', 'Xóa khách hàng thành công');
        }catch (Exception $exception){
            DB::rollBack();
            return redirect()->route('admin.customer.showIndex')->with('error', 'Xóa khách hàng thất bại');
        }
    }
}
