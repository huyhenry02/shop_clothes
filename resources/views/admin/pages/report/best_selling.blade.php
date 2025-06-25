@extends('admin.layouts.main')
@section('content')
    <div class="page-inner">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Ngày bắt đầu:</label>
                        <input type="date" id="start_date" class="form-control filter-input">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Ngày kết thúc:</label>
                        <input type="date" id="end_date" class="form-control filter-input">
                    </div>
                    <div class="col-md-4 position-relative">
                        <label class="form-label">Số lương:</label>
                        <select name="sort_quantity" class="form-select filter-input" id="sort_quantity">
                            <option value="">Sắp xếp theo SL bán được</option>
                            <option value="asc">⬆ SL tăng dần</option>
                            <option value="desc">⬇ SL giảm dần</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex">
                        <div class="d-flex align-items-center">
                            <h6>Danh sách sản phẩm bán chạy</h6>
                        </div>
                        <button type="button" onclick="confirmDownload('{{ route('admin.report.exportPdfBestSelling') }}')"
                                class="btn btn-warning ms-auto">
                            <i class="fas fa-file-pdf"></i>
                        </button>
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
                                    <th width="40%">Tên sản phẩm</th>
                                    <th class="text-center" width="20%">Số lượng bán được</th>
                                </tr>
                                </thead>
                                <tbody id="product-table-body">
                                @include('admin.pages.report.table_best_selling', ['data' => $data])
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function confirmDownload(baseUrl) {
        if (confirm('Bạn có chắc chắn muốn in thống kê không?')) {
            const start = $('#start_date').val();
            const end = $('#end_date').val();
            const sort = $('#sort_quantity').val();
            const query = `?start_date=${start}&end_date=${end}&sort_quantity=${sort}`;
            window.open(baseUrl + query, '_blank');
        }
    }
</script>
<script>
    function fetchBestSelling() {
        const startDate = $('#start_date').val();
        const endDate = $('#end_date').val();
        const sortQuantity = $('#sort_quantity').val();

        $.ajax({
            url: "{{ route('admin.report.getBestSellingData') }}",
            method: "GET",
            data: {
                start_date: startDate,
                end_date: endDate,
                sort_quantity: sortQuantity
            },
            success: function (res) {
                $('#product-table-body').html(res.html);
            },
            error: function () {
                alert("Lỗi khi tải dữ liệu!");
            }
        });
    }

    $(document).ready(function () {
        // Gọi API ngay khi vào trang
        fetchBestSelling();

        // Gọi lại khi chọn filter
        $('.filter-input').on('change', function () {
            fetchBestSelling();
        });
    });
</script>

