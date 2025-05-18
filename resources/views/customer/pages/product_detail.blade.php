@php use App\Models\Product; @endphp
@extends('customer.layouts.main')
@section('content')
    <div class="page-heading" id="top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-content">
                        <h2>Sản phẩm</h2>
                        <span>Khám phá chi tiết thông tin sản phẩm và thêm vào giỏ hàng</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="section" id="product">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="left-images">
                        <img src="{{ $product->image ?? '/customer/images/products/default.jpg' }}" alt="" width="700px"
                             height="700px">
                        <div class="row mt-3">
                            <div class="col-4">
                                <img src="{{ $product->image_detail_1 ?? '/customer/images/products/default.jpg' }}"
                                     alt="">
                            </div>
                            <div class="col-4">
                                <img src="{{ $product->image_detail_2 ?? '/customer/images/products/default.jpg' }}"
                                     alt="">
                            </div>
                            <div class="col-4">
                                <img src="{{ $product->image_detail_3 ?? '/customer/images/products/default.jpg' }}"
                                     alt="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="right-content">
                        <h4>{{ $product->name ?? '' }}</h4>
                        <p>
                            <span style="text-decoration: line-through; color: gray;">
                                {{ $product->price ? number_format($product->price) : '' }} VND
                            </span>
                            &nbsp;
                            <span style="font-weight: bold; font-size: 20px; color: black;">
                                {{ $product->discount_price ? number_format($product->discount_price) : '' }} VND
                            </span>
                        </p>
                        <div class="quote">
                            <i class="fa fa-quote-left"></i>
                            <p>{{ $product->description ?? '' }}</p>
                        </div>

                        <table class="table table-bordered mt-4">
                            <tr>
                                <th>Loại sản phẩm</th>
                                <td>{{ $product->category->name ?? 'Đang cập nhật' }}</td>
                            </tr>
                            <tr>
                                <th>Màu sắc</th>
                                <td>{{ $product->color ?? 'Đang cập nhật' }}</td>
                            </tr>
                            <tr>
                                <th>Chất liệu</th>
                                <td>{{ $product->material ?? 'Đang cập nhật' }}</td>
                            </tr>
                            <tr>
                                <th>Phong cách</th>
                                <td>{{ $product->style ? Product::STYLES[$product->style] :  'Đang cập nhật' }}</td>
                            </tr>
                        </table>
                        <form id="add-to-cart-form" action="{{ route('customer.addToCart') }}" method="POST">
                            <div class="quantity-content">
                                <div class="left-content">
                                    <h6>Số lượng</h6>
                                </div>
                                <div class="right-content">
                                    <div class="quantity buttons_added">
                                        <input type="button" value="-" class="minus">
                                        <input type="number" step="1" min="1" name="quantity" id="quantity-input"
                                               value="1"
                                               class="input-text qty text">
                                        <input type="button" value="+" class="plus">
                                    </div>
                                </div>
                                <div class="left-content mt-3">
                                    <h6>Size</h6>
                                </div>
                                <div class="right-content mt-3">
                                    <div class="col-auto">
                                        <ul class="list-inline pb-3">
                                            @foreach($sizesArray as $size)
                                                <li class="list-inline-item">
                                                    <button type="button" class="btn btn-outline-secondary btn-size"
                                                            data-size="{{ $size }}">{{ $size }}</button>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="total mt-3">
                                <h4>Kho: {{ $product->stock_quantity ?? '0' }}</h4>
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="size" id="selected-size">
                                <div class="main-border-button mt-2">
                                    <button type="submit" class="btn btn-outline-secondary mt-2">Thêm giỏ hàng</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const minusBtn = document.querySelector('.minus');
            const plusBtn = document.querySelector('.plus');
            const qtyInput = document.getElementById('quantity-input');

            minusBtn.addEventListener('click', () => {
                let qty = parseInt(qtyInput.value);
                if (qty > 1) qtyInput.value = qty - 1;
            });

            plusBtn.addEventListener('click', () => {
                let qty = parseInt(qtyInput.value);
                qtyInput.value = qty + 1;
            });

            const sizeButtons = document.querySelectorAll('.btn-size');
            const selectedSizeInput = document.getElementById('selected-size');

            sizeButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    sizeButtons.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    selectedSizeInput.value = btn.getAttribute('data-size');
                });
            });

            const form = document.getElementById('add-to-cart-form');
            form.addEventListener('submit', function (e) {
                if (!selectedSizeInput.value) {
                    e.preventDefault();
                    alert('Vui lòng chọn size trước khi thêm vào giỏ hàng!');
                }
            });
        });
    </script>
@endsection
