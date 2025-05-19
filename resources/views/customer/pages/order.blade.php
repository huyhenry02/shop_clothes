@php use App\Models\Order;use Carbon\Carbon; @endphp
@extends('customer.layouts.main')
@section('content')
    <div class="page-heading about-page-heading" id="top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-content">
                        <h2>Đơn hàng</h2>
                        <span>Nơi bạn theo dõi và kiểm tra đơn hàng của mình tại ROWAY</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="container py-5 h-100">
            @foreach($orders as $order)
                @php
                    $statuses = [
                        Order::STATUS_PENDING,
                        Order::STATUS_PROCESSING,
                        Order::STATUS_SHIPPING,
                        Order::STATUS_COMPLETED,
                    ];
                    $currentIndex = array_search($order->status, $statuses, true);
                    $isCancelled = $order->status === Order::STATUS_CANCELLED;
                @endphp
                <div class="row mb-5 d-flex justify-content-center align-items-center h-100">
                    <div class="col">
                        <div class="card card-stepper" style="border-radius: 10px;">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex flex-column">

                                        <span class="lead fw-normal {{ $isCancelled ? 'text-danger' : '' }}">
                                            {{ $isCancelled ? 'Đơn hàng đã bị hủy' : (Order::HEADER_STATUSES[$order->status] ?? 'Trạng thái không xác định') }} <span
                                                class="fw-bold">#{{ $order->order_code }}</span>
                                        </span>
                                        <span class="text-muted small">
                                            Đơn vị vận chuyển: ROWAY
                                             {{ $order->completed_at ? '- Ngày giao:' . Carbon::parse($order->completed_at)->format('d/m/Y') : '' }}
                                        </span>
                                    </div>
                                    <div>
                                        <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal"
                                                data-bs-target="#orderModal{{ $order->id }}">
                                            Xem chi tiết
                                        </button>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <div
                                    class="d-flex flex-row justify-content-between align-items-center align-content-center">
                                    @foreach($statuses as $index => $status)
                                        <span class="dot {{ $index === $currentIndex ? 'big-dot text-white' : '' }}">
                                            @if ($index === $currentIndex)
                                                <i class="fa fa-check text-white"></i>
                                            @endif
                                        </span>
                                        @if ($index < count($statuses) - 1)
                                            <hr class="flex-fill track-line {{ $index < $currentIndex ? '' : 'bg-light' }}">
                                        @endif
                                    @endforeach
                                </div>

                                <div class="d-flex flex-row justify-content-between align-items-center">
                                    <div class="d-flex flex-column align-items-start text-center">
                                        <i class="fa fa-clock-o mb-1"></i>
                                        <span>{{ Order::STATUSES[Order::STATUS_PENDING] }}</span>
                                    </div>
                                    <div class="d-flex flex-column text-center">
                                        <i class="fa fa-cogs mb-1"></i>
                                        <span>{{ Order::STATUSES[Order::STATUS_PROCESSING] }}</span>
                                    </div>
                                    <div class="d-flex flex-column text-center">
                                        <i class="fa fa-truck mb-1"></i>
                                        <span>{{ Order::STATUSES[Order::STATUS_SHIPPING] }}</span>
                                    </div>
                                    <div class="d-flex flex-column text-center">
                                        <i class="fa fa-check-circle mb-1"></i>
                                        <span>{{ Order::STATUSES[Order::STATUS_COMPLETED] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1"
                     aria-labelledby="orderModalLabel{{ $order->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="container py-5 w-100 h-100">
                            <div class="row d-flex justify-content-center align-items-center h-100">
                                <div class="col-lg-12 col-xl-10">
                                    <div class="card" style="border-radius: 10px;">
                                        <div class="card-header px-4 py-5">
                                            <h5 class="text-muted mb-0">
                                                Cảm ơn bạn đã tin tưởng và đồng hành cùng <span style="color: #678b8f;">ROWAY</span>,
                                                <strong>{{ auth()->user()->customer->full_name ?? '' }}</strong>!
                                            </h5>
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between align-items-center mb-4">
                                                <p class="lead fw-normal mb-0" style="color: #454345;">Sản phẩm</p>
                                                <p class="small text-muted mb-0">Mã đơn : #{{ $order->order_code }}</p>
                                            </div>

                                            @foreach($order->orderDetails as $orderDetail)
                                                <div class="card shadow-0 border mb-3">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <img src="{{ $orderDetail->product->image ?? '/customer/images/products/default.jpg' }}"
                                                                     class="img-fluid" alt="product" style="width: 100px; height: 100px;">
                                                            </div>
                                                            <div class="col-md-4 text-left d-flex justify-content-center align-items-center">
                                                                <p class="text-muted mb-0">{{ $orderDetail->product->name }}</p>
                                                            </div>
                                                            <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                                <p class="text-muted mb-0 small">Size: {{ $orderDetail->size }}</p>
                                                            </div>
                                                            <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                                <p class="text-muted mb-0 small">SL: {{ $orderDetail->quantity }}</p>
                                                            </div>
                                                            <div class="col-md-2 text-end d-flex justify-content-center align-items-center">
                                                                <p class="text-muted mb-0 small">{{ number_format($orderDetail->total_price) }} VND</p>
                                                            </div>
                                                        </div>
                                                        <hr class="mb-4" style="background-color: #e0e0e0; opacity: 1;">
                                                    </div>
                                                </div>
                                            @endforeach
                                            <p class="fw-bold mt-3">Thông tin chi tiết</p>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="text-muted mb-0">Trạng thái đơn hàng: {{ Order::STATUSES[$order->status] ?? '' }}</p>
                                                    <p class="text-muted mb-0">Trạng thái thanh toán : {{ Order::PAYMENT_STATUSES[$order->payment_status] ?? '' }}</p>
                                                    <p class="text-muted mb-0">Ngày nhận hàng : {{ $order->completed_at ? Carbon::parse($order->completed_at)->format('d/m/Y H:i') : '--' }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="text-muted mb-0">Tổng tiền: {{ number_format($order->total_amount) }} VND</p>
                                                    <p class="text-muted mb-0">Phương thức thanh toán : {{ Order::PAYMENT_METHODS[$order->payment_method] ?? '' }}</p>
                                                    <p class="text-muted mb-0">Thời gian thanh toán :
                                                        {{ $order->payment_time ? Carbon::parse($order->payment_time)->format('d/m/Y H:i') : '--' }}
                                                    </p>
                                                </div>
                                            </div>

                                            <p class="fw-bold mt-3">Thông tin nhận hàng</p>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="text-muted mb-0">Họ tên người nhận: {{ $order->shipping_name }}</p>
                                                    <p class="text-muted mb-0">Số điện thoại : {{ $order->shipping_phone }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="text-muted mb-0"></p>
                                                    <p class="text-muted mb-0">Email : {{ $order->shipping_email }}</p>
                                                    <p class="text-muted mb-0">Địa chỉ : {{ $order->shipping_address }}</p>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="card-footer border-0 px-5 py-3 w-100"
                                             style="background-color: #454345; border-bottom-left-radius: 7px; border-bottom-right-radius: 7px;">
                                            <h5 class="d-flex align-items-center justify-content-end text-white text-uppercase mb-0">
                                                Tổng thanh toán: <span class="h2 mb-0 ms-2">{{ number_format($order->total_amount) }} VND</span>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach
        </div>
    </section>
    <style>
        .track-line {
            height: 2px !important;
            background-color: #488978;
            opacity: 1;
        }

        .track-line.bg-light {
            background-color: #e0e0e0 !important;
        }

        .dot {
            height: 10px;
            width: 10px;
            margin-left: 3px;
            margin-right: 3px;
            background-color: #488978;
            border-radius: 50%;
            display: inline-block
        }

        .big-dot {
            height: 25px;
            width: 25px;
            background-color: #488978;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .card-stepper {
            z-index: 0;
        }
    </style>
@endsection
