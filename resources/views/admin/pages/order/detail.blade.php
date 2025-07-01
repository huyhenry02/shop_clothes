@php use App\Models\Order;use Carbon\Carbon; @endphp
<div class="modal fade" id="orderModal{{ $val->id }}" tabindex="-1"
     aria-labelledby="orderModalLabel{{ $val->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="container py-5 w-100 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-10">
                    <div class="card" style="border-radius: 10px;">
                        <div class="card-header px-2 py-3">
                            <h5 class="text-muted mb-0">
                                Thông tin đơn hàng
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <p class="lead fw-normal mb-0" style="color: #454345;">Sản phẩm</p>
                                <p class="small text-muted mb-0">Mã đơn : #{{ $val->order_code }}</p>
                            </div>

                            @foreach($val->orderDetails as $valDetail)
                                <div class="card shadow-0 border mb-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <img
                                                    src="{{ $valDetail->product->image ?? '/customer/images/products/default.jpg' }}"
                                                    class="img-fluid" alt="product"
                                                    style="width: 100px; height: 100px;">
                                            </div>
                                            <div
                                                class="col-md-4 text-left d-flex justify-content-center align-items-center">
                                                <p class="text-muted mb-0">{{ $valDetail->product->name }}</p>
                                            </div>
                                            <div
                                                class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                <p class="text-muted mb-0 small">Size: {{ $valDetail->size }}</p>
                                            </div>
                                            <div
                                                class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                <p class="text-muted mb-0 small">SL: {{ $valDetail->quantity }}</p>
                                            </div>
                                            <div
                                                class="col-md-2 text-end d-flex justify-content-center align-items-center">
                                                <p class="text-muted mb-0 small">{{ number_format($valDetail->total_price) }}
                                                    VND</p>
                                            </div>
                                        </div>
                                        <hr class="mb-4" style="background-color: #e0e0e0; opacity: 1;">
                                    </div>
                                </div>
                            @endforeach
                            <p class="fw-bold mt-3">Thông tin chi tiết</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="text-muted mb-0">Trạng thái đơn
                                        hàng: {{ Order::STATUSES[$val->status] ?? '' }}</p>
                                    <p class="text-muted mb-0">Người duyệt
                                        hàng: {{ $val->employee->full_name ?? '' }}</p>
                                    <p class="text-muted mb-0">Trạng thái thanh toán
                                        : {{ Order::PAYMENT_STATUSES[$val->payment_status] ?? '' }}</p>
                                    <p class="text-muted mb-0">Ngày nhận hàng
                                        : {{ $val->completed_at ? Carbon::parse($val->completed_at)->format('d/m/Y H:i') : '--' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-muted mb-0">Tổng tiền: {{ number_format($val->total_amount) }}
                                        VND</p>
                                    <p class="text-muted mb-0">Phương thức thanh toán
                                        : {{ Order::PAYMENT_METHODS[$val->payment_method] ?? '' }}</p>
                                    <p class="text-muted mb-0">Thời gian thanh toán :
                                        {{ $val->payment_time ? Carbon::parse($val->payment_time)->format('d/m/Y H:i') : '--' }}
                                    </p>
                                </div>
                            </div>

                            <p class="fw-bold mt-3">Thông tin nhận hàng</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="text-muted mb-0">Họ tên người nhận: {{ $val->shipping_name }}</p>
                                    <p class="text-muted mb-0">Số điện thoại : {{ $val->shipping_phone }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-muted mb-0"></p>
                                    <p class="text-muted mb-0">Email : {{ $val->shipping_email }}</p>
                                    <p class="text-muted mb-0">Địa chỉ : {{ $val->shipping_address }}</p>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer border-0 px-5 py-3 w-100"
                             style="background-color: #1a5087; border-bottom-left-radius: 7px; border-bottom-right-radius: 7px;">
                            <h5 class="d-flex align-items-center justify-content-end text-white text-uppercase mb-0">
                                Tổng thanh toán: <span class="h2 mb-0 ms-2">{{ number_format($val->total_amount) }} VND</span>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
