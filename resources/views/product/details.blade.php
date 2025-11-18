@extends('layouts.layout')
@section('content')
<style>
    .radio-toolbar input[type="radio"] {
        display: none;
    }
    .radio-toolbar label {
        display: inline-block;
        background-color: #ddd;
        padding: 5px 20px;
        cursor: pointer;
    }
    .radio-toolbar input[type="radio"]:checked+label {
        background-color: #333;
        color:#fff
    }
    .radio-toolbar input[type="radio"]+label:hover {
        transition: transform .2s;
        transform: scale(1.2);
    }
    .product-info .number{
        width: max-content;
        border: 1px solid #D6D8DB;
        border-radius: 3px;
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
    .comment-list{
        max-height: 400px;
        overflow-y: auto;
    }
    .description{
        max-height: 200vh;
        overflow-y: auto;
    }
    .comment-avata {
        background-color: #e0e0e0;
        border-radius: 50%;
        height: 50px;
        width: 50px; }

        .comment-avata i {
        font-size: 20px;
        color: #2a70b8; }

        .comment-user-info text-left w-100-item a {
        text-decoration: none;
        font-size: 16px;
        font-weight: 600; }

        .comment-user-info text-left w-100-item i {
        font-size: 15px; }

        .comment-user-info text-left w-100-item span {
        font-size: 14px;
        color: #b5b5b5; }

        .comment-user-desc {
        font-size: 15px; }
          .swiper {
      width: 100%;
      height: 100%;
    }

    .swiper-slide {
      text-align: center;
      font-size: 18px;
      background: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .swiper-slide img {
      display: block;
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .swiper {
      width: 100%;
      height: 300px;
      margin-left: auto;
      margin-right: auto;
    }

    .swiper-slide {
      background-size: cover;
      background-position: center;
    }

    .mySwiper2 {
      aspect-ratio: 1;
        height: auto;
        width: 100%;
        object-fit: cover;
    }

    .mySwiper {
      height: 20%;
      box-sizing: border-box;
      padding: 10px 0;
    }

    .mySwiper .swiper-slide {
      width: 25%;
      height: 100%;
      opacity: 0.4;
    }

    .mySwiper .swiper-slide-thumb-active {
      opacity: 1;
    }

    .swiper-slide img {
      display: block;
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
</style>
    <!-- Shop Details Section Begin -->
    <section class="shop-details">
        <div class="product__details__pic mb-0">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product__details__breadcrumb">
                            <a href="/">Trang chủ</a>
                            <a href="/shop">Cửa hàng</a>
                            <span>{{$product->Title}}</span>
                        </div>
                    </div>
                </div>
               <div class="row bg-white py-4">
                <!-- Cột ảnh chi tiết -->
                <div class="col-lg-6 col-md-9">
                    <div class="tab-content">
                    <div class="tab-pane active" id="tabs-1" role="tabpanel">
                        <div>
                        <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper mySwiper2">
                            <div class="swiper-wrapper">
                            @foreach(json_decode($product->images, true) ?? [] as $image)
                                <div class="swiper-slide">
                                <img src="/temp/images/product/{{ $image }}" class="img-detail mx-auto" alt="Ảnh chi tiết" />
                                </div>
                            @endforeach
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>

                        <div thumbsSlider="" class="swiper mySwiper">
                            <div class="swiper-wrapper">
                            @foreach(json_decode($product->images, true) ?? [] as $image)
                                <div class="swiper-slide">
                                <img src="/temp/images/product/{{ $image }}" class="img-detail mx-auto" alt="Ảnh thumbnail" />
                                </div>
                            @endforeach
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>

                <!-- Cột thông tin sản phẩm -->
                <div class="col-lg-6 col-md-3">
                    <div class="product__details__text text-left product-infor-main product-info">
                    <h4 class="title-product-detail">{{ $product->Title }}</h4>
                    <div class="rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-o"></i>
                        <span> - 5 Reviews</span>
                    </div>

                    @if($product->discount > 0)
                        <h5 class="discount text-danger font-weight-bold" style="text-decoration: line-through;">
                        {{ number_format($product->price) }} VNĐ
                        </h5>
                        <h4 class="price okPrice-product text-info font-weight-bold">
                        {{ number_format($product->discount) }} VNĐ
                        </h4>
                    @else
                        <h4 class="price okPrice-product text-info font-weight-bold">
                        {{ number_format($product->price) }} VNĐ
                        </h4>
                    @endif
                    @if(!empty($types))
                        <div class="product__details__option">
                            <div class="radio-toolbar">
                                <span>Phân Loại:</span>
                                @foreach($types as $type)
                                    <input type="radio" id="{{ $type }}" name="types" value="{{ $type }}" checked>
                                    <label for="{{ $type }}">{{ $type }}</label>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="d-flex form-add-to-cart" id="form-add-to-cart-details">
                        @if($product->Amounts > 0)
                        <div class="number me-3">
                            <button type="button" class="decreaseButton text-dark" id="decreaseButton">-</button>
                            <input name="quantity" class="quantity numberInput" type="number" inputmode="numeric" id="numberInput" value="0" min="0" />
                            <button type="button" class="increaseButton text-dark" id="increaseButton">+</button>
                        </div>
                        <a href="#"
                            data-user-id="{{ Auth::id() }}"
                            data-product-id="{{ $product->id }}"
                            data-quantity="{{ $product->Amounts }}"
                            class="btn ml-4 primary-btn rounded-2 add-to-cart call d-flex align-items-center px-3 py-2">
                            <svg style="width: 24px; height: 24px" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#e6e6e6" viewBox="0 0 256 256">
                            <path d="M96,216a16,16,0,1,1-16-16A16,16,0,0,1,96,216Zm88-16a16,16,0,1,0,16,16A16,16,0,0,0,184,200ZM230.44,67.25A8,8,0,0,0,224,64H48.32L40.21,35.6A16.08,16.08,0,0,0,24.82,24H8A8,8,0,0,0,8,40H24.82L61,166.59A24.11,24.11,0,0,0,84.07,184h96.11a23.89,23.89,0,0,0,22.94-16.94l28.53-92.71A8,8,0,0,0,230.44,67.25Z"></path>
                            </svg>
                            <span class="ms-2 fw-bold fs-6">Thêm vào giỏ</span>
                        </a>
                        @else
                        <h4 class="p-2 text-white bg-danger">Hết hàng!</h4>
                        @endif
                    </div>

                    <div class="product__details__btns__option mt-4">
                        <a href="#"><i class="fa fa-heart"></i> add to wishlist</a>
                        <a href="#"><i class="fa fa-exchange"></i> Add To Compare</a>
                    </div>

                    <div class="product__details__last__option">
                        <h5><span>Guaranteed Safe Checkout</span></h5>
                        <img src="/temp/assets/img/shop-details/details-payment.png" alt="Thanh toán an toàn" />
                    </div>
                    </div>
                </div>
                </div>

            </div>
            
        <div class="item-details-blocks container mt-5 py-5 px-0">
            <div class="row">
                <div class="col-12">
                    <!-- Start Single Block -->
                    <div class="single-block bg-white p-3 description">
                        <h2 class="font-weight-bold text-danger text-left my-3">Thông tin chi tiết:</h2>
                        <div class="p-4 text-left">
                            {!! $product->content !!}
                        </div>
                    </div>
                    <!-- End Single Block -->
                
                </div>
              
            </div>
  {{--    COMMENTS    --}}
  <div id="list-comment__data" class="list-product mt-5 p-5 bg-white" data-comment-limit="{{$initialCommentsCount}}" data-load-more="{{ $loadMoreCommentsCount }}" data-total-cmt="{{ $comments->count() }}">
    <div class="content-titel d-flex justify-content-between">
        <h4 class="fw-bold text-black mb-3">Bình luận</h4>
    </div>

    <div class="comment container-width mt-5" id="comment_area">
        <!-- TEST -->
        @guest
        @else
        <form id="boxCommentForm" class="comment-box" data-action="{{route('sendComment')}}">
            @csrf
            <input type="hidden" name="product" value="{{ $product->id }}">

            <!-- Đặt parent_comment_id -->

            <div class="d-flex">
                <div class="comment-avata d-flex align-items-center justify-content-center mr-2">
                    @if(Auth::user()->avatar == null)
                        <img src="/temp/images/user.png" width="30" alt="">
                    @else
                        <img width="50" height="50" class="rounded-circle my-avatar" src="/temp/images/avatars/{{Auth::user()->avatar}}" alt="Avatar">
                    @endif
                </div>
                <div class="form-comment w-100">
                    <textarea name="comment" class="input-field textarea-note p-3 w-100" id="" rows="3" placeholder="Nhập bình luận *" data-require="Vui lòng nhập nội dung!"></textarea>
                </div>
            </div>
            <button type="submit" class="send-comment float-right btn btn-primary mt-3">Gửi bình luận</button>
        </form>
        @endguest

{{--    Comments Parent    --}}
        <div class="comment-list mt-5 overflow-scroll h-75vh">
            @foreach($comments->sortByDesc('created_at') as $comment)
                @if($comment->parent_comment_id == null)
                    <div class="comment-user " data-id="{{ $comment->id }}" data-comment-index="{{ $loop->index + 1 }}">
                        <div class="comments-users d-flex mb-4">
                            <div class="comment-avata d-flex align-items-center justify-content-center mr-3">
                                @if($comment->User->avatar == null)
                                    <img src="/temp/images/user.png" width="30" alt="">
                                @else
                                    <img width="50" height="50" class="rounded-circle" src="/temp/images/avatars/{{$comment->User->avatar}}" alt="Avatar">
                                @endif
                            </div>
                            <div class="comment-user-info text-left w-100">
                                <div class="comment-user-info text-left w-100-item">
                                    <a href="">{{$comment->User->name}}</a>
                                </div>
                                <div class="comment-user-info text-left w-100-item">
                                    <i class="fa-solid fa-calendar-days "></i>
                                    <span >{{$comment->created_at}}</span>
                                </div>
                                <div class="comment-user-info text-left w-100-item">
                                    <p class="comment-user-desc m-0 mt-3">
                                        {{$comment->comment}}
                                    </p>
                                </div>

{{-- Reply comments --}}
                                <div class="reply">
                                    <p class="reply-text  mt-2">
                                        <a class="reply-text__link fw-bold text-info" href="">
                                            Trả lời
                                        </a>
                                    </p>
                                    <!-- TEST -->
                                    @guest
                                    @else
                                        <form id="boxCommentFormReply_{{ $comment->id }}" class="comment-box child d-none bg-white p-3" data-action="{{route('sendComment')}}" >
                                            <p id="{{ $comment->id }}" class="boxCommentFormReplyID d-none"></p>
                                            @csrf
                                            <input type="hidden" name="product" value="{{ $product->id }}"> <!-- Đặt parent_comment_id -->
                                            <input type="hidden" name="parent_comment_id" value="{{ $comment->id }}"> <!-- Đặt parent_comment_id -->
                                            <div class="d-flex">
                                                <div class="comment-avata d-flex align-items-center justify-content-center mr-2">
                                                    @if(Auth::user()->avatar == null)
                                                        <img src="/temp/images/user.png" width="30" alt="">
                                                    @else
                                                        <img width="50" height="50" class="rounded-circle" src="/temp/images/avatars/{{Auth::user()->avatar}}" alt="Avatar">
                                                    @endif
                                                </div>
                                                <div class="form-comment w-100">
                                                    <textarea name="comment" class="input-field textarea-note w-100 p-3" id="" rows="3" placeholder="Nhập bình luận *" data-require="Vui lòng nhập nội dung!"></textarea>
                                                </div>
                                            </div>
                                            <button type="submit" class="send-comment float-right btn btn-primary mt-3">Gửi bình luận</button>
                                        </form>
                                    @endguest
                                    @if($comment->hasChildren())
                                    <div class="reply-box bg-white p-3">
                                        @php
                                            $comment_childs = $comments;
                                        @endphp
                                        <div class="comment-list__child-{{ $comment->id }}">
                                            @foreach($comment_childs->sortByDesc('created_at') as $comment_child)
                                                @if($comment_child->parent_comment_id == $comment->id)
                                                    <div class="d-flex mb-4">
                                                        <div class="comment-avata d-flex align-items-center justify-content-center mr-3">
                                                            @if($comment_child->User->avatar == null)
                                                                <img src="/temp/images/user.png" width="30" alt="">
                                                            @else
                                                                <img width="50" height="50" class="rounded-circle" src="/temp/images/avatars/2" alt="Avatar">
                                                            @endif
                                                        </div>
                                                        <div class="comment-user-info text-left w-100 ">
                                                            <div class="comment-user-info text-left w-100-item">
                                                                <a href="">{{$comment_child->User->name}}</a>
                                                            </div>
                                                            <div class="comment-user-info text-left w-100-item">
                                                                <i class="fa-solid fa-calendar-days "></i>
                                                                <span >{{$comment_child->created_at}}</span>
                                                            </div>
                                                            <div class="comment-user-info text-left w-100-item">
                                                                <p class="comment-user-desc m-0 mt-3">
                                                                    {{$comment_child->comment}}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <button data-doc-id="{{ $product->id }}" data-initComment="{{ $initialCommentsCount }}" data-loadComment="{{ $loadMoreCommentsCount }}" id="load-more-comments-btn" class="btn btn-primary fs-6 fw-bold mt-3">Xem thêm bình luận</button>
    </div>
</div>
        </div>
        </div>
        
    </section>
    <!-- Shop Details Section End -->

    <!-- Related Section Begin -->
    <section class="related spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="related-title">Sản phẩm mới nhất</h3>
                </div>
            </div>
            <div class="row">
                @foreach($new_products as $product)
                    <div id="product-infor-list-{{$product->id}}" class="col-lg-3 col-md-6 col-sm-6 product-infor-main">
                        <input type="number" hidden class="quantity" value="1">
                        <div class="product__item">
                            <div class="product__item__pic set-bg position-relative" data-setbg="/temp/images/product/{{$product->thumb}}">
                                <img class="thumb-product d-none" src="/temp/images/product/{{$product->thumb}}" alt="{{$product->title}}">
                                <a href="{{ route('products.details', ['slug' =>$product->slug]) }}" class="detail-product-bg position-absolute" style="bottom: 0; top: 0; right: 0; left: 0"></a>
                                <a href="" class="badge badge-warning position-relative z-20">{{$product->Category->title ?? ''}}</a>
                                <ul class="product__hover">
                                    <li><a href="{{ route('products.details', ['slug' =>$product->slug]) }}"><img src="/temp/assets/img//icon/search.png" alt=""><span>Chi tiết</span></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6 class="my-2 title-product">{{$product->Title}}</h6>
                                <a data-user-id="{{ Auth::id() }}" data-product-id="{{$product->id}}" data-quantity="{{ $product->Amounts }}" href="{{ route('products.details', ['slug' =>$product->slug]) }}"class="add-cart">Chi tiết sản phẩm</a>
                                <div class="border-top pt-2">
                                    @if($product->discount > 0)
                                        <div class="discount text-danger font-weight-bold" style="text-decoration: line-through; font-size:13px">{{ number_format($product->price) }} VNĐ</div>
                                        <div class="price okPrice-product text-info font-weight-bold">{{ number_format($product->discount) }} VNĐ</div>
                                    @else
                                        <div class="price okPrice-product text-info font-weight-bold">{{ number_format($product->price) }} VNĐ</div>
                                    @endif
                                </div>
                                {{-- <div class="product__color__select">
                                    <label for="pc-4">
                                        <input type="radio" id="pc-4">
                                    </label>
                                    <label class="active black" for="pc-5">
                                        <input type="radio" id="pc-5">
                                    </label>
                                    <label class="grey" for="pc-6">
                                        <input type="radio" id="pc-6">
                                    </label>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
<script>

</script>