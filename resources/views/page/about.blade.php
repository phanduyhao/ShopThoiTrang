@extends('layouts.layout')
@section('content')

<section class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h4>Về Chúng Tôi</h4>
                    <div class="breadcrumb__links">
                        <a href="/">Trang Chủ</a>
                        <span>Về Chúng Tôi</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="about spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="about__pic">
                    {{-- Thay ảnh thời trang --}}
                    <img src="/temp/assets/img/about/about-us.jpg" alt="">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="testimonial">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 p-0">
                <div class="testimonial__text">
                    <span class="icon_quotations"></span>
                    <p>“Phong cách là cách bạn nói cho thế giới biết bạn là ai – ngay cả khi bạn không nói gì cả.”</p>

                    <div class="testimonial__author">
                        <div class="testimonial__author__pic">
                            {{-- Ảnh stylist --}}
                            <img src="/temp/assets/img/about/testimonial-author.jpg" alt="">
                        </div>
                        <div class="testimonial__author__text">
                            <h5>Hòang Trang</h5>
                            <p>Chuyên gia thời trang</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 p-0">
                {{-- Ảnh banner thời trang --}}
                <div class="testimonial__pic set-bg"
                    data-setbg="/temp/assets/img/about/blog4.jpg"
                    style="background-image: url('/temp/assets/img/about/blog4.jpg');">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="counter spad">
    <div class="container">
        <div class="row">

             <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="counter__item">
                    <div class="counter__item__number">
                        <h2 class="cn_num">102</h2>
                    </div>
                    <span>Khách Hàng Của Chúng Tôi</span>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="counter__item">
                    <div class="counter__item__number">
                        <h2 class="cn_num">120</h2>
                    </div>
                    <span>Bộ sưu tập <br>Thời trang</span>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="counter__item">
                    <div class="counter__item__number">
                        <h2 class="cn_num">15</h2>
                    </div>
                    <span>Quốc gia <br>vận chuyển</span>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="counter__item">
                    <div class="counter__item__number">
                        <h2 class="cn_num">98</h2>
                        <strong>%</strong>
                    </div>
                    <span>Khách hàng <br>Hài lòng</span>
                </div>
            </div>

        </div>
    </div>
</section>

<section class="clients spad" style="padding-top: 100px">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <span>Thương Hiệu Đồng Hành</span>
                    <h2>Đối tác thời trang</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-4 col-6">
                <a href="#" class="client__item"><img src="/temp/assets/img/clients/client-1.png" alt=""></a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-4 col-6">
                <a href="#" class="client__item"><img src="/temp/assets/img/clients/client-2.png" alt=""></a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-4 col-6">
                <a href="#" class="client__item"><img src="/temp/assets/img/clients/client-3.png" alt=""></a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-4 col-6">
                <a href="#" class="client__item"><img src="/temp/assets/img/clients/client-4.png" alt=""></a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-4 col-6">
                <a href="#" class="client__item"><img src="/temp/assets/img/clients/client-5.png" alt=""></a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-4 col-6">
                <a href="#" class="client__item"><img src="/temp/assets/img/clients/client-6.png" alt=""></a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-4 col-6">
                <a href="#" class="client__item"><img src="/temp/assets/img/clients/client-7.png" alt=""></a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-4 col-6">
                <a href="#" class="client__item"><img src="/temp/assets/img/clients/client-8.png" alt=""></a>
            </div>
        </div>

    </div>
</section>

@endsection
