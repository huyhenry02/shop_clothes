@extends('customer.layouts.main')
@section('content')
    <!-- ***** Main Banner Area Start ***** -->
    <div class="page-heading about-page-heading" id="top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-content">
                        <h2>Về Chúng Tôi</h2>
                        <span>Khám phá hành trình thương hiệu và giá trị mà chúng tôi mang lại cho bạn</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Main Banner Area End ***** -->

    <!-- ***** About Area Starts ***** -->
    <div class="about-us">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="left-image">
                        <img src="/customer/images/about-left-image.jpg" alt="Về ROWAY">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="right-content">
                        <h4>Về Chúng Tôi &amp; Định Hướng Phát Triển</h4>
                        <span>ROWAY là thương hiệu thời trang hướng đến sự đơn giản, hiện đại và tiện lợi. Chúng tôi cam kết mang đến những sản phẩm chất lượng, phù hợp với phong cách sống năng động của người Việt.</span>
                        <div class="quote">
                            <i class="fa fa-quote-left"></i>
                            <p>"Thời trang không chỉ là bề ngoài, đó là cách bạn thể hiện cá tính và sống đúng với bản thân."</p>
                        </div>
                        <p>Với đội ngũ thiết kế sáng tạo cùng quy trình sản xuất nghiêm ngặt, chúng tôi luôn không ngừng đổi mới để mang đến trải nghiệm mua sắm trực tuyến tốt nhất cho khách hàng. Tại ROWAY, mỗi sản phẩm đều là kết tinh của tâm huyết, sự tỉ mỉ và tình yêu với thời trang.</p>
                        <ul>
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="#"><i class="fa fa-behance"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** About Area Ends ***** -->

    <!-- ***** Services Area Starts ***** -->
    <section class="our-services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-heading">
                        <h2>Dịch Vụ Của Chúng Tôi</h2>
                        <span>Chúng tôi mang đến trải nghiệm khác biệt qua từng chi tiết nhỏ nhất</span>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="service-item">
                        <h4>Thiết Kế Hiện Đại</h4>
                        <p>Luôn cập nhật xu hướng mới, sản phẩm của ROWAY mang lại vẻ ngoài trẻ trung và thời thượng.</p>
                        <img src="/customer/images/service-01.jpg" alt="">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="service-item">
                        <h4>Chất Lượng Đảm Bảo</h4>
                        <p>Chúng tôi lựa chọn chất liệu kỹ lưỡng và kiểm tra nghiêm ngặt trước khi đưa sản phẩm đến tay bạn.</p>
                        <img src="/customer/images/service-02.jpg" alt="">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="service-item">
                        <h4>Hỗ Trợ Khách Hàng</h4>
                        <p>Đội ngũ tư vấn thân thiện và nhiệt tình, sẵn sàng hỗ trợ bạn 24/7 với mọi vấn đề khi mua sắm.</p>
                        <img src="/customer/images/service-03.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Services Area Ends ***** -->

    <!-- ***** Subscribe Area Starts ***** -->
    <div class="subscribe">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="section-heading">
                        <h2>Đăng ký nhận bản tin – Nhận ưu đãi 30%</h2>
                        <span>Luôn cập nhật các xu hướng mới và ưu đãi hấp dẫn từ ROWAY</span>
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
                                    <input name="email" type="text" id="email" pattern="[^ @]*@[^ @]*" placeholder="Địa chỉ Email của bạn" required="">
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
                                <li>Địa chỉ cửa hàng:<br><span>Hà Nội, Việt Nam</span></li>
                                <li>Điện thoại:<br><span>0901 234 567</span></li>
                                <li>Văn phòng:<br><span>362 Minh Khai, Hai Bà Trưng, Hanoi</span></li>
                            </ul>
                        </div>
                        <div class="col-6">
                            <ul>
                                <li>Giờ làm việc:<br><span>08:00 - 21:00 (cả tuần)</span></li>
                                <li>Email:<br><span>support@roway.vn</span></li>
                                <li>Mạng xã hội:<br><span><a href="#">Facebook</a>, <a href="#">Instagram</a>, <a href="#">Zalo</a>, <a href="#">Tiktok</a></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Subscribe Area Ends ***** -->
@endsection
