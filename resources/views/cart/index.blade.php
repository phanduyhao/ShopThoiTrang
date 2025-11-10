@extends('layouts.layout')
@section('content')
<style>
    .number{
        border: 1px solid #D6D8DB;
        border-radius: 3px;
        width: fit-content;
    }
    .numberInput {
        width: 50px;
        text-align: center;
        height: 45px;
        border-top: 0;
        border-bottom: 0;
        border-left: 1px solid #D6D8DB;
        border-right: 1px solid #D6D8DB;
    }
    .product-infor .numberInput:focus{
        outline: none;
    }
    .decreaseButton, .increaseButton{
        width: 100px;
        width: 30px;
        font-size: 35px;
        height: 45px;
        vertical-align: middle;
        border: 0;
        color: #D6D8DB;
        background: none;
    }
    .increaseButton {
        font-size: 25px;
        margin-left: -5px;
        padding-bottom: 5px; 
    }
    .decreaseButton {
        margin-top: -13px;
        margin-right: -5px;
        padding-bottom: 47px; 
    }
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0; 
    }
    .product__details__tab__content img{
        height: auto !important;
        width: auto !important;
    }
</style>
<section class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h4>Giỏ hàng</h4>
                    <div class="breadcrumb__links">
                        <a href="/">Trang chủ</a>
                        <a href="/shop">Cửa hàng</a>
                        <span>Giỏ hàng</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <div class="container my-5">
        <div class="dashboard-block mt-0">
            <div class="bg-warning p-2 font-weight-bold" style="width:fit-content; border-radius: 6px">Số lượng: <span>{{count($carts)}}</span></div>
            <!-- Start Items Area -->
            <form class="" action="">

            </form>
            <div class="my-items">
                <!-- Start List Title -->
                <div class="item-list-title">
                    <div class="row align-items-center text-center bg-light mt-3">
                        <div class="col-1 ">
                            <p class="font-weight-bold">STT</p>
                        </div>
                        <div class="col-md-1 col-12">
                            <p class="font-weight-bold">Ảnh</p>
                        </div>
                        <div class="col-md-2 col-12">
                            <p class="font-weight-bold">Tên sản phẩm</p>
                        </div>
                        <div class="col-md-2 col-12 ">
                            <p class="font-weight-bold">Giá</p>
                        </div>
                        <div class="col-md-2 col-12 ">
                            <p class="font-weight-bold">Số lượng</p>
                        </div>
                         <div class="col-md-1 col-12 ">
                            <p class="font-weight-bold">Loại</p>
                        </div>
                        <div class="col-md-2 col-12 ">
                            <p class="font-weight-bold">Tổng</p>
                        </div>
                        <div class="col-md-1 col-12 ">
                            <p class="font-weight-bold">Xóa</p>
                        </div>
                    </div>
                </div>
                <!-- End List Title -->
                <!-- Start Single List -->
                @foreach($carts as $cart)
                    <div class="single-item-list text-center border-bottom py-3" data-cart-id="{{ $cart->id }}">
                        <div class="row align-items-center">
                            <div class="col-1">{{ $loop->iteration }}</div>
                            <div class="col-md-1 col-12">
                                <img class="w-100 thumb-product" src="{{$cart->thumb}}" alt="{{$cart->nameProduct}}">
                            </div>
                            <div class="col-md-2 col-12">
                                <a class="title-product" href="{{ route('products.details', ['slug' =>$cart->Product->slug]) }}"><h6 class="text-primary font-weight-bold ">{{$cart->nameProduct}}</h6></a>
                            </div>
                            <div class="col-md-2 col-12">
                                <span class="price price-product">{{ number_format($cart->price) }} VNĐ</span>
                            </div>
                            <div class="col-md-2 col-12 product-infor form-add-to-cart" id="form-add-to-cart-{{$cart->id}}">
                                <div class="number mx-auto">
                                    <button type="button " class="decreaseButton" id="decreaseButton">-</button>
                                    <input name="quanity" class="quantity numberInput" type="number" inputmode="numeric" id="numberInput" data-cart-id="{{ $cart->id }}"
                                           value="{{ $cart->quanity }}" min="0">
                                    <button type="button " class="increaseButton" id="increaseButton">+</button>
                                </div>
                            </div>
                             <div class="col-md-1 col-12">
                                <span class="types">{{$cart->types}} </span>
                            </div>
                            <div class="col-md-2 col-12">
                                <span id="subtotal-{{ $cart->id }}" class="subtotal">{{ number_format($cart->subtotal) }} VNĐ</span>
                            </div>
                            <div class="col-md-1 col-12 align-right">
                                <form method="post" action="{{ route('carts.destroy', ['id' => $cart->id]) }}" class="action-btn text-center">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="border-0 bg-transparent">
                                        <i class="fa fa-close"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="d-flex justify-content-between  mt-3">
                    <a href="" id="updateCartButton" class="btn btn-success">Cập nhật</a>
                    <a href="" id="buy-products" class="btn btn-info">Mua hàng</a>
                </div>

                <!-- End Single List -->
                <!-- Pagination -->
                <div class="pagination left">
                    <div class="pagination mt-4 pb-4">
                        {{ $carts->links() }}
                    </div>
                </div>
                <!--/ End Pagination -->
            </div>
            <!-- End Items Area -->
        </div>

    </div>
@endsection
