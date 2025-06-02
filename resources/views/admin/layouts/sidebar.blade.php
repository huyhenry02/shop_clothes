@php
    $routesCustomer = [
        'admin.customer.showIndex',
        'admin.customer.showCreate',
        'admin.customer.showUpdate',
        ];
    $routesEmployee = [
        'admin.employee.showIndex',
        'admin.employee.showCreate',
        'admin.employee.showUpdate',
        ];
    $routesCategory = [
        'admin.category.showIndex',
        'admin.category.showCreate',
        'admin.category.showUpdate',
        ];
    $routesProduct = [
        'admin.product.showIndex',
        'admin.product.showCreate',
        'admin.product.showUpdate',
        ];
    $routesOrder = [
        'admin.order.showIndex',
        'admin.order.showUpdate',
        ];
    $routesInvoice = [
        'admin.invoice.showIndex',
        'admin.invoice.showUpdate',
        'admin.invoice.showCreate',
        ];
    $routesReport = [
        'admin.report.showOrder',
        'admin.report.showRevenue',
        ];

    $isActiveCustomer = collect($routesCustomer)->contains(fn($route) => request()->routeIs($route));
    $isActiveEmployee = collect($routesEmployee)->contains(fn($route) => request()->routeIs($route));
    $isActiveCategory = collect($routesCategory)->contains(fn($route) => request()->routeIs($route));
    $isActiveProduct = collect($routesProduct)->contains(fn($route) => request()->routeIs($route));
    $isActiveOrder = collect($routesOrder)->contains(fn($route) => request()->routeIs($route));
    $isActiveInvoice = collect($routesInvoice)->contains(fn($route) => request()->routeIs($route));
    $isActiveReport = collect($routesReport)->contains(fn($route) => request()->routeIs($route));
