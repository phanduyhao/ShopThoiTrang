@extends('admin.main')

@section('contents')
<div class="container">
    <h3 class="fw-bold text-primary py-3 mb-4">Thêm mới setting</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('settings.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Mã setting</label>
                    <input type="text" class="form-control" name="setting_code"
                        placeholder="Nhập mã setting" required />
                </div>

                <div class="mb-3">
                    <label class="form-label">Giá trị</label>
                    <input type="text" class="form-control" name="value"
                        placeholder="Nhập giá trị" />
                </div>

                <button type="submit" class="btn btn-primary">Lưu</button>
            </form>
        </div>
    </div>

    <a href="{{ route('settings.index') }}" class="btn btn-secondary mt-3">Quay lại</a>
</div>
@endsection
