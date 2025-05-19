@php use App\Models\User; @endphp
<header class="header-area header-sticky">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12">
                <nav class="main-nav d-flex justify-content-between align-items-center">
                    <!-- Logo -->
                    <div class="header-logo">
                        <a href="#">
                            <img src="/customer/images/logo.png" alt="">
                        </a>
                    </div>

                    <!-- Navigation Menu -->
                    <ul class="nav header-menu d-flex align-items-center mb-0">
                        <li class="scroll-to-section"><a
                                class="{{ request()->route()->getName() === 'customer.showIndex' ? 'active' : '' }}"
                                href="{{ route('customer.showIndex') }}">Trang chủ</a></li>
                        <li class="scroll-to-section"><a
                                class="{{ request()->route()->getName() === 'customer.showListProducts' ? 'active' : '' }}"
                                href="{{ route('customer.showListProducts') }}">Sản phẩm</a></li>
                        <li class="scroll-to-section"><a
                                class="{{ request()->route()->getName() === 'customer.showAbout' ? 'active' : '' }}"
                                href="{{ route('customer.showAbout') }}">Về chúng tôi</a></li>
                        <li class="scroll-to-section"><a
                                class="{{ request()->route()->getName() === 'customer.showContact' ? 'active' : '' }}"
                                href="{{ route('customer.showContact') }}">Liên lạc</a></li>
                    </ul>

                    @if( auth()->check() )
                        <div class="header-auth d-flex align-items-center">
                            <a href="{{ route('customer.showCart') }}" class="cart-icon me-4 text-dark position-relative">
                                <i class="fa fa-shopping-cart fa-lg"></i>
                                @php
                                $cartCount = auth()->user()->role === User::ROLE_CUSTOMER ? auth()->user()->customer->carts->count() : 0;
                                @endphp
                                <span class="cart-count">{{ $cartCount }}</span>
                            </a>
                            <div class="dropdown user-dropdown ml-3">
                                <a href="#" class="dropdown-toggle d-flex align-items-center text-dark"
                                   data-bs-toggle="dropdown">
                                    <i class="fa fa-user fa-lg me-2"></i>
                                    <span>{{ auth()->user()->employee->full_name ?? auth()->user()->customer->full_name }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{ route('customer.showOrder') }}">Đơn hàng</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    @if(auth()->user()->role === User::ROLE_ADMIN)
                                        <li><a class="dropdown-item" href="{{ route('admin.customer.showIndex') }}">WEB
                                                quản trị</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                    @endif
                                    <li>
                                        <form method="POST" action="">
                                            <a class="dropdown-item text-danger" href="{{ route('auth.logout') }}"><i
                                                    class="fa fa-sign-out-alt me-2"></i>Đăng xuất
                                            </a>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @else
                        <div class="header-auth d-flex align-items-center">
                            <li class="submenu">
                            </li>
                            <a href="{{ route('auth.showLogin') }}" class="auth-link me-3">
                                <i class="fa fa-sign-in me-1"></i> Đăng nhập
                            </a>
                            <a href="{{ route('auth.showRegister') }}" class="auth-link ml-2">
                                <i class="fa fa-user-plus me-1"></i> Đăng ký
                            </a>
                        </div>
                    @endif
                </nav>
            </div>
        </div>
    </div>
</header>
<style>
    .header-area {
        background-color: #fff;
        padding: 15px 0;
        border-bottom: 1px solid #eee;
    }

    .main-nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header-logo img {
        height: 40px;
    }

    .header-menu li {
        list-style: none;
        margin: 0 15px;
    }

    .header-menu a {
        text-decoration: none;
        color: #333;
        font-weight: 500;
        transition: color 0.3s;
    }

    .header-menu a:hover {
        color: #ff6f61;
    }

    .header-auth .auth-link {
        text-decoration: none;
        color: #333;
        font-weight: 500;
        transition: color 0.3s;
    }

    .header-auth .auth-link:hover {
        color: #ff6f61;
    }

    .cart-icon {
        position: relative;
        font-size: 1.2rem;
    }

    .cart-count {
        position: absolute;
        top: -6px;
        right: -10px;
        background-color: red;
        color: #fff;
        font-size: 12px;
        font-weight: bold;
        padding: 2px 6px;
        border-radius: 50%;
    }

    .user-dropdown .dropdown-toggle {
        font-weight: 500;
        cursor: pointer;
    }

    .user-dropdown .dropdown-menu {
        min-width: 180px;
    }

    .user-dropdown .dropdown-item {
        font-size: 14px;
        padding: 8px 15px;
    }

    .user-dropdown .dropdown-item:hover {
        background-color: #f8f9fa;
    }

</style>
