<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function showIndex(): View
    {
        return view('customer.pages.index');
    }

    public function showContact(): View
    {
        return view('customer.pages.contact');
    }

    public function showAbout(): View
    {
        return view('customer.pages.about');
    }

    public function showListProducts(): View
    {
        return view('customer.pages.list_products');
    }

    public function showProductDetail(): View
    {
        return view('customer.pages.product_detail');
    }

    public function showOrder(): View
    {
        return view('customer.pages.order');
    }

    public function showCart(): View
    {
        return view('customer.pages.cart');
    }

    public function showCheckout(): View
    {
        return view('customer.pages.checkout');
    }
}
