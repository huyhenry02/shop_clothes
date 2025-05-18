@extends('customer.layouts.main')
@section('content')
    <div class="page-heading about-page-heading" id="top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-content">
                        <h2>Giỏ hàng</h2>
                        <span>Kiểm tra sản phẩm và hoàn tất đơn hàng của bạn cùng ROWAY</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12">
                    <div class="card card-registration card-registration-2" style="border-radius: 15px;">
                        <div class="card-body p-0">
                            <div class="row g-0">
                                <div class="col-lg-9">
                                    <div class="p-5">
                                        <div class="d-flex justify-content-between align-items-center mb-5">
                                            <h4 class="fw-bold mb-0">Giỏ hàng của bạn</h4>
                                            <h6 class="mb-0 text-muted">{{ $carts->count() ?? 0 }} sản phẩm</h6>
                                        </div>
                                        <hr class="my-4">
                                        @if ($carts->isEmpty())
                                            <div class="text-center py-5">
                                                <h5>Hiện tại bạn chưa có sản phẩm nào trong giỏ hàng.</h5>
                                                <a href="{{ route('customer.showIndex') }}"
                                                   class="btn btn-outline-secondary mt-3">
                                                    <i class="fa fa-arrow-left me-2"></i> Tiếp tục mua sắm
                                                </a>
                                            </div>
                                        @else
                                            @foreach($carts as $cartItem)
                                                <div class="cart-item" data-id="{{ $cartItem->id }}">
                                                    <div class="row mb-4 align-items-center">
                                                        <div class="col-2">
                                                            <img
                                                                src="{{ $cartItem->product->image ?? '/customer/images/products/default.jpg' }}"
                                                                class="img-fluid rounded-3" alt="">
                                                        </div>
                                                        <div class="col-3">
                                                            <h6 class="text-muted">{{ $cartItem->product->category->name }}</h6>
                                                            <h6 class="mb-0">{{ $cartItem->product->name }}</h6>
                                                        </div>
                                                        <div class="col-2 text-center">
                                                            @php
                                                                $sizes = explode(',', $cartItem->product->category->sizes);
                                                            @endphp
                                                            <select class="form-select form-size"
                                                                    data-id="{{ $cartItem->id }}">
                                                                @foreach($sizes as $size)
                                                                    <option
                                                                        value="{{ $size }}" {{ $cartItem->size == $size ? 'selected' : '' }}>{{ $size }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-2">
                                                            <div class="quantity buttons_added">
                                                                <input type="button" value="-" class="minus"
                                                                       data-id="{{ $cartItem->id }}">
                                                                <input type="number" step="1" min="1"
                                                                       name="quantity"
                                                                       class="input-text qty-input"
                                                                       data-id="{{ $cartItem->id }}"
                                                                       value="{{ $cartItem->quantity }}">
                                                                <input type="button" value="+" class="plus"
                                                                       data-id="{{ $cartItem->id }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-2">
                                                            <h6 class="mb-0 total-item-price"
                                                                id="item-price-{{ $cartItem->id }}">
                                                                {{ number_format($cartItem->quantity * $cartItem->product->discount_price) }}
                                                                VND
                                                            </h6>
                                                        </div>
                                                        <div class="col-1 text-end">
                                                            <a href="#" class="text-danger btn-delete-cart"
                                                               data-id="{{ $cartItem->id }}"><i class="fa fa-trash"></i></a>
                                                        </div>
                                                    </div>
                                                    <hr class="my-4">
                                                </div>
                                            @endforeach
                                            <div class="pt-5">
                                                <h6 class="mb-0">
                                                    <a href="{{ route('customer.showIndex') }}" class="text-body">
                                                        <i class="fa fa-arrow-left me-2"></i>Tiếp tục mua sắm
                                                    </a>
                                                </h6>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-3 bg-body-tertiary">
                                    <div class="p-5">
                                        <h4 class="fw-bold mb-5 mt-2 pt-1">Tổng kết đơn hàng</h4>
                                        <hr class="my-4">

                                        <div class="d-flex justify-content-between mb-4">
                                            <h6 class="text-uppercase">Số lượng sản phẩm</h6>
                                            <h6>{{ $carts->count() ?? 0 }} </h6>
                                        </div>

                                        <div class="d-flex justify-content-between mb-4">
                                            <h6 class="text-uppercase">Phí vận chuyển</h6>
                                            <h6>Miễn phí</h6>
                                        </div>

                                        <hr class="my-4">

                                        <div class="d-flex justify-content-between mb-5">
                                            <h6 class="text-uppercase">Tổng cộng</h6>
                                            <h6 id="cart-total">
                                                {{ number_format($carts->sum(fn($item) => $item->product->discount_price * $item->quantity)) }}
                                                VND
                                            </h6>
                                        </div>
                                        <div class="text-center w-100">
                                            <button type="button" class="btn btn-dark btn-block btn-lg">
                                                Thanh toán ngay
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            function updateCart(id, field, value) {
                fetch("{{ route('customer.updateCart') }}", {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({id, field, value})
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('item-price-' + id).innerText = data.priceItemCart;

                            document.getElementById('cart-total').innerText = data.totalPrice;
                        }
                    });
            }

            document.querySelectorAll('.qty-input').forEach(input => {
                input.addEventListener('change', e => {
                    const id = e.target.dataset.id;
                    updateCart(id, 'quantity', e.target.value);
                });
            });

            document.querySelectorAll('.plus, .minus').forEach(btn => {
                btn.addEventListener('click', e => {
                    const id = e.target.dataset.id;
                    const input = document.querySelector('.qty-input[data-id="' + id + '"]');
                    let value = parseInt(input.value);
                    value = e.target.classList.contains('plus') ? value + 1 : Math.max(1, value - 1);
                    input.value = value;
                    updateCart(id, 'quantity', value);
                });
            });

            document.querySelectorAll('.form-size').forEach(select => {
                select.addEventListener('change', e => {
                    const id = e.target.dataset.id;
                    updateCart(id, 'size', e.target.value);
                });
            });

            document.querySelectorAll('.btn-delete-cart').forEach(btn => {
                btn.addEventListener('click', e => {
                    e.preventDefault();
                    const id = btn.dataset.id;
                    if (confirm("Bạn có chắc muốn xoá sản phẩm này khỏi giỏ hàng?")) {
                        fetch("{{ route('customer.deleteCart') }}", {
                            method: "POST",
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({id})
                        })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    document.querySelector('.cart-item[data-id="' + id + '"]').remove();
                                    document.getElementById('cart-total').innerText = data.totalPrice;
                                    window.location.reload();
                                }
                            });
                    }
                });
            });
        });
    </script>
    <style>
        @media (min-width: 1025px) {
            .h-custom {
                height: 100vh !important;
            }
        }

        .card-registration .select-input.form-control[readonly]:not([disabled]) {
            font-size: 1rem;
            line-height: 2.15;
            padding-left: .75em;
            padding-right: .75em;
        }

        .card-registration .select-arrow {
            top: 13px;
        }

        .qty-input {
            width: 50px;
            height: 32px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .quantity input[type="button"] {
            width: 32px;
            height: 32px !important;
            background: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
        }

    </style>
@endsection
