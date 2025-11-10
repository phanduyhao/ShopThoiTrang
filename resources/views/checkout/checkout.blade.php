@extends('layouts.layout')
@section('content')

<section class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h4>Mua hàng</h4>
                    <div class="breadcrumb__links">
                        <a href="/">Trang chủ</a>
                        <a href="/cart">Giỏ hàng</a>
                        <span>Mua hàng</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <div class="container my-5">
        <div class="row">
            <div class="dashboard-block col-md-9 col-12 mt-0">

                <div class="my-items">
                    <!-- Start List Title -->
                    <div class="item-list-title">
                        <div class="row align-items-center text-center bg-light pt-2">
                            <div class="col-1 ">
                                <p>STT</p>
                            </div>
                            <div class="col-md-1 col-12">
                                <p>Ảnh</p>
                            </div>
                            <div class="col-md-4 col-12">
                                <p>Tên sản phẩm</p>
                            </div>
                            <div class="col-md-2 col-12 ">
                                <p>Loại</p>
                            </div>
                            <div class="col-md-2 col-12 ">
                                <p>Số lượng</p>
                            </div>
                            <div class="col-md-2 col-12 ">
                                <p>Tổng</p>
                            </div>
                        </div>
                    </div>
                    <!-- End List Title -->
                    <!-- Start Single List -->
                    <div class="infor-product-session"></div>
                    <h5 data-gia="{{$giavanchuyen}}" class="mt-4 font-weight-bold text-danger giavanchuyen">- Giá vận chuyển : {{ number_format($giavanchuyen, 0, ',', '.') }} VNĐ</h5>
                    <div class="d-flex justify-content-end mt-4">
                        <div class="d-flex align-items-center">
                            <h4  class=" font-weight-bold mb-0">Tổng tiền: </h4>
                            <h4 class="total mb-0 ms-2 font-weight-bold"></h4>
                        </div>

                    </div>

                </div>
                <!-- End Items Area -->
            </div>
            <div class="col-md-3 col-12">
                <ul id="nav" class="navbar-nav ms-auto mb-2">
                    <li class="nav-item">
                        <div class="header__top__hover">
                            <h5 class="font-weight-bold">- Địa chỉ đã có <i class="arrow_carrot-down"></i></h5>
                            <ul>
                                @if(count($addresses) > 0)
                                @foreach($addresses as $address)
                                    <li data-address-id="{{$address->id}}" class="nav-item address-exist py-2 border" id="address-exist-{{$address->id}}">
                                        <a href="javascript:void(0)">
                                            <span style="width:max-content" class="text-dark font-weight-bold sdt">{{$address->sdt}} </span>
                                            <span style="width:max-content" class="text-dark font-weight-bold name">{{$address->name}} </span>
                                            <span style="width:max-content" class="text-dark font-weight-bold country">{{$address->Country}} </span>
                                            <span style="width:max-content" class="text-dark font-weight-bold province">{{$address->province}} </span>
                                            <span style="width:max-content" class="text-dark font-weight-bold district">{{$address->district}} </span>
                                            <span style="width:max-content" class="text-dark font-weight-bold wards">{{$address->wards}} </span>
                                            <span style="width:max-content" class="text-dark font-weight-bold address">{{$address->address}}</span>
                                        </a>
                                    </li>
                                @endforeach
                            @else
                                <li  class="nav-item address-exist" >
                                    <a href="javascript:void(0)">
                                        Chưa có địa chỉ nào, vui lòng nhập địa chỉ!
                                    </a>
                                </li>
                            @endif
                            </ul>
                        </div>
                    </li>

                </ul>

                <h5 class="font-weight-bold">- Nhập địa chỉ mới:</h5>
                @if(session('error'))
                    <div class="alert alert-danger mt-3">
                        {{ session('error') }}
                    </div>
                @endif
                <form method="post" action="{{route('checkout.checkout')}}" id="form-process-checkout" class=" mt-4">
                    @csrf
                    <div id="total-price"></div>
                    <div id="total-price2"></div>
                    <div class="error">
                        @include('admin.error')
                    </div>
                    <div class="mb-2">
                        <label for="" class="form-label fw-bold text-dark fs-6">Số điện thoại</label>
                        <input type="text" name="sdt" class="input-field form-control input-sdt" data-required="Mời nhập số điện thoại" id="" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-2">
                        <label for="" class="form-label fw-bold text-dark fs-6">Họ tên</label>
                        <input type="text" name="name" class="input-field form-control input-name" data-required="Mời nhập tên" id="" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-2">
                        <label for="" class="form-label fw-bold text-dark fs-6">Đất nước</label>
                        <input type="text" name="Country" class="input-field form-control input-country" data-required="Mời nhập quốc gia" id="" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-2">
                        <label for="" class="form-label fw-bold text-dark fs-6">Tỉnh / Thành phố</label>
                        <input type="text" name="province" class="input-field form-control input-province" data-required="Mời nhập tỉnh " id="" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-2">
                        <label for="" class="form-label fw-bold text-dark fs-6">Quận / Huyện</label>
                        <input type="text" name="district" class="input-field form-control input-district" data-required="Mời nhập quận / huyện " id="" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-2">
                        <label for="" class="form-label fw-bold text-dark fs-6">Xã / Phường</label>
                        <input type="text" name="wards" class="input-field form-control input-wards" data-required="Mời nhập xã / phường" id="" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-2">
                        <label for="" class="form-label fw-bold text-dark fs-6">Thôn / Xóm / Đường / Số nhà</label>
                        <input type="text" name="address" class="input-field form-control input-address" data-required="Mời nhập địa chỉ cụ thể" id="" aria-describedby="emailHelp">
                    </div>
                    {{-- <button class="btn btn-success btn-checkout float-end fw-bold mt-2" type="submit">Thanh toán</button> --}}
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary btn-thanhtoan" data-toggle="modal" data-target="#exampleModal">
                        Thanh toán
                    </button>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Chọn phương thức thanh toán</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body d-flex flex-column">
                                    <button class="btn btn-warning mb-3"  type="submit" >Thanh toán trực tiếp</button>
                                    <button id="vnpay-payment-btn" class="btn btn-danger">Thanh toán Online bằng VNPAY</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
