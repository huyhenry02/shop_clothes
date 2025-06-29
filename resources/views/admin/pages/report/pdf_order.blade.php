<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thống kê đơn hàng</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background-color: #f0f0f0; }
        h2, p { text-align: center; margin: 0; }
        .date-range { margin-top: 10px; text-align: center; font-weight: bold; }
    </style>
</head>
<body>

<h2>THỐNG KÊ ĐƠN HÀNG</h2>
<p class="date-range">
    Thống kê đơn hàng theo {{ $type === 'quarter' ? 'quý' : 'tháng' }} - Năm {{ now()->year }}
</p>

<table>
    <thead>
    <tr>
        <th>{{ $type === 'quarter' ? 'Quý' : 'Tháng' }}</th>
        <th>Số lượng đơn hàng</th>
    </tr>
    </thead>
    <tbody>
    @foreach($labels as $index => $label)
        <tr>
            <td>{{ $label }}</td>
            <td>{{ $data[$index] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<p style="text-align: right; font-size: 11px;">Ngày xuất: {{ $generatedAt->format('d/m/Y H:i') }}</p>

</body>
</html>
