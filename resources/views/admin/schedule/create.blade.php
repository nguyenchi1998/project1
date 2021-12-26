@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Quản Lý Tín Chỉ</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.home') }}">Bảng Điều Khiển</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.schedules.index') }}">Danh Sách Lớp Tín Chỉ</a>
        </li>
        <li class="breadcrumb-item active">
            Thêm
        </li>
    </ol>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-lg-12 stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="table-responsive mb-3">

                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Môn Học</th>
                                <th>Số sinh viên đăng ký</th>
                                <th>Ngày Bắt Đầu</th>
                                <th>Ngày Kết Thúc</th>
                                <th>Giảng Viên Dạy</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($scheduleDetails as $scheduleDetail)
                            {{ Form::open(['url' => route('admin.schedules.store')]) }}
                            <tr>
                                <td>
                                    {{ $scheduleDetail['subject']['name'] }}
                                    @foreach ($scheduleDetail['schedule_details'] as $schedule_detail)
                                    {{ Form::text('schedule_details[]', $schedule_detail, ['hidden' => true]) }}
                                    @endforeach
                                    {{ Form::text('subject_id', $scheduleDetail['subject']['id'], ['hidden' => true]) }}
                                </td>
                                <td>
                                    {{ count($scheduleDetail['schedule_details']) }}
                                </td>
                                <td>
                                    {{ Form::date('start_time', null, ['class' => 'form-control']) }}
                                </td>
                                <td>
                                    {{ Form::date('end_time', null, ['class' => 'form-control ']) }}
                                </td>
                                <td>
                                    {{ Form::select('teacher_id', $scheduleDetail['subject']['teachers'], null, ['placeholder' => 'Chọn Giảng Viên','class' => 'form-control ']) }}
                                </td>
                                <td style="width: 110px">
                                    <button class="btn btn-outline-success">
                                        Tạo Lớp
                                    </button>
                                </td>
                            </tr>
                            {{ Form::close() }}
                            @empty
                            <div class="pt-3 d-flex justify-content-center">
                                <h4>Empty Data</h4>
                            </div>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection @section('script')
@endsection