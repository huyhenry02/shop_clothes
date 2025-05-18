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
                    <form id="login-form" action="{{ route('auth.postLogin') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="phone">Số điện thoại</label>
                            <input name="phone" type="text" id="phone" class="form-control" placeholder="Nhập số điện thoại..." required>
                        </div>
                        <div class="form-group mb-3 position-relative">
                            <label for="password">Mật khẩu<span class="text-danger">*</span></label>
                            <input name="password" type="password" id="password" class="form-control" placeholder="Nhập mật khẩu..." required>
                            <span toggle="#password" class="fa fa-fw fa-eye toggle-password position-absolute" style="top: 38px; right: 15px; cursor: pointer;"></span>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember" value="1">
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
                            <a href="{{ route('auth.showRegister') }}">Chưa có tài khoản? Đăng ký</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('.toggle-password').forEach(function (icon) {
            icon.addEventListener('click', function () {
                const input = document.querySelector(this.getAttribute('toggle'));
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        });
    </script>
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
