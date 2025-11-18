@extends('layouts.layout')
@section('content')
    <!-- Blog Details Hero Begin -->
    <section class="blog-hero spad">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-9 text-center">
                    <div class="blog__hero__text">
                        <h2>{{$post->Title}}</h2>
                        <ul>
                            <li>By Admin</li>
                            <li>{{$post->updated_at}}</li>
                            <li>8 Comments</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Details Hero End -->

    <!-- Blog Details Section Begin -->
    <section class="blog-details spad border-bottom">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-12">
                    <div class="blog__details__pic">
                        <img src="/temp/images/post/{{$post->thumb}}" alt="{{ $post->Title }}" alt="">
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="blog__details__content">
                        {!! $post->content !!}

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Details Section End -->
<!-- Latest Posts Slider Begin -->
<section class="blog spad" style="padding-top: 20px;">
    <div class="container">
        <div class="section-title text-center">
            <h3>Bài viết mới nhất</h3>
        </div>

        <div class="row">
            <div class="owl-carousel owl-theme" id="latest-posts-slider">
                @foreach($latest_posts as $item)
                    <div class="item">
                        <div class="blog__item">
                            <div class="blog__item__pic set-bg"
                                 data-setbg="/temp/images/post/{{ $item->thumb }}">
                            </div>
                            <div class="blog__item__text">
                                <span class="d-flex align-items-center">
                                    <img src="/temp/assets/img/icon/calendar.png" class="me-2" alt="" style="width: 13px; height:13px">
                                    {{ $item->updated_at->format('d/m/Y') }}
                                </span>
                                <h5>{{ $item->Title }}</h5>
                                <a href="{{ route('posts.details', ['slug' => $item->slug]) }}">
                                    Đọc thêm
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- Latest Posts Slider End -->

@endsection
