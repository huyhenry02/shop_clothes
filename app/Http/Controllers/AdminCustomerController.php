<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
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

    public function showCreate(): View
    {
        return view('admin.pages.customer.create');
    }

    public function showUpdate(): View
    {
        return view('admin.pages.customer.update');
    }
}
