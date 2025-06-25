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
                            placeholder="Tìm kiếm theo mã hóa đơn, tên khách hàng, số điện thoại"
                            class="form-control filter-input"
                            id="keyword"
                        />
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <label class="form-label">Phương thức thanh toán:</label>
                        <select name="payment_method" class="form-select filter-input" id="payment_method">
                            <option value="">Chọn phương thức</option>
                            @foreach(Invoice::PAYMENT_METHODS as $key => $val)
                                <option value="{{ $key }}">{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Trạng thái thanh toán:</label>
                        <select name="payment_status" class="form-select filter-input" id="payment_status">
                            <option value="">Chọn trạng thái</option>
                            @foreach(Invoice::PAYMENT_STATUSES as $key => $val)
                                <option value="{{ $key }}">{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Trạng thái hóa đơn:</label>
                        <select name="status" class="form-select filter-input" id="status">
                            <option value="">Chọn trạng thái</option>
                            @foreach(Invoice::STATUSES as $key => $val)
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
                                    <th class="text-center" width="15%">Thao tác</th>
                                </tr>
                                </thead>
                                <tbody id="invoice-table-body">
                                @include('admin.pages.invoice.table', ['invoices' => $invoices])
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function filterInvoices() {
            let keyword = $('#keyword').val();
            let payment_method = $('#payment_method').val();
            let payment_status = $('#payment_status').val();
            let status = $('#status').val();

            $.ajax({
                url: "{{ route('admin.invoice.filter') }}",
                method: 'GET',
                data: {
                    keyword: keyword,
                    payment_method: payment_method,
                    payment_status: payment_status,
                    status: status
                },
                success: function (res) {
                    $('#invoice-table-body').html(res.html);
                },
                error: function () {
                    alert('Lỗi khi lọc hóa đơn.');
                }
            });
        }

        $(document).ready(function () {
            $('.filter-input').on('input change', function () {
                filterInvoices();
            });
        });
    </script>
@endsection
