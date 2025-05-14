@extends('customer.layouts.main')
@section('content')
    <div class="page-heading about-page-heading" id="top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-content">
                        <h2>Đăng ký tài khoản</h2>
                        <span>Tạo tài khoản để bắt đầu mua sắm tại ROWAY</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="register-form-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section-heading text-center mb-4">
                        <h4>Thông tin đăng ký</h4>
                        <span>Điền đầy đủ thông tin bên dưới</span>
                    </div>
                    <form id="register-form" action="" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">Họ và tên</label>
                            <input name="name" type="text" id="name" class="form-control" placeholder="Nhập họ tên..." required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">Địa chỉ email</label>
                            <input name="email" type="email" id="email" class="form-control" placeholder="Nhập email..." required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">Mật khẩu</label>
                            <input name="password" type="password" id="password" class="form-control" placeholder="Nhập mật khẩu..." required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password_confirmation">Xác nhận mật khẩu</label>
                            <input name="password_confirmation" type="password" id="password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu..." required>
                        </div>
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-dark">
                                <i class="fa fa-user-plus me-2"></i>Đăng ký
                            </button>
                        </div>
                        <div class="text-center">
                            <a href="">Đã có tài khoản? Đăng nhập</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <style>
        .register-form-section {
            background-color: #f9f9f9;
            border-top: 1px solid #eee;
        }

        .form-control {
            border-radius: 5px;
            padding: 10px;
        }

        .btn-dark {
            padding: 10px;
            font-weight: 500;
            font-size: 16px;
        }
    </style>
@endsection
