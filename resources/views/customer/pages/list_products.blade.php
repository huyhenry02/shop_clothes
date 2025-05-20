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
                <div class="col-lg-12">
                    <div class="section-heading">
                        <div class="product-filters border rounded p-3 mb-4 shadow-sm bg-white">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-6">
                                    <input type="text" name="keyword" id="keyword"
                                           class="form-control filter-input" placeholder="🔍 Tìm sản phẩm theo tên...">
                                </div>

                                <div class="col-md-3 position-relative">
                                    <div class="dropdown w-100">
                                        <button class="btn btn-outline-secondary w-100 text-start dropdown-toggle"
                                                type="button" data-bs-toggle="dropdown">
                                            🗂 Chọn loại sản phẩm
                                        </button>
                                        <ul class="dropdown-menu p-3"
                                            style="max-height: 250px; overflow-y: auto; width: 100%;">
                                            @foreach($categories as $category)
                                                <li class="form-check">
                                                    <input class="form-check-input filter-input" type="checkbox"
                                                           name="category_ids[]" value="{{ $category->id }}"
                                                           id="cat-{{ $category->id }}">
                                                    <label class="form-check-label" for="cat-{{ $category->id }}">
                                                        {{ $category->name }}
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <select name="sort_price" class="form-select filter-input" id="sort_price">
                                        <option value="">⇅ Sắp xếp theo giá</option>
                                        <option value="asc">⬆ Giá tăng dần</option>
                                        <option value="desc">⬇ Giá giảm dần</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div id="product-list" class="row">
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
                                            <a href="{{ route('customer.showProductDetail', $product->id) }}"
                                               class="action-button">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('customer.addToCart') }}" method="POST"
                                                  class="d-inline">
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

        .product-filters {
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }

        .product-filters input,
        .product-filters select {
            border-radius: 6px;
            border: 1px solid #ccc;
        }

    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            function filterProducts() {
                const keyword = $('#keyword').val();
                const sort_price = $('#sort_price').val();
                const category_ids = [];
                $('input[name="category_ids[]"]:checked').each(function () {
                    category_ids.push($(this).val());
                });

                $.ajax({
                    url: "{{ route('customer.filterProducts') }}",
                    method: 'GET',
                    data: {
                        keyword: keyword,
                        sort_price: sort_price,
                        category_ids: category_ids
                    },
                    success: function (response) {
                        $('#product-list').html(response.html);
                    }
                });
            }

            $('.filter-input').on('input change', function () {
                filterProducts();
            });
        });
    </script>
@endsection
