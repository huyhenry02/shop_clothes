@php use App\Models\Order; @endphp
@extends('admin.layouts.main')
@section('content')
    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{ route('admin.order.postOrder') }}" enctype="multipart/form-data"
                  id="order-form">
                @csrf
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Thông tin giao hàng</h5>
                                <div class="form-group">
                                    <label>Họ và tên <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="shipping_name" required>
                                </div>
                                <div class="form-group mt-2">
                                    <label>Số điện thoại <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="shipping_phone" required>
                                </div>
                                <div class="form-group mt-2">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="shipping_email">
                                </div>
                                <div class="form-group mt-2">
                                    <label>Địa chỉ giao hàng <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="shipping_address" rows="2" required></textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5>Thông tin thanh toán</h5>
                                <div class="form-group">
                                    <label>Phương thức thanh toán</label>
                                    <select class="form-control" name="payment_method" id="payment-method" readonly>
                                        <option
                                            value="{{ Order::PAYMENT_METHOD_COD }}">{{ Order::PAYMENT_METHODS[Order::PAYMENT_METHOD_COD] }}
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group mt-2">
                                    <label>Trạng thái đơn hàng</label>
                                    <select class="form-control" name="status">
                                        @foreach(Order::STATUSES as $key => $val)
                                            <option value="{{ $key }}">{{ $val }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mt-2">
                                    <label>Tổng tiền</label>
                                    <input type="text" class="form-control" name="total_amount" readonly>
                                    <input type="hidden" id="total-amount" value="0">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h5>Thông tin sản phẩm</h5>
                                <table class="table table-bordered" id="product-table">
                                    <thead>
                                    <tr>
                                        <th>Mã SP</th>
                                        <th>Ảnh</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Size</th>
                                        <th>Số lượng</th>
                                        <th>Đơn giá</th>
                                        <th>Thành tiền</th>
                                        <th>
                                            <button type="button" class="btn btn-success btn-sm" id="add-product">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="product-row">
                                        <td><input type="text" name="order_details[0][code]"
                                                   class="form-control product-code"></td>
                                        <td><img src="/customer/images/products/default.jpg" class="product-image"
                                                 style="width: 50px;" alt=""></td>
                                        <td><input type="text" class="form-control product-name" disabled></td>
                                        <td><select name="order_details[0][size]"
                                                    class="form-control product-size"></select></td>
                                        <td><input type="number" name="order_details[0][quantity]"
                                                   class="form-control quantity" min="1" value="1"></td>
                                        <td><input type="text" class="form-control unit-price" disabled></td>
                                        <td><input type="number" name="order_details[0][total_price]"
                                                   class="form-control total_price" readonly></td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm remove-row">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-action text-end mt-3">
                    <a href="{{ route('admin.order.showIndex') }}" class="btn btn-outline-secondary">Hủy</a>
                    <button type="submit" class="btn btn-primary">Tạo đơn hàng</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let rowCount = 1;

        function updateTotalPrice(row) {
            const quantity = parseInt(row.find('.quantity').val()) || 0;
            const unitPrice = parseInt(row.find('.unit-price').val()) || 0;
            const total = quantity * unitPrice;
            row.find('.total_price').val(total);
            updateInvoiceTotal();
        }

        function updateInvoiceTotal() {
            let total = 0;
            $('.total_price').each(function () {
                const val = parseInt($(this).val()) || 0;
                total += val;
            });
            $('input[name="total_amount"]').val(total);
        }

        function fetchProductData(code, row) {
            $.ajax({
                url: '/admin/invoice/get-product-by-code/' + code,
                method: 'GET',
                success: function (data) {
                    row.find('.product-name').val(data.name);
                    row.find('.product-image').attr('src', data.image_url);
                    row.find('.unit-price').val(data.discount_price);
                    row.find('.product-size').html(
                        data.sizes.map(size => `<option value="${size}">${size}</option>`).join('')
                    );
                    updateTotalPrice(row);
                },
            });
        }

        $(document).on('input', '.product-code', function () {
            const row = $(this).closest('tr');
            const code = $(this).val();
            if (code.length > 2) {
                fetchProductData(code, row);
            }
        });

        $(document).on('input', '.quantity', function () {
            const row = $(this).closest('tr');
            updateTotalPrice(row);
        });

        $('#add-product').click(function () {
            const firstRow = $('#product-table tbody tr:first');
            const newRow = firstRow.clone();

            newRow.find('input, select').each(function () {
                const name = $(this).attr('name');
                if (name) {
                    const newName = name.replace(/\[\d+\]/, `[${rowCount}]`);
                    $(this).attr('name', newName).val('');
                }
            });

            newRow.find('.product-name, .unit-price, .total_price').val('').prop('readonly', true);
            newRow.find('.product-image').attr('src', '/customer/images/products/default.jpg');

            newRow.find('td:last').html(
                `<button type="button" class="btn btn-danger btn-sm remove-row"><i class="fa fa-minus"></i></button>`
            );

            $('#product-table tbody').append(newRow);
            rowCount++;

            updateInvoiceTotal();
        });

        $(document).on('click', '.remove-row', function () {
            $(this).closest('tr').remove();
            updateInvoiceTotal();
        });

        $(document).ready(function () {
            updateInvoiceTotal();
        });
    </script>
@endsection
