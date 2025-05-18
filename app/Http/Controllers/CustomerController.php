<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function showIndex(): View
    {
        $first_category_id = 6;
        $second_category_id = 7;
        $third_category_id = 8;
        $firstCategory = Category::find($first_category_id);
        $secondCategory = Category::find($second_category_id);
        $thirdCategory = Category::find($third_category_id);
        $list_first_products = Category::find($first_category_id)->products()->take(5)->get();
        $list_second_products = Category::find($second_category_id)->products()->take(5)->get();
        $list_third_products = Category::find($third_category_id)->products()->take(5)->get();
        return view('customer.pages.index',
            [
                'firstCategory' => $firstCategory,
                'secondCategory' => $secondCategory,
                'thirdCategory' => $thirdCategory,
                'list_first_products' => $list_first_products,
                'list_second_products' => $list_second_products,
                'list_third_products' => $list_third_products,
            ]);
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
