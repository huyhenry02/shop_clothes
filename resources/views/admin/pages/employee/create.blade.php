@extends('admin.layouts.main')
@section('content')
    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{ route('admin.employee.postEmployee') }}" enctype="multipart/form-data">
                @csrf
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Thông tin nhân viên</h5>
                                <div class="form-group">
                                    <label>Tên nhân viên<span class="text-danger">*</span></label>
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
                                    <label>Chức vụ<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="position" required>
                                </div>
                                <div class="form-group">
                                    <label>Địa chỉ<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="address" required>
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
