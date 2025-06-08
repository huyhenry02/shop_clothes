@php use Carbon\Carbon; @endphp
@php use App\Models\Order; @endphp
@extends('admin.layouts.main')
@section('content')
    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{ route('admin.order.putOrder', $order->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Thông tin đơn hàng #{{ $order->order_code }}</h5>
                                <div class="form-group mt-2">
                                    <label>Tổng tiền</label>
                                    <input type="text" class="form-control"
                                           value="{{ number_format($order->total_amount, 0, ',', '.') }} đ" readonly>
                                </div>
                                <div class="form-group mt-2">
                                    <label>Phương thức thanh toán</label>
                                    <input type="text" class="form-control"
                                           value="{{ strtoupper($order->payment_method) }}" readonly>
                                </div>
                                <div class="form-group mt-2">
                                    <label>Thời gian thanh toán</label>
                                    <input type="text" class="form-control"
                                           value="{{ $order->payment_time ? Carbon::parse($order->payment_time)->format('d/m/Y H:i') : '—' }}"
                                           readonly>
                                </div>
                                <div class="form-group mt-2">
                                    <label>Mã giao dịch (transaction ID)</label>
                                    <input type="text" class="form-control" value="{{ $order->payment_transaction_id }}"
                                           readonly>
                                </div>
                                <div class="form-group mt-2">
                                    <label>Bank Code</label>
                                    <input type="text" class="form-control" value="{{ $order->payment_bank_code }}"
                                           readonly>
                                </div>
                                <div class="form-group mt-2">
                                    <label>Response Code</label>
                                    <input type="text" class="form-control" value="{{ $order->payment_response_code }}"
                                           readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5>Thông tin nhận hàng</h5>
                                <div class="form-group">
                                    <label>Tên người nhận<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="shipping_name"
                                           value="{{ old('shipping_name', $order->shipping_name) }}" readonly>
                                </div>
                                <div class="form-group mt-2">
                                    <label>Số điện thoại<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="shipping_phone"
                                           value="{{ old('shipping_phone', $order->shipping_phone) }}" readonly>
                                </div>
                                <div class="form-group mt-2">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="shipping_email"
                                           value="{{ old('shipping_email', $order->shipping_email) }}" readonly>
                                </div>
                                <div class="form-group mt-2">
                                    <label>Địa chỉ<span class="text-danger">*</span></label>
                                    <textarea class="form-control" readonly
                                              name="shipping_address">{{ old('shipping_address', $order->shipping_address) }}</textarea>
                                </div>
                                <div class="form-group mt-2">
                                    <label>Trạng thái đơn hàng</label>
                                    <select name="status" class="form-select">
                                        @foreach( Order::STATUSES as $key => $status)
                                            <option
                                                value="{{ $key }}" {{ $order->status === $key ? 'selected' : '' }}>
                                                {{ ucfirst($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mt-2">
                                    <label>Trạng thái thanh toán</label>
                                    <select name="payment_status" class="form-select">
                                        @foreach( Order::PAYMENT_STATUSES as $key => $status)
                                            <option
                                                value="{{ $key }}" {{ $order->payment_status === $key ? 'selected' : '' }}>
                                                {{ ucfirst($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h5>Thông tin sản phẩm</h5>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th width="15%">Ảnh</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Số lượng</th>
                                        <th>Size</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($order->orderDetails as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td><img src="{{ $item->product->image ?? '' }}" alt="" width="100px" height="100px"></td>
                                            <td>{{ $item->product->name ?? '—' }}</td>
                                            <td>{{ $item->size ?? '—' }}</td>
                                            <td>{{ $item->quantity ?? '—' }}</td>
                                            <td>{{ number_format($item->total_price, 0, ',', '.') }} đ</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-action text-end mt-3">
                    <a href="{{ route('admin.order.showIndex') }}" class="btn btn-outline-secondary">Hủy</a>
                    <button class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
@endsection
