<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thống kê sản phẩm bán chạy</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background-color: #f0f0f0; }
        h2, p { text-align: center; margin: 0; }
        .date-range { margin-top: 10px; text-align: center; }
    </style>
</head>
<body>
<h2>THỐNG KÊ SẢN PHẨM BÁN CHẠY</h2>
<p class="date-range">
    @if($startDate || $endDate)
        Từ {{ $startDate ? date('d/m/Y', strtotime($startDate)) : '__/__/____' }}
        đến {{ $endDate ? date('d/m/Y', strtotime($endDate)) : '__/__/____' }}
    @else
        (Tất cả dữ liệu)
    @endif
</p>
<p style="text-align: right; font-size: 11px;">Ngày xuất: {{ $generatedAt->format('d/m/Y H:i') }}</p>

<table>
    <thead>
    <tr>
        <th>STT</th>
        <th>Mã</th>
        <th>Tên sản phẩm</th>
        <th>Loại sản phẩm</th>
        <th>Số lượng bán được</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->code ?? 'N/A' }}</td>
            <td>{{ $item->name ?? 'N/A' }}</td>
            <td>{{ $item->category_name ?? 'N/A' }}</td>
            <td>{{ $item->quantity ?? 0 }}</td>
        </tr>
    @endforeach
    @if($data->isEmpty())
        <tr>
            <td colspan="5">Không có dữ liệu phù hợp</td>
        </tr>
    @endif
    </tbody>
</table>
</body>
</html>
