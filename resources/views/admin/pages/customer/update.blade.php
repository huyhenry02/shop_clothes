@php use App\Models\Customer;use Carbon\Carbon; @endphp
@extends('admin.layouts.main')
@section('content')
    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{ route('admin.customer.putCustomer', $customer->id) }}"
                  enctype="multipart/form-data">
                @csrf
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Thông tin khách hàng</h5>

                                <div class="form-group">
                                    <label>Tên khách hàng<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="full_name" required
                                           value="{{ old('full_name', $customer->full_name ?? '') }}">
                                </div>

                                <div class="form-group">
                                    <label>Email<span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" required
                                           value="{{ old('email', $customer->email ?? '') }}">
                                </div>

                                <div class="form-group">
                                    <label>Số điện thoại<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="phone" required
                                           value="{{ old('phone', $customer->user->phone ?? '') }}">
                                </div>

                                <div class="form-group">
                                    <label>Mật khẩu đăng nhập<span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="password"
                                           placeholder="{{ isset($customer) ? 'Để trống nếu không đổi mật khẩu' : '' }}">
                                </div>

                                <div class="form-group">
                                    <label>Địa chỉ<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="address" required
                                           value="{{ old('address', $customer->address ?? '') }}">
                                </div>

                                <div class="form-group">
                                    <label>Giới tính <span class="text-danger">*</span></label>
                                    <select class="form-control" name="gender">
                                        <option value="{{ Customer::GENDER_MALE }}"
                                            {{ old('gender', $customer->gender ?? '') === Customer::GENDER_MALE ? 'selected' : '' }}>
                                            {{ Customer::GENDERS[Customer::GENDER_MALE] }}
                                        </option>
                                        <option value="{{ Customer::GENDER_FEMALE }}"
                                            {{ old('gender', $customer->gender ?? '') === Customer::GENDER_FEMALE ? 'selected' : '' }}>
                                            {{ Customer::GENDERS[Customer::GENDER_FEMALE] }}
                                        </option>
                                        <option value="{{ Customer::GENDER_OTHER }}"
                                            {{ old('gender', $customer->gender ?? '') === Customer::GENDER_OTHER ? 'selected' : '' }}>
                                            {{ Customer::GENDERS[Customer::GENDER_OTHER] }}
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Ngày sinh<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="birthday" required
                                           value="{{ old('birthday', isset($customer->birthday) ? Carbon::parse($customer->birthday)->format('Y-m-d') : '') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-action text-end mt-3">
                    <a href="{{ route('admin.customer.showIndex') }}" class="btn btn-outline-secondary">Hủy</a>
                    <button class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
@endsection
