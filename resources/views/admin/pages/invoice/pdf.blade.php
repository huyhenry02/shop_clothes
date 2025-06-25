<!DOCTYPE html>
<html lang="vi">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Hóa đơn #{{ $invoice->invoice_code }}</title>
    <style>
        @font-face {
            font-family: 'DejaVu Sans';
            font-style: normal;
            font-weight: normal;
            src: url('{{ storage_path('fonts/DejaVuSans.ttf') }}') format('truetype');
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }
        .invoice-container {
            max-width: 210mm;
            margin: 0 auto;
            padding: 20px;
            box-sizing: border-box;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        .store-name {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        .store-slogan {
            color: #7f8c8d;
            margin-bottom: 15px;
        }
        .invoice-title {
            font-size: 20px;
            margin: 15px 0;
            color: #2c3e50;
            text-transform: uppercase;
        }
        .info-section {
            display: flex;
            flex-wrap: nowrap;
            gap: 20px;
            margin-bottom: 20px;
        }

        .info-box {
            flex: 1 1 0;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #eee;
            border-radius: 4px;
        }
        .info-box h3 {
            margin: 0 0 10px 0;
            padding-bottom: 5px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
            color: #2c3e50;
        }
        .info-item {
            margin-bottom: 5px;
            display: flex;
        }
        .info-label {
            font-weight: bold;
            min-width: 120px;
        }
        .info-value {
            flex: 1;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .invoice-table th {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
            font-weight: bold;
        }
        .invoice-table td {
            border: 1px solid #dee2e6;
            padding: 8px;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .total-section {
            margin-left: auto;
            width: 300px;
            margin-top: 20px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        .total-label {
            font-weight: bold;
        }
        .total-amount {
            font-size: 16px;
            font-weight: bold;
            color: #e74c3c;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #7f8c8d;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="header">
            <div class="store-name">ROWAY FASHION</div>
            <div class="store-slogan">Thời trang hiện đại cho mọi nhà</div>
            <h1 class="invoice-title">HÓA ĐƠN BÁN HÀNG</h1>
            <p>Mã hóa đơn: <strong>{{ $invoice->invoice_code }}</strong> | Ngày tạo: {{ $invoice->created_at->format('d/m/Y H:i') }}</p>
        </div>

        <div class="info-section">
            <table style="width: 100%; margin-bottom: 20px; border-collapse: collapse;">
                <tr>
                    <td style="width: 50%; vertical-align: top; padding: 10px; border: 1px solid #eee; border-right: none;">
                        <h3 style="margin-top: 0; font-size: 14px; color: #2c3e50; border-bottom: 1px solid #eee; padding-bottom: 5px;">Thông tin khách hàng</h3>
                        <p><strong>Tên khách hàng:</strong> {{ $invoice->customer_name }}</p>
                        <p><strong>Số điện thoại:</strong> {{ $invoice->customer_phone }}</p>
                        @if($invoice->customer_email)
                            <p><strong>Email:</strong> {{ $invoice->customer_email }}</p>
                        @endif
                    </td>
                    <td style="width: 50%; vertical-align: top; padding: 10px; border: 1px solid #eee; border-left: none;">
                        <h3 style="margin-top: 0; font-size: 14px; color: #2c3e50; border-bottom: 1px solid #eee; padding-bottom: 5px;">Thông tin thanh toán</h3>
                        <p><strong>Phương thức:</strong> {{ $invoice->payment_method === 'cash' ? 'Tiền mặt' : 'Chuyển khoản' }}</p>
                        <p><strong>Trạng thái:</strong>
                            @if($invoice->payment_status === 'paid')
                                <span style="color: #27ae60; font-weight: bold;">Đã thanh toán</span>
                            @elseif($invoice->payment_status === 'pending')
                                <span style="color: #f39c12; font-weight: bold;">Chờ thanh toán</span>
                            @else
                                <span style="color: #e74c3c; font-weight: bold;">Đã hủy</span>
                            @endif
                        </p>
                        @if($invoice->payment_time)
                            <p><strong>Thời gian TT:</strong> {{ $invoice->payment_time }}</p>
                        @endif
                    </td>
                </tr>
            </table>

        </div>

        <h3>Chi tiết đơn hàng</h3>
        <table class="invoice-table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Sản phẩm</th>
                    <th>Size</th>
                    <th>Đơn giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->invoiceDetails as $index => $detail)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $detail->product->name }}</td>
                        <td class="text-center">{{ $detail->size }}</td>
                        <td class="text-right">{{ number_format($detail->total_price / $detail->quantity) }} đ</td>
                        <td class="text-center">{{ $detail->quantity }}</td>
                        <td class="text-right">{{ number_format($detail->total_price) }} đ</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" class="text-right"><strong>Tổng cộng:</strong></td>
                    <td class="text-right"><strong>{{ number_format($invoice->total_amount) }} đ</strong></td>
                </tr>
            </tfoot>
        </table>

        <div class="footer">
            <p>Cảm ơn quý khách đã mua hàng tại ROWAY!</p>
            <p>Mọi thắc mắc xin liên hệ: 0123 456 789 | Email: support@roway.vn</p>
            <p>Địa chỉ: 123 Đường ABC, Quận 1, TP.HCM</p>
        </div>
    </div>
</body>
</html>