@endphp
<div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
        <ul class="nav nav-secondary">

            <li class="nav-item {{ $isActiveCustomer ? 'active' : '' }}">
                <a data-bs-toggle="collapse" href="#customer" class="{{ $isActiveCustomer ? '' : 'collapsed' }}" aria-expanded="{{ $isActiveCustomer ? 'true' : 'false' }}">
                    <i class="fas fa-users"></i>
                    <p class="mt-1">Quản lý khách hàng</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse {{ $isActiveCustomer ? 'show' : '' }}" id="customer">
                    <ul class="nav nav-collapse">
                        <li class="{{ request()->routeIs('admin.customer.showIndex') ? 'active' : '' }}">
                            <a href="{{ route('admin.customer.showIndex') }}"><span class="sub-item">Danh sách khách hàng</span></a>
                        </li>
                        <li class="{{ request()->routeIs('admin.customer.showCreate') ? 'active' : '' }}">
                            <a href="{{ route('admin.customer.showCreate') }}"><span class="sub-item">Thêm mới khách hàng</span></a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item {{ $isActiveEmployee ? 'active' : '' }}">
                <a data-bs-toggle="collapse" href="#employee" class="{{ $isActiveEmployee ? '' : 'collapsed' }}" aria-expanded="{{ $isActiveEmployee ? 'true' : 'false' }}">
                    <i class="fas fa-user-tie"></i>
                    <p class="mt-1">Quản lý nhân viên</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse {{ $isActiveEmployee ? 'show' : '' }}" id="employee">
                    <ul class="nav nav-collapse">
                        <li class="{{ request()->routeIs('admin.employee.showIndex') ? 'active' : '' }}">
                            <a href="{{ route('admin.employee.showIndex') }}"><span class="sub-item">Danh sách nhân viên</span></a>
                        </li>
                        <li class="{{ request()->routeIs('admin.employee.showCreate') ? 'active' : '' }}">
                            <a href="{{ route('admin.employee.showCreate') }}"><span class="sub-item">Thêm mới nhân viên</span></a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item {{ $isActiveCategory ? 'active' : '' }}">
                <a data-bs-toggle="collapse" href="#category" class="{{ $isActiveCategory ? '' : 'collapsed' }}" aria-expanded="{{ $isActiveCategory ? 'true' : 'false' }}">
                    <i class="fas fa-th-list"></i>
                    <p class="mt-1">Quản lý danh mục</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse {{ $isActiveCategory ? 'show' : '' }}" id="category">
                    <ul class="nav nav-collapse">
                        <li class="{{ request()->routeIs('admin.category.showIndex') ? 'active' : '' }}">
                            <a href="{{ route('admin.category.showIndex') }}"><span class="sub-item">Danh sách danh mục</span></a>
                        </li>
                        <li class="{{ request()->routeIs('admin.category.showCreate') ? 'active' : '' }}">
                            <a href="{{ route('admin.category.showCreate') }}"><span class="sub-item">Thêm mới danh mục</span></a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item {{ $isActiveProduct ? 'active' : '' }}">
                <a data-bs-toggle="collapse" href="#product" class="{{ $isActiveProduct ? '' : 'collapsed' }}" aria-expanded="{{ $isActiveProduct ? 'true' : 'false' }}">
                    <i class="fas fa-box-open"></i>
                    <p class="mt-1">Quản lý sản phẩm</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse {{ $isActiveProduct ? 'show' : '' }}" id="product">
                    <ul class="nav nav-collapse">
                        <li class="{{ request()->routeIs('admin.product.showIndex') ? 'active' : '' }}">
                            <a href="{{ route('admin.product.showIndex') }}"><span class="sub-item">Danh sách sản phẩm</span></a>
                        </li>
                        <li class="{{ request()->routeIs('admin.product.showCreate') ? 'active' : '' }}">
                            <a href="{{ route('admin.product.showCreate') }}"><span class="sub-item">Thêm mới sản phẩm</span></a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item {{ $isActiveOrder ? 'active' : '' }}">
                <a data-bs-toggle="collapse" href="#order" class="{{ $isActiveOrder ? '' : 'collapsed' }}" aria-expanded="{{ $isActiveOrder ? 'true' : 'false' }}">
                    <i class="fas fa-shopping-cart"></i>
                    <p class="mt-1">Quản lý đơn hàng</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse {{ $isActiveOrder ? 'show' : '' }}" id="order">
                    <ul class="nav nav-collapse">
                        <li class="{{ request()->routeIs('admin.order.showIndex') ? 'active' : '' }}">
                            <a href="{{ route('admin.order.showIndex') }}"><span class="sub-item">Danh sách đơn hàng</span></a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item {{ $isActiveInvoice ? 'active' : '' }}">
                <a data-bs-toggle="collapse" href="#invoice" class="{{ $isActiveInvoice ? '' : 'collapsed' }}" aria-expanded="{{ $isActiveInvoice ? 'true' : 'false' }}">
                    <i class="fas fa-file-invoice-dollar"></i>
                    <p class="mt-1">Quản lý hóa đơn</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse {{ $isActiveInvoice ? 'show' : '' }}" id="invoice">
                    <ul class="nav nav-collapse">
                        <li class="{{ request()->routeIs('admin.invoice.showIndex') ? 'active' : '' }}">
                            <a href="{{ route('admin.invoice.showIndex') }}"><span class="sub-item">Danh sách hóa đơn</span></a>
                        </li>
                        <li class="{{ request()->routeIs('admin.invoice.showCreate') ? 'active' : '' }}">
                            <a href="{{ route('admin.invoice.showCreate') }}"><span class="sub-item">Thêm mới hóa đơn</span></a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item {{ $isActiveReport ? 'active' : '' }}">
                <a data-bs-toggle="collapse" href="#report" class="{{ $isActiveReport ? '' : 'collapsed' }}" aria-expanded="{{ $isActiveReport ? 'true' : 'false' }}">
                    <i class="fas fa-chart-bar" aria-hidden="true"></i>
                    <p class="mt-1">Quản lý báo cáo</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse {{ $isActiveReport ? 'show' : '' }}" id="report">
                    <ul class="nav nav-collapse">
                        <li class="{{ request()->routeIs('admin.report.showOrder') ? 'active' : '' }}">
                            <a href="{{ route('admin.report.showOrder') }}"><span class="sub-item">Đơn hàng</span></a>
                        </li>
                        <li class="{{ request()->routeIs('admin.report.showRevenue') ? 'active' : '' }}">
                            <a href="{{ route('admin.report.showRevenue') }}"><span class="sub-item">Doanh thu</span></a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
