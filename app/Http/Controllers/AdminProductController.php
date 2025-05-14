<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminProductController extends Controller
{
    public function showIndex(): View
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.pages.product.index',
            [
                'products' => $products,
            ]);
    }

    public function showCreate(): View
    {
        return view('admin.pages.product.create');
    }

    public function showUpdate(): View
    {
        return view('admin.pages.product.update');
    }
}
