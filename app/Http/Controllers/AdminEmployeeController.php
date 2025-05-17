<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminEmployeeController extends Controller
{
    public function showIndex(): View
    {
        $employees = Employee::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.pages.employee.index',
            [
                'employees' => $employees,
            ]);
    }

    public function showCreate(): View
    {
        return view('admin.pages.employee.create');
    }

    public function showUpdate(Employee $employee): View
    {
        return view('admin.pages.employee.update',
        [
                'employee' => $employee,
            ]);
    }

    public function postEmployee(Request $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $employee = new Employee();
            $input = $request->all();
            $user = User::create([
                'phone' => $input['phone'],
                'password' => bcrypt($input['password']),
                'role' => User::ROLE_EMPLOYEE,
            ]);
            $employee->user_id = $user->id;
            $employee->fill($input);
            $employee->save();
            DB::commit();
            return redirect()->route('admin.employee.showIndex')->with('success', 'Thêm nhân viên thành công');
        }catch (Exception $exception){
            DB::rollBack();
            return redirect()->route('admin.employee.showIndex')->with('error', 'Thêm nhân viên thất bại');
        }
    }

    public function putEmployee(Request $request, Employee $employee): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $input = $request->all();
            $employee->fill($input);
            $employee->save();
            $user = User::find($employee->user_id);
            if (isset($input['password'])) {
                $user->password = bcrypt($input['password']);
            }
            $user->phone = $input['phone'];
            $user->save();
            DB::commit();
            return redirect()->route('admin.employee.showIndex')->with('success', 'Cập nhật nhân viên thành công');
        }catch (Exception $exception){
            DB::rollBack();
            return redirect()->route('admin.employee.showIndex')->with('error', 'Cập nhật nhân viên thất bại');
        }
    }

    public function delete(Employee $employee): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $employee->delete();
            $employee->user()->delete();
            DB::commit();
            return redirect()->route('admin.employee.showIndex')->with('success', 'Xóa nhân viên thành công');
        }catch (Exception $exception){
            DB::rollBack();
            return redirect()->route('admin.employee.showIndex')->with('error', 'Xóa nhân viên thất bại');
        }
    }
}
