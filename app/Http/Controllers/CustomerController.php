<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
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
        $orders = Order::where('customer_id', auth()->user()->customer->id)->get();
        return view('customer.pages.order',
            [
                'orders' => $orders,
            ]);
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
        $cartItems = Cart::where('customer_id', auth()->user()->customer->id)->get();
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

    public function postCheckout(Request $request): RedirectResponse
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
                    $item->delete();
                }

                DB::commit();
                return redirect()->route('customer.showOrder')->with('success', 'Đơn hàng của bạn đã được ghi nhận!');
            }
            session([
                'checkout' => [
                    'customer_id' => $customersId,
                    'order_code' => $orderCode,
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
            return $this->createPaymentFromCheckout($totalPrice, $orderCode);
        }catch (Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('error', 'Đặt hàng thất bại');
        }
    }

    private function createPaymentFromCheckout($amount, $orderCode): Redirector|RedirectResponse
    {
        try {
            $vnp_TmnCode = "HBBQ09I7";
            $vnp_HashSecret = "3MFXY4YJ9X8XMJ3MJFIZGMK6GSDGVET7";
            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
            $vnp_Returnurl = route('customer.vnpay.return');

            $vnp_TxnRef = $orderCode;
            $vnp_OrderInfo = 'Thanh toán đơn hàng ' . $orderCode;
            $vnp_Amount = $amount * 100;
            $vnp_Locale = 'vn';
            $vnp_BankCode = 'NCB';
            $vnp_IpAddr = request()->ip();

            $inputData = [
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => now()->format('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => 'other',
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef
            ];
            if ($vnp_BankCode !== "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }

            ksort($inputData);
            $query = "";
            $hashdata = "";

            foreach ($inputData as $key => $value) {
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
                $hashdata .= $hashdata ? '&' : '';
                $hashdata .= urlencode($key) . "=" . urlencode($value);
            }

            $vnp_SecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $redirectUrl = $vnp_Url . "?" . $query . 'vnp_SecureHash=' . $vnp_SecureHash;
            return redirect($redirectUrl);
        } catch (Exception $e) {
            return redirect()->route('customer.showCart')->with('error', 'Lỗi tạo link VNPAY: ' . $e->getMessage());
        }
    }

    public function vnpayReturn(Request $request): RedirectResponse
    {
        try {
            $vnp_HashSecret = trim("3MFXY4YJ9X8XMJ3MJFIZGMK6GSDGVET7");

            $checkoutData = session('checkout');
            $vnp_ResponseCode = $request->get('vnp_ResponseCode');
            $vnp_TxnRef = $request->get('vnp_TxnRef');

            $inputData = $request->except('vnp_SecureHash', 'vnp_SecureHashType');
            ksort($inputData);

            $hashData = '';
            foreach ($inputData as $key => $value) {
                $hashData .= $key . '=' . urlencode($value) . '&';
            }
            $hashData = rtrim($hashData, '&');

            $secureHashCheck = hash_hmac('sha512', $hashData, $vnp_HashSecret);
            $vnp_SecureHash = $request->get('vnp_SecureHash');

            if (
                $secureHashCheck === $vnp_SecureHash &&
                $checkoutData &&
                $checkoutData['order_code'] === $vnp_TxnRef &&
                $vnp_ResponseCode === '00'
            ) {
                DB::beginTransaction();
                $order = Order::create([
                    'customer_id' => $checkoutData['customer_id'],
                    'order_code' => $checkoutData['order_code'],
                    'total_amount' => $checkoutData['total_amount'],
                    'status' => $checkoutData['status'],
                    'payment_status' => $checkoutData['payment_status'],
                    'payment_method' => $checkoutData['payment_method'],
                    'shipping_name' => $checkoutData['shipping_name'],
                    'shipping_phone' => $checkoutData['shipping_phone'],
                    'shipping_email' => $checkoutData['shipping_email'],
                    'shipping_address' => $checkoutData['shipping_address'],
                    'payment_time' => now(),
                    'payment_transaction_id' => $vnp_TxnRef,
                    'payment_bank_code' => $request->get('vnp_BankCode'),
                    'payment_response_code' => $vnp_ResponseCode,
                    'payment_secure_hash'  => $vnp_SecureHash,
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

                    Cart::where('id', $item['id'])->delete();
                }

                DB::commit();
                session()->forget('checkout');
                return redirect()->route('customer.showOrder')->with('success', 'Thanh toán thành công!');
            }

            return redirect()->route('customer.showCart')->with('error', 'Thanh toán thất bại hoặc dữ liệu không hợp lệ.');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
            return redirect()->route('customer.showCart')->with('error', 'Lỗi xử lý kết quả thanh toán: ' . $e->getMessage());
        }
    }
}
