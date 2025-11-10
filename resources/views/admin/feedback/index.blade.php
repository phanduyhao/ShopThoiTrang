@extends('admin.main')
@section('contents')

    <div class="container-fluid flex-grow-1 container-p-y">
        <h3 class="fw-bold text-primary py-3 mb-4">{{$title}}</h3>
        <div class="card">
            <div class="d-flex p-4 justify-content-between">
                <h5 class=" fw-bold">Danh sách phản hồi</h5>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên Người gửi</th>
                        <th>Email</th>
                        <th>Nội dung</th>
                        <th>Thời gian gửi</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach($feedbacks as $feedback)
                        <tr data-id="{{$feedback->id}}">
                            <td> {{ $loop->iteration }}</td>
                            <td>{{$feedback->name}}</td>
                            <td>{{$feedback->email}}</td>
                            <td>{{$feedback->contents}}</td>
                            <td>{{$feedback->created_at}}</td>
                        </tr>

                        <!-- Modal Edit -->
                    @endforeach
                    </tbody>
                </table>
                <div class="pagination mt-4 pb-4">
                    {{ $feedbacks->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
