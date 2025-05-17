@extends('admin.layouts.main')
@section('content')
    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{ route('admin.employee.putEmployee', $employee->id) }}"
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
                                           value="{{ old('full_name', $employee->full_name ?? '') }}">
                                </div>

                                <div class="form-group">
                                    <label>Email<span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" required
                                           value="{{ old('email', $employee->email ?? '') }}">
                                </div>

                                <div class="form-group">
                                    <label>Số điện thoại<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="phone" required
                                           value="{{ old('phone', $employee->user->phone ?? '') }}">
                                </div>

                                <div class="form-group">
                                    <label>Mật khẩu đăng nhập<span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="password"
                                           placeholder="{{ isset($employee) ? 'Để trống nếu không đổi mật khẩu' : '' }}">
                                </div>

                                <div class="form-group">
                                    <label>Địa chỉ<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="position" required
                                           value="{{ old('position', $employee->position ?? '') }}">
                                </div>

                                <div class="form-group">
                                    <label>Địa chỉ<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="address" required
                                           value="{{ old('address', $employee->address ?? '') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-action text-end mt-3">
                    <a href="{{ route('admin.employee.showIndex') }}" class="btn btn-outline-secondary">Hủy</a>
                    <button class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
@endsection
