@php use App\Models\Invoice;use Carbon\Carbon; @endphp
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
                            <h6>Danh sách hóa đơn</h6>
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
                                    <th>Mã hóa đơn</th>
                                    <th class="text-center">Tên khách hàng</th>
                                    <th class="text-center">Số điện thoại</th>
                                    <th class="text-center">Trạng thái</th>
                                    <th class="text-center" width="12%">Trạng thái thanh toán</th>
                                    <th class="text-center" width="12%">Phương thức thanh toán</th>
                                    <th class="text-center">Tổng tiền</th>
                                    <th class="text-center" width="12%">Thao tác</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($invoices as $key => $val)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $val->invoice_code ?? 'N/A' }}</td>
                                        <td>{{ $val->customer_name ?? 'N/A' }}</td>
                                        <td class="text-center">{{ $val->customer_phone ?? 'N/A' }}</td>
                                        <td class="text-center">{{ $val->status ? Invoice::STATUSES[$val->status] : 'N/A' }}</td>
                                        <td class="text-center">{{ $val->payment_status ? Invoice::PAYMENT_STATUSES[$val->payment_status] : 'N/A' }}</td>
                                        <td class="text-center">{{ $val->payment_method ? Invoice::PAYMENT_METHODS[$val->payment_method] : 'N/A' }}</td>
                                        <td class="text-center">{{ $val->total_amount ? number_format($val->total_amount) : 'N/A' }}</td>
                                        <td class="text-center">
                                            <button
                                                class="btn btn-sm btn-info btn-view-product"
                                                data-bs-toggle="modal"
                                                data-bs-target="#invoiceModal{{ $val->id }}"
                                            >
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <a href="{{ route('admin.invoice.showUpdate', $val->id) }}"
                                               class="btn btn-sm btn-secondary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button class="btn btn-sm btn-danger"
                                                    onclick="confirmDelete('{{ route('admin.invoice.delete', $val->id) }}')"
                                            >
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @include('admin.pages.invoice.detail')
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            {!! $invoices->links('pagination::bootstrap-5') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function confirmDelete(url) {
            if (confirm('Bạn có chắc chắn muốn xóa hóa đơn này không?')) {
                window.location.href = url;
            }
        }
    </script>
@endsection
