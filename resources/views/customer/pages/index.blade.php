@extends('customer.layouts.main')
@section('content')
    <!-- ***** Main Banner Area Start ***** -->
    <div class="main-banner" id="top">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="left-content">
                        <div class="thumb">
                            <div class="inner-content">
                                <div class="main-border-button">
                                    <a href="#">Khám phá ngay!</a>
                                </div>
                            </div>
                            <img src="/customer/images/left-banner-image.jpg" alt="Banner thời trang nam">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="right-content">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="right-first-image">
                                    <div class="thumb">
                                        <div class="inner-content">
                                            <h4>Quần nam</h4>
                                            <span>Thời trang hiện đại, thoải mái</span>
                                        </div>
                                        <div class="hover-content">
                                            <div class="inner">
                                                <h4>Quần nam</h4>
                                                <p>Đa dạng mẫu mã từ quần jean, kaki đến quần short, phù hợp mọi phong cách.</p>
                                            </div>
                                        </div>
                                        <img src="/customer/images/baner-right-image-01.jpg" alt="Áo nam">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="right-first-image">
                                    <div class="thumb">
                                        <div class="inner-content">
                                            <h4>Phụ kiện</h4>
                                            <span>Hoàn thiện phong cách nam tính</span>
                                        </div>
                                        <div class="hover-content">
                                            <div class="inner">
                                                <h4>Phụ kiện</h4>
                                                <p>Thắt lưng, ví da, kính râm và nhiều phụ kiện thời trang tinh tế khác cho nam giới.</p>
                                            </div>
                                        </div>
                                        <img src="/customer/images/baner-right-image-02.jpg" alt="Quần nam">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="right-first-image">
                                    <div class="thumb">
                                        <div class="inner-content">
                                            <h4>Áo nam</h4>
                                            <span>Phong cách lịch lãm & năng động</span>
                                        </div>
                                        <div class="hover-content">
                                            <div class="inner">
                                                <h4>Áo nam</h4>
                                                <p>Bộ sưu tập áo sơ mi, áo thun, áo khoác mang đến diện mạo cuốn hút cho phái mạnh.</p>
                                            </div>
                                        </div>
                                        <img src="/customer/images/baner-right-image-03.jpg" alt="Phụ kiện nam">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="right-first-image">
                                    <div class="thumb">
                                        <div class="inner-content">
                                            <h4>Giày dép</h4>
                                            <span>Sành điệu & mạnh mẽ</span>
                                        </div>
                                        <div class="hover-content">
                                            <div class="inner">
                                                <h4>Giày dép</h4>
                                                <p>Khám phá các mẫu giày sneaker, giày da, sandal thiết kế chuẩn form nam tính.</p>
                                            </div>
                                        </div>
                                        <img src="/customer/images/baner-right-image-04.jpg" alt="Giày dép nam">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Main Banner Area End ***** -->

    <!-- ***** Men Area Starts ***** -->
    <section class="section" id="men">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-heading">
                        <h2>{{ $firstCategory->name ?? '' }}</h2>
                        <span>{{ $firstCategory->description ?? '' }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="men-item-carousel">
                        <div class="owl-men-item owl-carousel">
                            @foreach($list_first_products as $key => $product)
                                <div class="item">
                                    <div class="thumb">
                                        <div class="hover-content">
                                            <ul>
                                                <li><a href="single-product.html"><i class="fa fa-eye"></i></a></li>
                                                <li><a href="single-product.html"><i class="fa fa-shopping-cart"></i></a></li>
                                            </ul>
                                        </div>
                                        <img src="{{ $product->image ?? '' }}" alt="">
                                    </div>
                                    <div class="down-content">
                                        <h4>{{ $product->name }}</h4>
                                        <span>{{ $product->discount_price ? number_format($product->discount_price) : 0 }} VND</span>
                                        <ul class="stars">
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Men Area Ends ***** -->
    <section class="section" id="women">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-heading">
                        <h2>{{ $secondCategory->name ?? '' }}</h2>
                        <span>{{ $secondCategory->description ?? '' }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="men-item-carousel">
                        <div class="owl-men-item owl-carousel">
                            @foreach($list_second_products as $key => $product)
                                <div class="item">
                                    <div class="thumb">
                                        <div class="hover-content">
                                            <ul>
                                                <li><a href="single-product.html"><i class="fa fa-eye"></i></a></li>
                                                <li><a href="single-product.html"><i class="fa fa-shopping-cart"></i></a></li>
                                            </ul>
                                        </div>
                                        <img src="{{ $product->image ?? '' }}" alt="">
                                    </div>
                                    <div class="down-content">
                                        <h4>{{ $product->name }}</h4>
                                        <span>{{ $product->discount_price ? number_format($product->discount_price) : 0 }} VND</span>
                                        <ul class="stars">
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="kids">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-heading">
                        <h2>{{ $thirdCategory->name ?? '' }}</h2>
                        <span>{{ $thirdCategory->description ?? '' }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="men-item-carousel">
                        <div class="owl-men-item owl-carousel">
                            @foreach($list_third_products as $key => $product)
                                <div class="item">
                                    <div class="thumb">
                                        <div class="hover-content">
                                            <ul>
                                                <li><a href="single-product.html"><i class="fa fa-eye"></i></a></li>
                                                <li><a href="single-product.html"><i class="fa fa-shopping-cart"></i></a></li>
                                            </ul>
                                        </div>
                                        <img src="{{ $product->image ?? '' }}" alt="">
                                    </div>
                                    <div class="down-content">
                                        <h4>{{ $product->name }}</h4>
                                        <span>{{ $product->discount_price ? number_format($product->discount_price) : 0 }} VND</span>
                                        <ul class="stars">
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ***** Explore Area Starts ***** -->
    <section class="section" id="explore">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="left-content">
                        <h2>Khám phá sản phẩm của chúng tôi</h2>
                        <span>Bộ sưu tập thời trang và phụ kiện nam hiện đại, lịch lãm, đáp ứng mọi phong cách từ công sở đến năng động hằng ngày.</span>
                        <div class="quote">
                            <i class="fa fa-quote-left"></i>
                            <p>Chúng tôi không ngừng cập nhật những xu hướng mới nhất dành riêng cho phái mạnh.</p>
                        </div>
                        <p>Hệ thống sản phẩm của chúng tôi bao gồm nhiều danh mục như áo sơ mi, quần jean, giày thể thao, túi xách da, kính râm và nhiều hơn thế nữa.</p>
                        <p>Nếu bạn đang tìm kiếm sự khác biệt trong phong cách cá nhân, đây chính là nơi để bắt đầu hành trình ấy. Hãy chia sẻ với bạn bè để cùng trải nghiệm nhé!</p>
                        <div class="main-border-button">
                            <a href="{{ route('customer.showListProducts') }}">Xem tất cả sản phẩm</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="right-content">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="leather">
                                    <h4>Áo Polo</h4>
                                    <span>Bộ sưu tập mới nhất</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="first-image">
                                    <img src="/customer/images/explore-image-01.png" alt="Túi xách da nam">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="second-image">
                                    <img src="/customer/images/explore-image-02.png" alt="Phụ kiện thời trang nam">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="types">
                                    <h4>Đa dạng kiểu dáng</h4>
                                    <span>Hơn 300 sản phẩm đang có</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Explore Area Ends ***** -->

    <div class="subscribe">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="section-heading">
                        <h2>Đăng ký nhận tin để nhận ưu đãi giảm giá 30%</h2>
                        <span>Sự tỉ mỉ trong từng chi tiết tạo nên sự khác biệt của ROWAY.</span>
                    </div>
                    <form id="subscribe" action="" method="get">
                        <div class="row">
                            <div class="col-lg-5">
                                <fieldset>
                                    <input name="name" type="text" id="name" placeholder="Họ và tên của bạn" required="">
                                </fieldset>
                            </div>
                            <div class="col-lg-5">
                                <fieldset>
                                    <input name="email" type="text" id="email" pattern="[^ @]*@[^ @]*" placeholder="Địa chỉ email của bạn" required="">
                                </fieldset>
                            </div>
                            <div class="col-lg-2">
                                <fieldset>
                                    <button type="submit" id="form-submit" class="main-dark-button"><i class="fa fa-paper-plane"></i></button>
                                </fieldset>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-6">
                            <ul>
                                <li>Địa chỉ cửa hàng:<br><span>Hai bà trưng, Hà nội</span></li>
                                <li>Điện thoại:<br><span>0901 234 567</span></li>
                                <li>Văn phòng:<br><span>Hai bà trưng, Hà nội</span></li>
                            </ul>
                        </div>
                        <div class="col-6">
                            <ul>
                                <li>Giờ làm việc:<br><span>08:00 - 21:00 mỗi ngày</span></li>
                                <li>Email:<br><span>hotro@roway.vn</span></li>
                                <li>Mạng xã hội:<br><span><a href="#">Facebook</a>, <a href="#">Instagram</a>, <a href="#">Zalo</a></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
