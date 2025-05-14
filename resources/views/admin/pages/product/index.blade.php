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
                                            <img src="{{ $val->image ?? 'N/A' }}" alt="" srcset="" width="100px" height="100px">
                                        </td>
                                        <td>{{ $val->category?->name ?? 'N/A' }}</td>
                                        <td>{{ $val->name ?? 'N/A' }}</td>
                                        <td>{{ $val->price ? number_format($val->price) : 'N/A' }} VND</td>
                                        <td>{{ $val->discount_price ? number_format($val->discount_price) : 'N/A' }} VND</td>
                                        <td class="text-center">{{ $val->stock_quantity ?? 'N/A' }}</td>
                                        <td class="text-center">
                                            <a href=""
                                               class="btn btn-sm btn-warning">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href=""
                                               class="btn btn-sm btn-secondary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button class="btn btn-sm btn-danger"
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
@endsection
