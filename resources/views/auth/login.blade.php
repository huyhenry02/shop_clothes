@extends('customer.layouts.main')
@section('content')
    <div class="page-heading about-page-heading" id="top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-content">
                        <h2>Đăng nhập tài khoản</h2>
                        <span>Vui lòng đăng nhập để tiếp tục mua sắm tại ROWAY</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="login-form-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section-heading text-center mb-4">
                        <h4>Chào mừng bạn quay trở lại!</h4>
                        <span>Điền thông tin tài khoản để đăng nhập</span>
                    </div>
                    <form id="login-form" action="" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="email">Địa chỉ email</label>
                            <input name="email" type="email" id="email" class="form-control" placeholder="Nhập email..." required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">Mật khẩu</label>
                            <input name="password" type="password" id="password" class="form-control" placeholder="Nhập mật khẩu..." required>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember">
                            <label class="form-check-label" for="remember">
                                Ghi nhớ đăng nhập
                            </label>
                        </div>
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-dark">
                                <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
                            </button>
                        </div>
                        <div class="text-center">
                            <a href="" class="text-muted">Quên mật khẩu?</a> |
                            <a href="">Chưa có tài khoản? Đăng ký</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <style>
        .login-form-section {
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
