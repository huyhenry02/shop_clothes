@php use App\Models\Customer; @endphp
@extends('admin.layouts.main')
@section('content')
    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{ route('admin.customer.postCustomer') }}" enctype="multipart/form-data">
                @csrf
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Thông tin khách hàng</h5>
                                <div class="form-group">
                                    <label>Tên khách hàng<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="full_name" required>
                                </div>
                                <div class="form-group">
                                    <label>Email<span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label>Số điện thoại<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="phone" required>
                                </div>
                                <div class="form-group">
                                    <label>Mật khẩu đăng nhập<span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                                <div class="form-group">
                                    <label>Địa chỉ<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="address" required>
                                </div>
                                <div class="form-group">
                                    <label>Giới tính <span class="text-danger">*</span></label>
                                    <select class="form-control" name="gender">
                                        <option
                                            value="{{ Customer::GENDER_FEMALE }}">{{ Customer::GENDERS[Customer::GENDER_MALE] }}</option>
                                        <option
                                            value="{{ Customer::GENDER_FEMALE }}">{{ Customer::GENDERS[Customer::GENDER_FEMALE] }}</option>
                                        <option
                                            value="{{ Customer::GENDER_OTHER }}">{{ Customer::GENDERS[Customer::GENDER_OTHER] }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Ngày sinh<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="birthday" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-action text-end mt-3">
                    <button type="button" class="btn btn-outline-secondary">Hủy</button>
                    <button class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
@endsection
