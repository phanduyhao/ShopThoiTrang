@extends('admin.main')

@section('contents')
<div class="container">
    <h3 class="fw-bold text-primary py-3 mb-4">Cấu hình hệ thống</h3>

    <div id="alert-success" class="alert alert-success d-none"></div>
    <div id="alert-error" class="alert alert-danger d-none"></div>

    <div class="card">
        <div class="card-body">
            <form id="settings-form">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Giá vận chuyển</label>
                    <input type="text" class="form-control" id="gia_van_chuyen" 
                        placeholder="Nhập giá vận chuyển" 
                        value="{{ $settings['gia_van_chuyen'] ?? '' }}" />
                </div>

                <button type="button" class="btn btn-success" id="save-settings">Cập nhật</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#save-settings').click(function() {
        let value = $('#gia_van_chuyen').val();
        
        $.ajax({
            url: '{{ route('settings.update.ajax') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                setting_code: 'gia_van_chuyen',
                value: value
            },
            success: function(response) {
                if (response.success) {
                    $('#alert-success').text(response.message).removeClass('d-none');
                    $('#alert-error').addClass('d-none');
                }
            },
            error: function(xhr) {
                $('#alert-error').text('Lỗi cập nhật!').removeClass('d-none');
                $('#alert-success').addClass('d-none');
            }
        });
    });
});
</script>
@endsection
