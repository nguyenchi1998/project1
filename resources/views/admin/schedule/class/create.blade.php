@extends('layouts.manager')
@section('title')
    Quản Lý Tín Chỉ
@endsection
@section('breadcrumb')
    <div class="page-header">
        <h3 class="page-title">Đăng Ký</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.schedules.index') }}">Danh Sách Tín Chỉ</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    Đăng Ký
                </li>
            </ol>
        </nav>
    </div>
@endsection
@section('main')
    <div class="row">
        <div class="col-lg-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="mb-5">
                    </div>
                    <div class="table-responsive mb-3">

                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Môn Học</th>
                                <th>Số sinh viên đăng ký</th>
                                <th>Ngày Bắt Đầu</th>
                                <th>Giảng Viên Dạy</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($scheduleDetails as  $scheduleDetail)
                                {{ Form::open(['url' => route('admin.schedules.register')]) }}
                                <tr>
                                    <td>
                                        {{ $scheduleDetail['subject']['name'] }}
                                        @foreach($scheduleDetail['schedule_details'] as $schedule_detail)
                                            {{ Form::text('schedule_details[]', $schedule_detail, ['hidden' => true]) }}
                                        @endforeach
                                        {{ Form::text('subject_id', $scheduleDetail['subject']['id'], ['hidden' => true]) }}
                                    </td>
                                    <td>
                                        {{ count($scheduleDetail['schedule_details']) }}
                                    </td>
                                    <td>
                                        {{ Form::date('start_time', null, ['class' => 'form-control form-control-sm', 'required' => true]) }}
                                    </td>
                                    <td>
                                        {{ Form::select('teacher_id', $scheduleDetail['subject']['teachers'], null, ['placeholder'=> 'Chọn Giảng Viên', 'class' => 'form-control form-control-sm']) }}
                                    </td>
                                    <td style="width: 100px" align="center">
                                        <button class="btn btn-sm btn-outline-success"><i class="mdi mdi-plus"></i></button>
                                    </td>
                                </tr>
                                {{ Form::close() }}
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection @section('script') @endsection