<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminEmployeeController extends Controller
{
    public function showIndex(): View
    {
        $employees = Employee::all();
        return view('admin.pages.employee.index',
            [
                'employees' => $employees,
            ]);
    }

    public function showCreate(): View
    {
        return view('admin.pages.employee.create');
    }

    public function showUpdate(): View
    {
        return view('admin.pages.employee.update');
    }
}
