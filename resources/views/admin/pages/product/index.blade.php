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
                            placeholder="Tìm kiếm theo tên"
                            class="form-control search-input"
                            id="search-input"
                        />
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
                                <tbody>
                                @foreach($products as $key => $val)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $val->code ?? 'N/A' }}</td>
                                        <td class="text-center">
                                            <img src="{{ $val->image ?? 'N/A' }}" alt="" srcset="" width="100px"
                                                 height="100px">
                                        </td>
                                        <td>{{ $val->category?->name ?? 'N/A' }}</td>
                                        <td>{{ $val->name ?? 'N/A' }}</td>
                                        <td>{{ $val->price ? number_format($val->price) : 'N/A' }} VND</td>
                                        <td>{{ $val->discount_price ? number_format($val->discount_price) : 'N/A' }}
                                            VND
                                        </td>
                                        <td class="text-center">{{ $val->stock_quantity ?? 'N/A' }}</td>
                                        <td class="text-center">
                                            <button
                                                class="btn btn-sm btn-info btn-view-product"
                                                data-bs-toggle="modal"
                                                data-bs-target="#productDetailModal"
                                                data-image="{{ $val->image ?? '/customer/images/products/default.jpg' }}"
                                                data-code="{{ $val->code ?? '' }}"
                                                data-name="{{ $val->name ?? '' }}"
                                                data-category="{{ $val->category?->name ?? '' }}"
                                                data-slug="{{ $val->slug ?? '' }}"
                                                data-description="{{ $val->description ?? '' }}"
                                                data-price="{{ $val->price ? number_format($val->price) : '' }}"
                                                data-discount_price="{{ $val->discount_price ? number_format($val->discount_price) : '' }}"
                                                data-stock_quantity="{{ $val->stock_quantity ?? '' }}"
                                                data-image_detail_1="{{ $val->image_detail_1 ?? '/customer/images/products/default.jpg' }}"
                                                data-image_detail_2="{{ $val->image_detail_2 ?? '/customer/images/products/default.jpg' }}"
                                                data-image_detail_3="{{ $val->image_detail_3 ?? '/customer/images/products/default.jpg' }}"
                                                data-color="{{ $val->color ?? '' }}"
                                                data-material="{{ $val->material ?? '' }}"
                                                data-style="{{ $val->style ? Product::STYLES[$val->style] : '' }}"
                                                data-is_active="{{ $val->is_active ? Product::STATUSES[$val->is_active] : '' }}"
                                            >
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <a href="{{ route('admin.product.putProduct', $val->id) }}"
                                               class="btn btn-sm btn-secondary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button class="btn btn-sm btn-danger"
                                                    onclick="confirmDelete('{{ route('admin.product.delete', $val->id) }}')"
                                            >
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
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
@endsection
