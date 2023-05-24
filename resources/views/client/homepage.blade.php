<!DOCTYPE html>
<html lang="en">

<head>
    <title>Carbook</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @include('client.share.css')
</head>

<body>

    {{-- @include('client.share.menu') --}}
    @yield('menu')
    <!-- END nav -->

    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('/client/images/bg_1.jpg');"
        data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
                <div class="col-md-9 ftco-animate pb-5">
                    {{-- <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Car details <i class="ion-ios-arrow-forward"></i></span></p> --}}
                            {{-- <h1 class="mb-3 bread">Car Details</h1> --}}
                        @yield('page')
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section ftco-car-details bg-light">
        <div class="container">
           @yield('noi_dung')
        </div>
    </section>

    <footer class="ftco-footer ftco-bg-dark ftco-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2"><a href="#" class="logo">Car<span>book</span></a></h2>
                        <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
                            <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md">
                    <div class="ftco-footer-widget mb-4 ml-md-5">
                        <h2 class="ftco-heading-2">Thông Tin</h2>
                        <ul class="list-unstyled">
                            <li><a href="#" class="py-2 d-block">Về Chúng Tôi</a></li>
                            <li><a href="#" class="py-2 d-block">Dịch Vụ</a></li>
                            <li><a href="#" class="py-2 d-block">Điều Khoản và Điều Kiện</a></li>
                            <li><a href="#" class="py-2 d-block">Giá Tốt Nhất</a></li>
                            <li><a href="#" class="py-2 d-block">Riêng Tư &amp; Chính Sách</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">Hỗ Trợ Khách Hàng</h2>
                        <ul class="list-unstyled">
                            <li><a href="#" class="py-2 d-block">FAQ</a></li>
                            <li><a href="#" class="py-2 d-block">Lựa Chọn Thanh Toán</a></li>
                            <li><a href="#" class="py-2 d-block">Các Mẹo Đặt Xe</a></li>
                            <li><a href="#" class="py-2 d-block">Cách Trang Web Làm Việc</a></li>
                            <li><a href="/client/contact" class="py-2 d-block">Kết Nối Với Chúng Tôi</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">Một Số Câu Hỏi</h2>
                        <div class="block-23 mb-3">
                            <ul>
                                <li><span class="icon icon-map-marker"></span><span class="text">03 Quang Trung, phường Hải Châu 1, quận Hải Châu, thành phố Đà Nẵng</span></li>
                                <li><a href="#"><span class="icon icon-phone"></span><span class="text">
                                            +84 905 984 432</span></a></li>
                                <li><a href="#"><span class="icon icon-envelope"></span><span
                                            class="text">KimNgan969@gmail.com</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">

                    <p>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;
                        <script>
                            document.write(new Date().getFullYear());
                        </script> All rights reserved | This template is made with <i
                            class="icon-heart color-danger" aria-hidden="true"></i> by <a href="https://colorlib.com"
                            target="_blank">Colorlib</a>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </p>
                </div>
            </div>
        </div>
    </footer>
    <!-- loader -->
    <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4"
                stroke="#eeeeee" />
            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4"
                stroke-miterlimit="10" stroke="#F96D00" />
        </svg></div>

    @include('client.share.js')
    @yield('js')
</body>
<html>
