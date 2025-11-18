@extends('layouts.layout')
@section('content')
<!-- Bản đồ Bắt Đầu -->
<div class="map">
    {{-- <iframe src="" height="500" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe> --}}
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3833.8575147612223!2d108.1393406876823!3d16.07288204491783!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x314218d53d328351%3A0x514e6b6dca5a0746!2zMjU2IMOCdSBDxqEsIEhvw6AgS2jDoW5oIELhuq9jLCBMacOqbiBDaGnhu4N1LCDEkMOgIE7hurVuZyA1NTAwMDAsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1740062676043!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe><!-- Bản đồ Kết Thúc -->

<!-- Phần Liên Hệ Bắt Đầu -->
<section class="contact spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="contact__text">
                    <div class="section-title">
                        <span>Thông Tin</span>
                        <h2>Liên Hệ Với Chúng Tôi</h2>
                        <p>Như bạn có thể mong đợi từ một công ty bắt đầu như là một nhà thầu nội thất cao cấp, chúng tôi chú trọng đến từng chi tiết.</p>
                    </div>
                    <ul>
                        <li>
                            <h4>Nghệ An</h4>
                            <p>Đại học Vinh - Phường Trường Vinh - Nghệ An <br />+84 364 941 253 <br />hoangtrang@gmail.com</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="contact__form">
                    <form id="form_contact" method="POST" action="{{route('sendFeedBack')}}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <input name="name" required type="text" placeholder="Họ và Tên">
                            </div>
                            <div class="col-lg-6">
                                <input name="email" required type="email" placeholder="Email">
                            </div>
                            <div class="col-lg-12">
                                <textarea name="contents" required placeholder="Lời Nhắn"></textarea>
                                <button type="submit" class="site-btn">Gửi Lời Nhắn</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Phần Liên Hệ Kết Thúc -->


@endsection
