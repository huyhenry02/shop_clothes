@extends('customer.layouts.main')
@section('content')
    <div class="page-heading about-page-heading" id="top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-content">
                        <h2>Thanh toán</h2>
                        <span>Hoàn tất đơn hàng của bạn một cách nhanh chóng và an toàn tại ROWAY</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xl-7">
                <form action="{{ route('customer.postCheckout') }}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <ol class="activity-checkout mb-0 px-4 mt-3">
                                <li class="checkout-item">
                                    <div class="avatar checkout-icon p-1">
                                        <div class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bxs-receipt text-white font-size-20"></i>
                                        </div>
                                    </div>
                                    <div class="feed-item-list">
                                        <div>
                                            <h5 class="font-size-16 mb-1">Thông tin người nhận</h5>
                                            <p class="text-muted text-truncate mb-4">Vui lòng điền đầy đủ thông tin để
                                                giao hàng</p>
                                            <div class="mb-3">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="billing-name">Họ và
                                                                tên</label>
                                                            <input type="text" class="form-control" id="billing-name"
                                                                   name="shipping_name" required
                                                                   value="{{ auth()->user()->customer->full_name ?? '' }}"
                                                                   placeholder="Nhập họ tên">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label class="form-label"
                                                                   for="billing-email-address">Email</label>
                                                            <input type="email" class="form-control"
                                                                   id="billing-email-address" name="shipping_email"
                                                                   required
                                                                   value="{{ auth()->user()->customer->email ?? '' }}"
                                                                   placeholder="Nhập email">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="shipping_phone">Số điện
                                                                thoại</label>
                                                            <input type="text" class="form-control" id="shipping_phone"
                                                                   name="shipping_phone" required
                                                                   value="{{ auth()->user()->phone ?? '' }}"
                                                                   placeholder="Nhập số điện thoại">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="billing-address">Địa chỉ giao
                                                        hàng</label>
                                                    <textarea class="form-control" id="billing-address" rows="3"
                                                              name="shipping_address" required
                                                              placeholder="Nhập địa chỉ đầy đủ">{{ auth()->user()->customer->address ?? '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li class="checkout-item">
                                    <div class="avatar checkout-icon p-1">
                                        <div class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bxs-wallet-alt text-white font-size-20"></i>
                                        </div>
                                    </div>
                                    <div class="feed-item-list">
                                        <div>
                                            <h5 class="font-size-16 mb-1">Phương thức thanh toán</h5>
                                            <p class="text-muted text-truncate mb-4">Chọn phương thức thanh toán phù hợp
                                                với bạn</p>
                                        </div>
                                        <div>
                                            <h5 class="font-size-14 mb-3">Hình thức:</h5>
                                            <div class="row">
                                                <div class="col-lg-6 col-sm-6">
                                                    <label class="card-radio-label">
                                                        <input type="radio" name="payment_method" id="pay-methodoption3"
                                                               value="cod"
                                                               class="card-radio-input" checked>
                                                        <span class="card-radio py-3 text-center text-truncate">
                                                            <i class="fa fa-money d-block h2 mb-3"></i>
                                                            Thanh toán khi nhận hàng
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="col-lg-6 col-sm-6">
                                                    <label class="card-radio-label">
                                                        <input type="radio" name="payment_method" id="pay-methodoption1"
                                                               value="vnpay"
                                                               class="card-radio-input">
                                                        <span class="card-radio py-3 text-center text-truncate">
                                                            <i class="fa fa-credit-card d-block h2 mb-3"></i>
                                                            Thanh toán VNPAY
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="row my-4">
                        <div class="col">
                            <a href="{{ route('customer.showIndex') }}" class="btn btn-link text-muted">
                                <i class="mdi mdi-arrow-left me-1"></i> Tiếp tục mua sắm
                            </a>
                        </div>
                        <div class="col">
                            <div class="text-end mt-2 mt-sm-0">
                                <button class="btn btn-success">
                                    <i class="mdi mdi-cart-outline me-1"></i> Xác nhận đặt hàng
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xl-5">
                <div class="card checkout-order-summary">
                    <div class="card-body">
                        <div class="p-3 bg-light mb-3">
                            <h5 class="font-size-16 mb-0">Tóm tắt đơn hàng</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-centered mb-0 table-nowrap">
                                <thead>
                                <tr>
                                    <th style="width: 110px;">Sản phẩm</th>
                                    <th>Mô tả</th>
                                    <th>Giá</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($cartItems as $item)

                                    <tr>
                                        <td><img src="{{ $item->product->image ?? '' }}" alt="Sản phẩm"
                                                 class="avatar-lg rounded"></td>
                                        <td>
                                            <h5 class="font-size-16 text-truncate">
                                                <a href="#" class="text-dark">{{ $item->product->name ?? '' }}</a>
                                            </h5>
                                            <p class="text-muted mb-0 mt-1">{{ number_format($item->product->discount_price) ?? '' }}
                                                VND x {{ $item->quantity ?? '' }}</p>
                                            <p class="text-muted mb-0 mt-1">Size {{ $item->size ?? '' }}</p>
                                        </td>
                                        <td>{{ number_format($item->product->discount_price * $item->quantity) ?? '' }}
                                            VND
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="2">Tạm tính:</td>
                                    <td>{{ number_format($totalPrice) }} VND</td>
                                </tr>
                                <tr>
                                    <td colspan="2">Phí vận chuyển:</td>
                                    <td>Miễn phí</td>
                                </tr>
                                <tr class="bg-light">
                                    <td colspan="2"><strong>Tổng cộng:</strong></td>
                                    <td><strong>{{ number_format($totalPrice) }} VND</strong></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>

        .card {
            margin-bottom: 24px;
            -webkit-box-shadow: 0 2px 3px #e4e8f0;
            box-shadow: 0 2px 3px #e4e8f0;
        }

        .card {
            position: relative;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid #eff0f2;
            border-radius: 1rem;
        }

        .activity-checkout {
            list-style: none
        }

        .activity-checkout .checkout-icon {
            position: absolute;
            top: -4px;
            left: -24px
        }

        .activity-checkout .checkout-item {
            position: relative;
            padding-bottom: 24px;
            padding-left: 35px;
            border-left: 2px solid #f5f6f8
        }

        .activity-checkout .checkout-item:first-child {
            border-color: #3b76e1
        }

        .activity-checkout .checkout-item:first-child:after {
            background-color: #3b76e1
        }

        .activity-checkout .checkout-item:last-child {
            border-color: transparent
        }

        .activity-checkout .checkout-item.crypto-activity {
            margin-left: 50px
        }

        .activity-checkout .checkout-item .crypto-date {
            position: absolute;
            top: 3px;
            left: -65px
        }


        .avatar-xs {
            height: 1rem;
            width: 1rem
        }

        .avatar-sm {
            height: 2rem;
            width: 2rem
        }

        .avatar {
            height: 3rem;
            width: 3rem
        }

        .avatar-md {
            height: 4rem;
            width: 4rem
        }

        .avatar-lg {
            height: 5rem;
            width: 5rem
        }

        .avatar-xl {
            height: 6rem;
            width: 6rem
        }

        .avatar-title {
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            background-color: #3b76e1;
            color: #fff;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            font-weight: 500;
            height: 100%;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            width: 100%
        }

        .avatar-group {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            padding-left: 8px
        }

        .avatar-group .avatar-group-item {
            margin-left: -8px;
            border: 2px solid #fff;
            border-radius: 50%;
            -webkit-transition: all .2s;
            transition: all .2s
        }

        .avatar-group .avatar-group-item:hover {
            position: relative;
            transform: translateY(-2px)
        }

        .card-radio {
            background-color: #fff;
            border: 2px solid #eff0f2;
            border-radius: .75rem;
            padding: .5rem;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: block
        }

        .card-radio:hover {
            cursor: pointer
        }

        .card-radio-label {
            display: block
        }

        .edit-btn {
            width: 35px;
            height: 35px;
            line-height: 40px;
            text-align: center;
            position: absolute;
            right: 25px;
            margin-top: -50px
        }

        .card-radio-input {
            display: none
        }

        .card-radio-input:checked + .card-radio {
            border-color: #3b76e1 !important
        }


        .font-size-16 {
            font-size: 16px !important;
        }

        .text-truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        a {
            text-decoration: none !important;
        }


        .form-control {
            display: block;
            width: 100%;
            padding: 0.47rem 0.75rem;
            font-size: .875rem;
            font-weight: 400;
            line-height: 1.5;
            color: #545965;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #e2e5e8;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-radius: 0.75rem;
            -webkit-transition: border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
        }

        .edit-btn {
            width: 35px;
            height: 35px;
            line-height: 40px;
            text-align: center;
            position: absolute;
            right: 25px;
            margin-top: -50px;
        }

        .ribbon {
            position: absolute;
            right: -26px;
            top: 20px;
            transform: rotate(45deg);
            color: #fff;
            font-size: 13px;
            font-weight: 500;
            padding: 1px 22px;
        }

    </style>
@endsection
