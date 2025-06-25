@php
    use Illuminate\Support\Facades\Route;$route = request()->route()->getName();

    $breadcrumbs = [
        'admin.customer.showIndex' => ['Khách hàng', 'Danh sách'],
        'admin.customer.showCreate' => ['Khách hàng', 'Thêm mới'],
        'admin.customer.showUpdate' => ['Khách hàng', 'Cập nhật'],

        'admin.employee.showIndex' => ['Nhân viên', 'Danh sách'],
        'admin.employee.showCreate' => ['Nhân viên', 'Thêm mới'],
        'admin.employee.showUpdate' => ['Nhân viên', 'Cập nhật'],

        'admin.category.showIndex' => ['Danh mục', 'Danh sách'],
        'admin.category.showCreate' => ['Danh mục', 'Thêm mới'],
        'admin.category.showUpdate' => ['Danh mục', 'Cập nhật'],

        'admin.product.showIndex' => ['Sản phẩm', 'Danh sách'],
        'admin.product.showCreate' => ['Sản phẩm', 'Thêm mới'],
        'admin.product.showUpdate' => ['Sản phẩm', 'Cập nhật'],

        'admin.order.showIndex' => ['Đơn hàng', 'Danh sách'],
        'admin.order.showUpdate' => ['Đơn hàng', 'Cập nhật'],

        'admin.invoice.showIndex' => ['Hóa đơn', 'Danh sách'],
        'admin.invoice.showUpdate' => ['Hóa đơn', 'Cập nhật'],
        'admin.invoice.showCreate' => ['Hóa đơn', 'Thêm mới'],

        'admin.report.showRevenue' => ['Báo cáo', 'Doanh thu'],
        'admin.report.showOrder' => ['Báo cáo', 'Đơn hàng'],
        'admin.report.showBestSelling' => ['Báo cáo', 'Sản phẩm'],
    ];

    [$moduleTitle, $actionTitle] = $breadcrumbs[$route] ?? ['Trang', 'Không xác định'];
@endphp
<div class="main-header">
    <div class="main-header-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="blue">
            <a href="#" class="logo">
                <img
                    src="/assets/img/kaiadmin/logo.png"
                    alt="navbar brand"
                    class="navbar-brand"
                    height="20"
                />
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
    </div>
    <nav
        class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
        data-background-color="blue"
        style="color: white"
    >
        <div class="container-fluid">
            <nav
                class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex mt-3"
                style="color: white"
            >
                <h3 class="mb-3" style="color: white">
                    {{ $actionTitle }} {{ $moduleTitle }}
                </h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                        <a href="#">
                            <i class="icon-home" style="color: white"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item" style="color: white">
                        @php
                            $routeName = Route::currentRouteName();
                                if (str_contains($routeName, 'admin.report')) {
                                    $moduleTitle = 'Báo cáo';
                                }
                        @endphp
                        Quản lý {{ $moduleTitle }}
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item" style="color: white">
                        {{ $actionTitle }}
                    </li>
                </ul>
            </nav>


            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li
                    class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none"
                >
                    <a
                        class="nav-link dropdown-toggle"
                        data-bs-toggle="dropdown"
                        href="#"
                        role="button"
                        aria-expanded="false"
                        aria-haspopup="true"
                    >
                        <i class="fa fa-search"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-search animated fadeIn">
                    </ul>
                </li>

                <li class="nav-item topbar-user dropdown hidden-caret">
                    <a
                        class="dropdown-toggle profile-pic"
                        data-bs-toggle="dropdown"
                        href="#"
                        aria-expanded="false"
                    >
                        <div class="avatar-sm">
                            <img
                                src="/assets/img/no_avatar.jpg"
                                alt="..."
                                class="avatar-img rounded-circle"
                            />
                        </div>
                        <span class="profile-username">
                      <span style="color: white">Xin chào,</span>
                      <span style="color: white"> {{ auth()->user()->employee->full_name ?? '' }}</span>
                    </span>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <div class="user-box">
                                    <div class="avatar-lg">
                                        <img
                                            src="/assets/img/no_avatar.jpg"
                                            alt="image profile"
                                            class="avatar-img rounded"
                                        />
                                    </div>
                                    <div class="u-text">
                                        <h4>{{ auth()->user()->employee->full_name ?? '' }}</h4>
                                        <p class="text-muted"></p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('customer.showIndex') }}">Web shop</a>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('auth.logout') }}">Đăng xuất</a>
                            </li>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</div>
