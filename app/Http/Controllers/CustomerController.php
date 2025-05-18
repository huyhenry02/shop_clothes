<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $products = Product::where('is_active', 1)->paginate(9);
        return view('customer.pages.list_products',
            [
                'products' => $products,
            ]);
    }

    public function showProductDetail(Product $product): View
    {
        $category = $product->category;
        $sizes = $category->sizes;
        $sizesArray = explode(',', $sizes);
        return view('customer.pages.product_detail',
            [
                'sizesArray' => $sizesArray,
                'product' => $product,
            ]);
    }

    public function showOrder(): View
    {
        return view('customer.pages.order');
    }

    public function showCart(): View
    {
        $customerId = auth()->user()->customer->id;
        $carts = Cart::where('customer_id', $customerId)->get();
        return view('customer.pages.cart',
            [
                'carts' => $carts,
            ]);
    }

    public function showCheckout(): View
    {
        return view('customer.pages.checkout');
    }

    public function addToCart(Request $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $input = $request->input();
            $input['customer_id'] = auth()->user()->customer->id;
            $cart = new Cart();
            $cart->fill($input);
            $cart->save();
            DB::commit();
            return redirect()->route('customer.showCart')->with('success', 'Thêm sản phẩm vào giỏ hàng thành công');
        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Thêm sản phẩm vào giỏ hàng thất bại');
        }
    }

    public function updateCart(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $cart = Cart::findOrFail($request->id);
            if ($request->field === 'quantity') {
                $cart->quantity = max(1, intval($request->value));
            }
            if ($request->field === 'size') {
                $cart->size = $request->value;
            }
            $cart->save();
            $priceItemCart = number_format($cart->product->price * $cart->quantity) . ' VND';
            $carts = Cart::where('customer_id', auth()->user()->customer->id)->get();
            $totalPrice = 0;
            foreach ($carts as $item) {
                $totalPrice += $item->product->price * $item->quantity;
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'totalPrice' => number_format($totalPrice) . ' VND',
                'message' => 'Cập nhật giỏ hàng thành công',
                'priceItemCart' => $priceItemCart,
            ]);
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ]);
        }
    }

    public function deleteCart(Request $request): JsonResponse
    {
        try {
           DB::beginTransaction();
            $cart = Cart::findOrFail($request->id);
            $cart->delete();
            $carts = Cart::where('customer_id', auth()->user()->customer->id)->get();
            $totalPrice = 0;
            $priceItemCart = number_format($cart->product->price * $cart->quantity) . ' VND';
            foreach ($carts as $item) {
                $totalPrice += $item->product->price * $item->quantity;
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'totalPrice' => number_format($totalPrice) . ' VND',
                'priceItemCart' => $priceItemCart,
                'message' => 'Xóa sản phẩm khỏi giỏ hàng thành công',
            ]);
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }
    }
}
