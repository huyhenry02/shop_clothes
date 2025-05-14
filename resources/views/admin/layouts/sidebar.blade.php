<div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
        <ul class="nav nav-secondary">
            <li class="nav-item active">
                <a
                    data-bs-toggle="collapse"
                    href="#customer"
                    class="collapsed"
                    aria-expanded="false"
                >
                    <i class="fas fa-user"></i>
                    <p class="mt-1">Quản lý khách hàng</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse show" id="customer">
                    <ul class="nav nav-collapse">
                        <li class=""
                        >
                            <a href="{{ route('admin.customer.showIndex') }}">
                                <span class="sub-item">Danh sách khách hàng</span>
                            </a>
                        </li>
                        <li class=""
                        >
                            <a href="{{ route('admin.customer.showCreate') }}">
                                <span class="sub-item">Thêm mới khách hàng</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item active">
                <a
                    data-bs-toggle="collapse"
                    href="#employee"
                    class="collapsed"
                    aria-expanded="false"
                >
                    <i class="fas fa-user"></i>
                    <p class="mt-1">Quản lý nhân viên</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse show" id="employee">
                    <ul class="nav nav-collapse">
                        <li class=""
                        >
                            <a href="{{ route('admin.employee.showIndex') }}">
                                <span class="sub-item">Danh sách nhân viên</span>
                            </a>
                        </li>
                        <li class=""
                        >
                            <a href="{{ route('admin.employee.showCreate') }}">
                                <span class="sub-item">Thêm mới nhân viên</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item active">
                <a
                    data-bs-toggle="collapse"
                    href="#category"
                    class="collapsed"
                    aria-expanded="false"
                >
                    <i class="fas fa-user"></i>
                    <p class="mt-1">Quản lý danh mục</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse show" id="category">
                    <ul class="nav nav-collapse">
                        <li class=""
                        >
                            <a href="{{ route('admin.category.showIndex') }}">
                                <span class="sub-item">Danh sách danh mục</span>
                            </a>
                        </li>
                        <li class=""
                        >
                            <a href="{{ route('admin.category.showCreate') }}">
                                <span class="sub-item">Thêm mới danh mục</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item active">
                <a
                    data-bs-toggle="collapse"
                    href="#product"
                    class="collapsed"
                    aria-expanded="false"
                >
                    <i class="fas fa-user"></i>
                    <p class="mt-1">Quản lý sản phẩm</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse show" id="product">
                    <ul class="nav nav-collapse">
                        <li class=""
                        >
                            <a href="{{ route('admin.product.showIndex') }}">
                                <span class="sub-item">Danh sách sản phẩm</span>
                            </a>
                        </li>
                        <li class=""
                        >
                            <a href="{{ route('admin.product.showCreate') }}">
                                <span class="sub-item">Thêm mới sản phẩm</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item active">
                <a
                    data-bs-toggle="collapse"
                    href="#order"
                    class="collapsed"
                    aria-expanded="false"
                >
                    <i class="fas fa-user"></i>
                    <p class="mt-1">Quản lý đơn hàng</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse show" id="order">
                    <ul class="nav nav-collapse">
                        <li class=""
                        >
                            <a href="">
                                <span class="sub-item">Danh sách đơn hàng</span>
                            </a>
                        </li>
                        <li class=""
                        >
                            <a href="">
                                <span class="sub-item">Thêm mới đơn hàng</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item active">
                <a
                    data-bs-toggle="collapse"
                    href="#payment"
                    class="collapsed"
                    aria-expanded="false"
                >
                    <i class="fas fa-user"></i>
                    <p class="mt-1">Quản lý hóa đơn</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse show" id="payment">
                    <ul class="nav nav-collapse">
                        <li class=""
                        >
                            <a href="">
                                <span class="sub-item">Danh sách hóa đơn</span>
                            </a>
                        </li>
                        <li class=""
                        >
                            <a href="">
                                <span class="sub-item">Thêm mới hóa đơn</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
