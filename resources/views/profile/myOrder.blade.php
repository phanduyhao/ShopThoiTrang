@extends('layouts.layout')
@section('content')
<style>
    a:hover{
        color: black !important;
    }
</style>
<section class="bg-light py-5">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 col-md-4">
                <div class="simple-sidebar sm-sidebar bg-white rounded-3 shadow-sm pt-0" id="filter_search">
                    <div class="search-sidebar_header d-flex justify-content-between">
                        <button onclick="closeFilterSearch()" class="btn btn-link">
                            <i class="fa-regular fa-circle-xmark fs-5 text-muted-2"></i>
                        </button>
                    </div>

                    <div class="sidebar-widgets">
                        <div class="dashboard-navbar text-center pt-0">
                            <div class="fr-grid-thumb mx-auto mt-5 mb-0">
                                <a href="agent-page.html" class="d-inline-flex p-1 circle border">
                                    <img src="{{ Auth::user()->avatar }}" width="150" class="img-fluid circle object-fit-cover" alt="avatar" style="height: 150px;">
                                </a>
                            </div>
                            <div class="d-user-avater mt-3">
                                <h4>{{ Auth::user()->name }}</h4>
                                <span>{{ Auth::user()->email }}</span>
                            </div>

                            <div class="d-navigation mt-3">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a href="{{ route('profile.index') }}" class="nav-link">
                                            <i class="bi bi-house-door"></i> Thông tin cá nhân
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('myOrder') }}" class="nav-link active">
                                            <i class="bi bi-card-list"></i> Đơn mua
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('showChangePass') }}" class="nav-link">
                                            <i class="bi bi-key"></i> Thay đổi mật khẩu
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content: Đơn mua -->
            <div class="col-lg-9 col-md-8">
                <!-- Tab Bar -->
                <div class="mb-4">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link active" id="order-all-tab" data-toggle="pill" href="#order-all">Đơn đã đặt</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="order-shipping-tab" data-toggle="pill" href="#order-shipping">Đơn đang giao</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="order-completed-tab" data-toggle="pill" href="#order-completed">Đơn thành công</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="order-cancelled-tab" data-toggle="pill" href="#order-cancelled">Đơn đã hủy</a>
                        </li>
                    </ul>
                </div>

                <!-- Tab content -->
                <div class="tab-content">
                    <!-- Đơn đã đặt -->
                    <div class="tab-pane fade overflow-auto show active" id="order-all">
                        <h5>Đơn đã đặt</h5>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Sản phẩm</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày đặt</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders->where('status', 1) as $order)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @foreach(json_decode($order->products) as $product)
                                                <a href="{{ route('products.details', ['slug' =>$product->slug]) }}">
                                              {{ $product->title }}
                                                </a><br>
                                                
                                                <!-- Liên kết xem chi tiết sản phẩm -->
                                                <a href="{{ route('products.details', ['slug' =>$product->slug]) }}">
                                                    <img src="{{ $product->thumb }}" width="50" alt="{{ $product->title }}"><br>
                                                </a>
                                                
                                                Giá: {{ number_format($product->price, 0, ',', '.') }} VND<br>
                                                Số lượng: {{ $product->quantity }}<br>
                                                Tổng: {{ number_format($product->subtotal, 0, ',', '.') }} VND
                                                <hr>
                                            @endforeach
                                        </td>
                                        
                                        <td>Đã đặt hàng</td>
                                        <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                        <td>
                                            <form action="{{ route('order.cancel', $order->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-danger btn-sm">Hủy đơn</button>
                                            </form>                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Đơn đang giao -->
                    <div class="tab-pane fade overflow-auto" id="order-shipping">
                        <h5>Đơn đang giao</h5>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Sản phẩm</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày đặt</th>
                                    {{-- <th>Thao tác</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders->where('status', 2) as $order)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @foreach(json_decode($order->products) as $product)
                                                <a href="{{ route('products.details', ['slug' =>$product->slug]) }}">
                                              {{ $product->title }}
                                                </a><br>
                                                
                                                <!-- Liên kết xem chi tiết sản phẩm -->
                                                <a href="{{ route('products.details', ['slug' =>$product->slug]) }}">
                                                    <img src="{{ $product->thumb }}" width="50" alt="{{ $product->title }}"><br>
                                                </a>
                                                
                                                Giá: {{ number_format($product->price, 0, ',', '.') }} VND<br>
                                                Số lượng: {{ $product->quantity }}<br>
                                                Tổng: {{ number_format($product->subtotal, 0, ',', '.') }} VND
                                                <hr>
                                            @endforeach
                                        </td>
                                        <td>Đang giao hàng</td>
                                        <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                        {{-- <td>
                                            <a href="" class="btn btn-info btn-sm">Xem chi tiết</a>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Đơn thành công -->
                    <div class="tab-pane fade overflow-auto" id="order-completed">
                        <h5>Đơn thành công</h5>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Sản phẩm</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày đặt</th>
                                    {{-- <th>Thao tác</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders->where('status', 3) as $order)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @foreach(json_decode($order->products) as $product)
                                                <a href="{{ route('products.details', ['slug' =>$product->slug]) }}">
                                              {{ $product->title }}
                                                </a><br>
                                                
                                                <!-- Liên kết xem chi tiết sản phẩm -->
                                                <a href="{{ route('products.details', ['slug' =>$product->slug]) }}">
                                                    <img src="{{ $product->thumb }}" width="50" alt="{{ $product->title }}"><br>
                                                </a>
                                                
                                                Giá: {{ number_format($product->price, 0, ',', '.') }} VND<br>
                                                Số lượng: {{ $product->quantity }}<br>
                                                Tổng: {{ number_format($product->subtotal, 0, ',', '.') }} VND
                                                <hr>
                                            @endforeach
                                        </td>
                                        <td>Giao hàng thành công</td>
                                        <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                        {{-- <td>
                                            <a href="" class="btn btn-info btn-sm">Xem chi tiết</a>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Đơn đã hủy -->
                    <div class="tab-pane fade overflow-auto" id="order-cancelled">
                        <h5>Đơn đã hủy</h5>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Sản phẩm</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày đặt</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders->where('status', 4) as $order)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @foreach(json_decode($order->products) as $product)
                                                <a href="{{ route('products.details', ['slug' =>$product->slug]) }}">
                                              {{ $product->title }}
                                                </a><br>
                                                
                                                <!-- Liên kết xem chi tiết sản phẩm -->
                                                <a href="{{ route('products.details', ['slug' =>$product->slug]) }}">
                                                    <img src="{{ $product->thumb }}" width="50" alt="{{ $product->title }}"><br>
                                                </a>
                                                
                                                Giá: {{ number_format($product->price, 0, ',', '.') }} VND<br>
                                                Số lượng: {{ $product->quantity }}<br>
                                                Tổng: {{ number_format($product->subtotal, 0, ',', '.') }} VND
                                                <hr>
                                            @endforeach
                                        </td>
                                        <td>Đã hủy đơn hàng</td>
                                        <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                        <td>
                                            <a href="{{ route('products.details', ['slug' =>$product->slug]) }}" class="btn btn-info btn-sm">Mua lại</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
