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
                            placeholder="Tìm kiếm theo mã đơn, tên người nhận, số điện thoại"
                            class="form-control filter-input"
                            id="keyword"
                        />
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Sô điện thoại khách hàng:</label>
                        <input
                            type="text"
                            placeholder="Nhập số điện thoại đặt đơn"
                            class="form-control filter-input"
                            id="phone_order"
                        />
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <label class="form-label">Phương thức thanh toán:</label>
                        <select name="payment_method" class="form-select filter-input" id="payment_method">
                            <option value="">Chọn phương thức</option>
                            @foreach(Order::PAYMENT_METHODS as $key => $val)
                                <option value="{{ $key }}">{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Trạng thái thanh toán:</label>
                        <select name="payment_status" class="form-select filter-input" id="payment_status">
                            <option value="">Chọn trạng thái</option>
                            @foreach(Order::PAYMENT_STATUSES as $key => $val)
                                <option value="{{ $key }}">{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Trạng thái đơn hàng:</label>
                        <select name="status" class="form-select filter-input" id="status">
                            <option value="">Chọn trạng thái</option>
                            @foreach(Order::STATUSES as $key => $val)
                                <option value="{{ $key }}">{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>
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
                            <tbody id="order-table-body">
                            @include('admin.pages.order.table  ', ['orders' => $orders])
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function filterOrders() {
            let keyword = $('#keyword').val();
            let phone_order = $('#phone_order').val();
            let payment_method = $('#payment_method').val();
            let payment_status = $('#payment_status').val();
            let status = $('#status').val();

            $.ajax({
                url: "{{ route('admin.order.filter') }}",
                method: 'GET',
                data: {
                    keyword: keyword,
                    phone_order: phone_order,
                    payment_method: payment_method,
                    payment_status: payment_status,
                    status: status
                },
                success: function (res) {
                    $('#order-table-body').html(res.html);
                },
                error: function () {
                    alert('Lỗi khi lọc đơn hàng.');
                }
            });
        }

        $(document).ready(function () {
            $('.filter-input').on('input change', function () {
                filterOrders();
            });
        });
    </script>

@endsection
