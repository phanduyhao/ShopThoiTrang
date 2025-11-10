@extends('layouts.layout')
@section('content')

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
                                        <a href="{{ route('profile.index') }}" class="nav-link ">
                                            <i class="bi bi-house-door"></i> Thông tin cá nhân
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('myOrder') }}" class="nav-link">
                                            <i class="bi bi-card-list"></i> Đơn mua
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('showChangePass') }}" class="nav-link active" >
                                            <i class="bi bi-key"></i> Thay đổi mật khẩu
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            
                            
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9 col-md-8">
                <!-- Personal Information -->
                <div class="dashboard-wrapper bg-white rounded-3 shadow-sm">
                    <div class="form-submit">
                        <div class="error">
                            @include('admin.error')
                        </div>
                        <form action="{{ route('changePass') }}" method="post" class="form-change-password" id="form-change-password">
                            @csrf
                            <h4>Thay đổi mật khẩu</h4>
                            <div class="submit-section">
                                <div class="row">
                                    <div class="form-group col-lg-12 col-md-6">
                                        <label>Mật khẩu cũ</label>
                                        <input type="password" class="form-control input-field" data-require="Mời nhập mật khẩu cũ!" name="old_password" required>
                                        <span class="error-message text-danger"></span>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Mật khẩu mới</label>
                                        <input type="password" class="form-control input-field" data-require="Mời nhập mật khẩu mới!" name="new_password" required>
                                        <span class="error-message text-danger"></span>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Xác nhận mật khẩu</label>
                                        <input type="password" class="form-control input-field" data-require="Hãy xác nhận lại mật khẩu!" name="new_password_confirmation" required>
                                        <span class="error-message text-danger"></span>
                                    </div>
                                    <div class="form-group col-lg-12 col-md-12">
                                        <button class="btn btn-primary px-5 rounded" type="submit">Lưu lại</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
