@php use App\Models\Customer; @endphp
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
                    <form id="register-form" action="{{ route('admin.customer.postCustomer') }}" method="POST">
                        @csrf
                        <input name="type_create" type="hidden" id="type_create" class="form-control" required value="customer_register">
                        <div class="form-group mb-3">
                            <label for="full_name">Họ và tên<span class="text-danger">*</span></label>
                            <input name="full_name" type="text" id="full_name" class="form-control" placeholder="Nhập họ tên..."
                                   required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Email<span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Số điện thoại<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="phone" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Địa chỉ<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="address" required>
                        </div>
                        <div class="form-group mb-3">
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
                        <div class="form-group mb-3">
                            <label>Ngày sinh<span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="birthday" required>
                        </div>
                        <div class="form-group mb-3 position-relative">
                            <label for="password">Mật khẩu<span class="text-danger">*</span></label>
                            <input name="password" type="password" id="password" class="form-control" placeholder="Nhập mật khẩu..." required>
                            <span toggle="#password" class="fa fa-fw fa-eye toggle-password position-absolute" style="top: 38px; right: 15px; cursor: pointer;"></span>
                        </div>
                        <div class="form-group mb-3 position-relative">
                            <label for="password_confirmation">Xác nhận mật khẩu<span class="text-danger">*</span></label>
                            <input name="password_confirmation" type="password" id="password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu..." required>
                            <span toggle="#password_confirmation" class="fa fa-fw fa-eye toggle-password position-absolute" style="top: 38px; right: 15px; cursor: pointer;"></span>
                        </div>
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-dark">
                                <i class="fa fa-user-plus me-2"></i>Đăng ký
                            </button>
                        </div>
                        <div class="text-center">
                            <a href="{{ route('auth.showLogin') }}">Đã có tài khoản? Đăng nhập</a>
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

        document.getElementById('register-form').addEventListener('submit', function (e) {
            const password = document.getElementById('password').value;
            const confirm = document.getElementById('password_confirmation').value;

            if (password !== confirm) {
                e.preventDefault();
                alert('Mật khẩu xác nhận không khớp.');
            }
        });
    </script>

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
