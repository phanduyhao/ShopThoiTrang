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
                                        <a href="{{ route('profile.index') }}" class="nav-link active">
                                            <i class="bi bi-house-door"></i> Thông tin cá nhân
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('myOrder') }}" class="nav-link">
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

            <!-- Main Content -->
            <div class="col-lg-9 col-md-8">
                <!-- Personal Information -->
                <div class="dashboard-wrapper bg-white rounded-3 shadow-sm">
                    <div class="form-submit">
                        <h4 class="pt-3 px-3">Thông tin cá nhân</h4>
                        <div class="error">
                            @include('admin.error')
                        </div>
                        <form id="form-update-profile" method="POST" action="{{ route('profile.update', Auth::user()->id) }}" enctype="multipart/form-data" class="submit-section mt-3">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="form-group col-12">
                                        <div class="fr-grid-thumb mx-auto">
                                            <!-- Avatar Preview -->
                                            <label for="avatar-upload" class="d-inline-flex p-1 border cursor-pointer overflow-hidden">
                                                <img id="avatar-preview" src="{{ Auth::user()->avatar }}" width="200" class="img-fluid object-fit-cover" alt="avatar" style="height: 200px; cursor: pointer;">
                                            </label>
                                            <!-- Hidden File Input -->
                                            <input type="file" id="avatar-upload" name="avatar" class="d-none" accept="image/*" onchange="previewAvatar(event)">
                                            <!-- Buttons -->
                                            <div class="mt-2">
                                                <button type="button" class="btn btn-secondary btn-sm" onclick="document.getElementById('avatar-upload').click()">Upload ảnh</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-8 col-12 row">
                                    <div class="form-group col-md-6">
                                        <label>Tên</label>
                                        <input type="text" class="form-control input-field" data-require='Mời nhập tên!' required name="name" value="{{ Auth::user()->name }}">
                                    </div>
                                    
                                    <div class="form-group col-md-6">
                                        <label>Email</label>
                                        <input type="email" class="form-control input-field" data-require='Mời nhập email' required name="email" value="{{ Auth::user()->email }}">
                                    </div>
                                  
                                    <div class="form-group col-md-6">
                                        <label>Số điện thoại</label>
                                        <input type="text" class="form-control input-field" data-require='Mời nhập số điện thoại' required name="phone" value="{{ Auth::user()->phone }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Giới tính</label>
                                       <div class="d-flex align-items-center gap-3">
                                            <div class="form-check mr-2">
                                                <input class="form-check-input" type="radio" name="sex" value="nam" id="nam" {{ Auth::user()->sex == 'nam' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="nam">
                                                    Nam
                                                </label>
                                            </div>
                                            <div class="form-check mr-2">
                                                <input class="form-check-input" type="radio" name="sex" value="nu" id="nu" {{ Auth::user()->sex == 'nu' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="nu">
                                                    Nữ
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="sex" value="khac" id="khac" {{ Auth::user()->sex == 'khac' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="khac">
                                                    Khác
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <button class="btn btn-primary w-auto float-end" type="submit">Cập nhật</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function previewAvatar(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }
    </script>
@endsection
