<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Services\PaymentService;
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
        // gọi model Category để  lấy danh sách các sản phẩm theo từng danh mục
        $firstCategory = Category::find($first_category_id);
        $secondCategory = Category::find($second_category_id);
        $thirdCategory = Category::find($third_category_id);
        // lấy 5 sản phẩm đầu tiên của mỗi danh mục
        $list_first_products = Category::find($first_category_id)->products()->take(5)->get();
        $list_second_products = Category::find($second_category_id)->products()->take(5)->get();
        $list_third_products = Category::find($third_category_id)->products()->take(5)->get();
//        trả về view index của customer
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
        $products = Product::orderBy('created_at', 'desc')->where('is_active', 1)->paginate(9);
        $categories = Category::all();
        return view('customer.pages.list_products',
            [
                'products' => $products,
                'categories' => $categories,
            ]);
    }

    public function filterProducts(Request $request): JsonResponse
    {
        $query = Product::orderBy('created_at', 'desc')->with('category');

        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        if ($request->filled('category_ids')) {
            $query->whereIn('category_id', $request->category_ids);
        }

        if ($request->sort_price === 'asc') {
            $query->orderBy('discount_price', 'asc');
        } elseif ($request->sort_price === 'desc') {
            $query->orderBy('discount_price', 'desc');
        }

        $products = $query->get();

        $html = view('customer.pages.product_table', compact('products'))->render();

        return response()->json(['html' => $html]);
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
        $orders = Order::orderBy('created_at', 'desc')->where('customer_id', auth()->user()->customer->id ?? auth()->user()->employee->id)->get();
        return view('customer.pages.order',
            [
                'orders' => $orders,
            ]);
    }

    public function showCart(): View
    {
        $customerId = auth()->user()->customer->id ?? auth()->user()->employee->id;
        $carts = Cart::orderBy('created_at', 'desc')->where('customer_id', $customerId)->get();
        return view('customer.pages.cart',
            [
                'carts' => $carts,
            ]);
    }

    public function showCheckout(): View
    {
        $cartItems = Cart::orderBy('created_at', 'desc')->where('customer_id', auth()->user()->customer->id)->get();
        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $totalPrice += $item->product->discount_price * $item->quantity;
        }
        return view('customer.pages.checkout',
            [
                'cartItems' => $cartItems,
                'totalPrice' => $totalPrice,
            ]);
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
            $priceItemCart = number_format($cart->product->discount_price * $cart->quantity) . ' VND';
            $carts = Cart::where('customer_id', auth()->user()->customer->id)->get();
            $totalPrice = 0;
            foreach ($carts as $item) {
                $totalPrice += $item->product->discount_price * $item->quantity;
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
            $priceItemCart = number_format($cart->product->discount_price * $cart->quantity) . ' VND';
            foreach ($carts as $item) {
                $totalPrice += $item->product->discount_price * $item->quantity;
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

    public function postCheckout(Request $request, PaymentService $paymentService): RedirectResponse
    {
        try {
            $input = $request->input();
            $customersId = auth()->user()->customer->id;
            $cartItems = Cart::where('customer_id', $customersId)->get();
            $totalPrice = 0;
            foreach ($cartItems as $item) {
                $totalPrice += $item->product->discount_price * $item->quantity;
            }

            if ($cartItems->isEmpty()) {
                return redirect()->route('customer.showCart')->with('error', 'Giỏ hàng rỗng');
            }

            $orderCode = 'DH' . date('Ymd') . '-' . $customersId . '/' . random_int(1, 100);
            $paymentMethod = $request->input('payment_method', 'cod');

            if ($paymentMethod === 'cod') {
                DB::beginTransaction();
                $order = Order::create([
                    'customer_id' => $customersId,
                    'order_code' => $orderCode,
                    'total_amount' => $totalPrice,
                    'status' => Order::STATUS_PENDING,
                    'payment_status' => Order::PAYMENT_STATUS_UNPAID,
                    'payment_method' => $paymentMethod,
                    'shipping_name' => $input['shipping_name'],
                    'shipping_phone' => $input['shipping_phone'],
                    'shipping_email' => $input['shipping_email'],
                    'shipping_address' => $input['shipping_address'],
                ]);
                foreach ($cartItems as $item) {
                    $priceItemCart = $item->product->discount_price * $item->quantity;
                    OrderDetail::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'total_price' => $priceItemCart,
                        'size' => $item->size
                    ]);
                    $paymentService->handleInventory($item->product, $item->quantity, 'create');
                    $item->delete();
                }
                DB::commit();
                return redirect()->route('customer.showOrder')->with('success', 'Đơn hàng của bạn đã được ghi nhận!');
            }
            session([
                'checkout' => [
                    'customer_id' => $customersId,
                    'code' => $orderCode,
                    'total_amount' => $totalPrice,
                    'status' => Order::STATUS_PROCESSING,
                    'payment_status' => Order::PAYMENT_STATUS_PAID,
                    'payment_method' => $paymentMethod,
                    'shipping_name' => $input['shipping_name'],
                    'shipping_phone' => $input['shipping_phone'],
                    'shipping_email' => $input['shipping_email'],
                    'shipping_address' => $input['shipping_address'],
                    'cart' => $cartItems->toArray(),
                ]
            ]);
            $returnUrl = route('customer.vnpay.return');
            return $paymentService->createVnpayRedirectUrl($totalPrice, $orderCode, $returnUrl);
        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Đặt hàng thất bại');
        }
    }

    public function vnpayReturn(Request $request, PaymentService $paymentService)
    {
        return $paymentService->handleVnpayReturn(
            $request,
            'checkout',
            function ($checkoutData, $req) use ($paymentService) {
                $order = Order::create([
                    'customer_id' => $checkoutData['customer_id'],
                    'order_code' => $checkoutData['code'],
                    'total_amount' => $checkoutData['total_amount'],
                    'status' => $checkoutData['status'],
                    'payment_status' => $checkoutData['payment_status'],
                    'payment_method' => $checkoutData['payment_method'],
                    'shipping_name' => $checkoutData['shipping_name'],
                    'shipping_phone' => $checkoutData['shipping_phone'],
                    'shipping_email' => $checkoutData['shipping_email'],
                    'shipping_address' => $checkoutData['shipping_address'],
                    'payment_time' => now(),
                    'payment_transaction_id' => $req->get('vnp_TxnRef'),
                    'payment_bank_code' => $req->get('vnp_BankCode'),
                    'payment_response_code' => $req->get('vnp_ResponseCode'),
                    'payment_secure_hash' => $req->get('vnp_SecureHash'),
                ]);

                foreach ($checkoutData['cart'] as $item) {
                    $cartItem = Cart::find($item['id']);
                    $priceItemCart = $cartItem->product->discount_price * $cartItem->quantity;

                    OrderDetail::create([
                        'order_id' => $order->id,
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'total_price' => $priceItemCart,
                        'size' => $item['size']
                    ]);

                    $paymentService->handleInventory($cartItem->product, $cartItem->quantity, 'create');
                    $cartItem->delete();
                }
                return redirect()->route('customer.showOrder')->with('success', 'Thanh toán thành công!');
            },
            fn($msg) => redirect()->route('customer.showCart')->with('error', $msg)
        );
    }
}
