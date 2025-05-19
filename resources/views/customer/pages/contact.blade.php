@extends('customer.layouts.main')
@section('content')

    <!-- ***** Tiêu đề Trang Liên hệ ***** -->
    <div class="page-heading about-page-heading" id="top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-content">
                        <h2>Liên hệ với chúng tôi</h2>
                        <span>Hãy để lại lời nhắn, chúng tôi sẽ phản hồi trong thời gian sớm nhất</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ***** Khu vực bản đồ + Form liên hệ ***** -->
    <div class="contact-us">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div id="map">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1391.732300550644!2d105.86224494844109!3d20.996439965032664!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ac0f913c7501%3A0x495704c55f846ab3!2zMzYyIFAuIE1pbmggS2hhaSwgVsSpbmggVHV5LCBIYWkgQsOgIFRyxrBuZywgSMOgIE7hu5lp!5e1!3m2!1svi!2s!4v1747670740599!5m2!1svi!2s"
                            width="100%" height="400px" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="section-heading">
                        <h2>Gửi lời nhắn cho chúng tôi</h2>
                        <span>Mọi ý kiến đóng góp sẽ giúp chúng tôi phục vụ bạn tốt hơn mỗi ngày</span>
                    </div>
                    <form id="contact" action="" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <fieldset>
                                    <input name="name" type="text" id="name" placeholder="Họ và tên" required="">
                                </fieldset>
                            </div>
                            <div class="col-lg-6">
                                <fieldset>
                                    <input name="email" type="text" id="email" placeholder="Địa chỉ email" required="">
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <textarea name="message" rows="6" id="message" placeholder="Nội dung lời nhắn"
                                              required=""></textarea>
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <button type="submit" id="form-submit" class="main-dark-button">
                                        <i class="fa fa-paper-plane"></i> Gửi liên hệ
                                    </button>
                                </fieldset>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ***** Khu vực đăng ký nhận tin tức ***** -->
    <div class="subscribe">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="section-heading">
                        <h2>Đăng ký nhận tin để nhận ưu đãi 30%</h2>
                        <span>Chúng tôi luôn cập nhật các chương trình khuyến mãi mới nhất dành cho bạn.</span>
                    </div>
                    <form id="subscribe" action="" method="get">
                        <div class="row">
                            <div class="col-lg-5">
                                <fieldset>
                                    <input name="name" type="text" id="name" placeholder="Họ tên của bạn" required="">
                                </fieldset>
                            </div>
                            <div class="col-lg-5">
                                <fieldset>
                                    <input name="email" type="text" id="email" placeholder="Email của bạn" required="">
                                </fieldset>
                            </div>
                            <div class="col-lg-2">
                                <fieldset>
                                    <button type="submit" id="form-submit" class="main-dark-button">
                                        <i class="fa fa-paper-plane"></i>
                                    </button>
                                </fieldset>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-6">
                            <ul>
                                <li>Địa chỉ cửa hàng:<br><span>123 Đường Nguyễn Trãi, Quận 1, TP.HCM</span></li>
                                <li>Điện thoại:<br><span>0901 234 567</span></li>
                                <li>Văn phòng:<br><span>TP. Thủ Đức, Hồ Chí Minh</span></li>
                            </ul>
                        </div>
                        <div class="col-6">
                            <ul>
                                <li>Giờ làm việc:<br><span>08:00 - 21:00 mỗi ngày</span></li>
                                <li>Email:<br><span>hotro@roway.vn</span></li>
                                <li>Mạng xã hội:<br>
                                    <span>
                                    <a href="#">Facebook</a>,
                                    <a href="#">Instagram</a>,
                                    <a href="#">Zalo</a>,
                                    <a href="#">Tiktok</a>
                                </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
