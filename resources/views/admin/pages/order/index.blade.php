@php use App\Models\Order;use Carbon\Carbon; @endphp
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
                            <h6>Danh sách đơn hàng</h6>
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
                                    <th>Mã đơn</th>
                                    <th class="text-center">Tên người nhận</th>
                                    <th class="text-center">Số điện thoại</th>
                                    <th class="text-center">Trạng thái đơn hàng</th>
                                    <th class="text-center" width="12%">Trạng thái thanh toán</th>
                                    <th class="text-center" width="12%">Phương thức thanh toán</th>
                                    <th class="text-center">Tổng tiền</th>
                                    <th class="text-center" width="10%">Thao tác</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $key => $val)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $val->order_code ?? 'N/A' }}</td>
                                        <td>{{ $val->shipping_name ?? 'N/A' }}</td>
                                        <td class="text-center">{{ $val->shipping_phone ?? 'N/A' }}</td>
                                        <td class="text-center">{{ $val->status ? Order::STATUSES[$val->status] : 'N/A' }}</td>
                                        <td class="text-center">{{ $val->payment_status ? Order::PAYMENT_STATUSES[$val->payment_status] : 'N/A' }}</td>
                                        <td class="text-center">{{ $val->payment_method ? Order::PAYMENT_METHODS[$val->payment_method] : 'N/A' }}</td>
                                        <td class="text-center">{{ $val->total_amount ? number_format($val->total_amount) : 'N/A' }}</td>
                                        <td class="text-center">
                                            <button
                                                class="btn btn-sm btn-info btn-view-product"
                                                data-bs-toggle="modal"
                                                data-bs-target="#orderModal{{ $val->id }}"
                                            >
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <a href="{{ route('admin.order.showUpdate', $val->id) }}"
                                               class="btn btn-sm btn-secondary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @include('admin.pages.order.detail')
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            {!! $orders->links('pagination::bootstrap-5') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
