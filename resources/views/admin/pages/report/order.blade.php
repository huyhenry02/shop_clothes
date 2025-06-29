@extends('admin.layouts.main')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-stats card-round">
                <div class="d-flex card-header">
                    <div class="form-inline">
                        <label for="timeType" class="mr-2">Chọn loại thời gian:</label>
                        <select id="timeType" class="form-control mt-2">
                            <option value="year">Theo Năm</option>
                            <option value="quarter">Theo Quý</option>
                        </select>
                    </div>
                    <button type="button" onclick="confirmDownload('{{ route('admin.report.exportPdfOrder') }}')"
                            class="btn btn-warning ms-auto">
                        <i class="fas fa-file-pdf"></i>
                    </button>
                </div>
                <div class="card-body">
                    <section class="chart-section container mt-5">
                        <div id="loading" class="text-center mb-4" style="display: none;">
                            <span>Đang tải dữ liệu...</span>
                        </div>
                        <canvas id="revenueChart" class="w-100"></canvas>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .chart-section {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .chart-section h3 {
            font-weight: 600;
            color: #343a40;
        }

        canvas {
            max-height: 550px;
        }
    </style>
    <script>
        function confirmDownload(url) {
            const timeType = $('#timeType').val();
            const fullUrl = url + '?type=' + timeType;
            window.open(fullUrl, '_blank');
        }

    </script>
    <script>
        $(document).ready(function () {
            const ctx = document.getElementById('revenueChart').getContext('2d');
            let revenueChart;

            function fetchData(timeType) {
                $('#loading').show();

                $.ajax({
                    url: '{{ route("admin.report.getOrderData") }}',
                    method: 'GET',
                    data: {type: timeType},
                    success: function (response) {
                        $('#loading').hide();

                        const labels = response.labels;
                        const data = response.data;

                        if (revenueChart) revenueChart.destroy();

                        revenueChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Đơn hàng',
                                    data: data,
                                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    }
                });
            }

            $('#timeType').on('change', function () {
                fetchData($(this).val());
            });

            fetchData('year');
        });
    </script>
@endsection
