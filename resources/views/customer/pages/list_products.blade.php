@extends('customer.layouts.main')
@section('content')
    <div class="page-heading" id="top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-content">
                        <h2>Sản phẩm</h2>
                        <span>Khám phá các mẫu thời trang & phụ kiện nam hiện đại tại ROWAY</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="section" id="products">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-heading">
                        <h2>Sản phẩm mới nhất</h2>
                        <span>Khám phá tất cả các sản phẩm đang có tại ROWAY.</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                @foreach($products as $product)
                    @php
                        $category = $product->category;
                        $sizes = explode(',', $category->sizes);
                    @endphp
                    <div class="col-lg-4 mb-4">
                        <div class="item">
                            <div class="thumb">
                                <div class="hover-content">
                                    <ul>
                                        <li>
                                            <a href="{{ route('customer.showProductDetail', $product->id) }}" class="action-button">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('customer.addToCart') }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <input type="hidden" name="size" value="{{ $sizes[0] ?? 'M' }}">
                                                <button type="submit" class="action-button">
                                                    <i class="fa fa-shopping-cart"></i>
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                                <img src="{{ $product->image ?? '/customer/images/products/default.jpg' }}"
                                     alt="{{ $product->name }}">
                            </div>
                            <div class="down-content">
                                <h4>{{ $product->name ?? 'Sản phẩm không tên' }}</h4>
                                <span>{{ $product->discount_price ? number_format($product->discount_price) : 0 }} VND</span>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="col-lg-12">
                    <div class="pagination">
                        <ul>
                            @if ($products->onFirstPage())
                                <li class="disabled"><a href="#">&laquo;</a></li>
                            @else
                                <li><a href="{{ $products->previousPageUrl() }}">&laquo;</a></li>
                            @endif

                            @for ($i = 1; $i <= $products->lastPage(); $i++)
                                @if ($i == $products->currentPage())
                                    <li class="active"><a href="#">{{ $i }}</a></li>
                                @else
                                    <li><a href="{{ $products->url($i) }}">{{ $i }}</a></li>
                                @endif
                            @endfor

                            @if ($products->hasMorePages())
                                <li><a href="{{ $products->nextPageUrl() }}">&raquo;</a></li>
                            @else
                                <li class="disabled"><a href="#">&raquo;</a></li>
                            @endif
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <style>
        .action-button {
            display: inline-block !important;
            background: white !important;
            border: none !important;
            width: 40px !important;
            height: 40px !important;
            line-height: 40px !important;
            text-align: center !important;
            border-radius: 4px !important;
            font-size: 16px !important;
            color: black !important;
            transition: all 0.3s ease-in-out !important;
        }
        .action-button:hover {
            background: #f2f2f2 !important;
            color: #333 !important;
        }
        .hover-content ul {
            display: flex !important;
            justify-content: center !important;
            gap: 10px !important;
            list-style: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }
    </style>
@endsection
