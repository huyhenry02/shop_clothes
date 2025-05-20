@php use App\Models\Product; @endphp
@extends('admin.layouts.main')
@section('content')
    <div class="page-inner">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Tìm kiếm:</label>
                        <input
                            type="text"
                            placeholder="Tìm kiếm theo tên, mã sản phẩm"
                            class="form-control search-input"
                            id="search-input"
                        />
                    </div>
                    <div class="col-md-4 position-relative">
                        <label class="form-label">Loại sản phẩm:</label>
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
                </div>
                <div class="row mt-3">
                    <div class="col-md-4 position-relative">
                        <label class="form-label">Giá tiền:</label>
                            <select name="sort_price" class="form-select filter-input" id="sort_price">
                                <option value="">Sắp xếp theo giá</option>
                                <option value="asc">⬆ Giá tăng dần</option>
                                <option value="desc">⬇ Giá giảm dần</option>
                            </select>
                    </div>
                    <div class="col-md-4 position-relative">
                        <label class="form-label">Số lượng trong kho:</label>
                        <select name="stock_quantity" class="form-select filter-input" id="sort_stock_quantity">
                            <option value="">Sắp xếp theo SL</option>
                            <option value="asc">⬆ SL tăng dần</option>
                            <option value="desc">⬇ SL giảm dần</option>
                        </select>
                    </div>
                    <div class="col-md-4 position-relative">
                        <label class="form-label">Trạng thái:</label>
                        <select name="is_active" class="form-select filter-input" id="is_active">
                            @foreach(Product::STATUSES as $key => $val)
                                <option value="{{ $key }}">{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h6>Danh sách sản phẩm</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table
                                class="display table table-bordered table-hover" id="account-table"
                            >
                                <thead>
                                <tr>
                                    <th width="3%">STT</th>
                                    <th>Mã</th>
                                    <th class="text-center">Ảnh</th>
                                    <th>Loại sản phẩm</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Giá niêm yết</th>
                                    <th>Giá khuyến mại</th>
                                    <th class="text-center">Số lượng</th>
                                    <th class="text-center">Thao tác</th>
                                </tr>
                                </thead>
                                <tbody id="product-table-body">
                                @include('admin.pages.product.table', ['products' => $products])
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            {!! $products->links('pagination::bootstrap-5') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.pages.product.detail')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function confirmDelete(url) {
            if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')) {
                window.location.href = url;
            }
        }
    </script>
    <script>
        $(document).on('click', '.btn-view-product', function () {
            const btn = $(this);

            $('#modal-image').attr('src', btn.data('image'));
            $('#modal-image_detail_1').attr('src', btn.data('image_detail_1'));
            $('#modal-image_detail_2').attr('src', btn.data('image_detail_2'));
            $('#modal-image_detail_3').attr('src', btn.data('image_detail_3'));
            $('#modal-code').text(btn.data('code'));
            $('#modal-name').text(btn.data('name'));
            $('#modal-category').text(btn.data('category'));
            $('#modal-slug').text(btn.data('slug'));
            $('#modal-description').text(btn.data('description'));
            $('#modal-price').text(btn.data('price'));
            $('#modal-discount_price').text(btn.data('discount_price'));
            $('#modal-stock_quantity').text(btn.data('stock_quantity'));
            $('#modal-color').text(btn.data('color'));
            $('#modal-material').text(btn.data('material'));
            $('#modal-style').text(btn.data('style'));
            $('#modal-is_active').text(btn.data('is_active'));
        });
    </script>
    <script>
        function filterProducts() {
            let keyword = $('#search-input').val();
            let sort_price = $('#sort_price').val();
            let stock_quantity = $('#sort_stock_quantity').val();
            let is_active = $('#is_active').val();

            let category_ids = [];
            $('input[name="category_ids[]"]:checked').each(function () {
                category_ids.push($(this).val());
            });

            $.ajax({
                url: "{{ route('admin.product.filter') }}",
                method: 'GET',
                data: {
                    keyword: keyword,
                    sort_price: sort_price,
                    stock_quantity: stock_quantity,
                    is_active: is_active,
                    category_ids: category_ids
                },
                success: function (res) {
                    $('#product-table-body').html(res.html);
                },
                error: function () {
                    alert('Đã xảy ra lỗi khi lọc sản phẩm.');
                }
            });
        }

        $(document).ready(function () {
            $('.filter-input, #search-input').on('input change', function () {
                filterProducts();
            });
        });
    </script>
@endsection
