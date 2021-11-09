@extends('layouts.teacher')
@section('main')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Quản Lý Lịch Giảng Dạy</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('teacher.home') }}">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item active">Danh Sách Lịch Giảng Dạy</li>
    </ol>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-lg-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex mb-4">
                    <div class="w-25">
                        <form action="">
                            {{ Form::select('status', $states, $status ?? null, ['class' => 'form-control', 'placeholder' => 'Chọn Trạng Thái', 'onchange' => 'this.form.submit()']) }}
                        </form>
                    </div>
                </div>
                @forelse($statusSchedules as $key => $schedules)
                <div class="text text-uppercase">
                    <h4>{{ getNameSchedule($key) }}</h4>
                </div>
                <div class="table-responsive mb-3">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Lớp Học</th>
                                <th>Thời Gian Bắt Đầu</th>
                                <th>Số Sinh Viên</th>
                                <th>Trạng Thái</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schedules as $schedule)
                            <tr>
                                <td>
                                    {{ $schedule->subject->name }}
                                </td>
                                <td>
                                    {{ $schedule->start_time }}
                                </td>
                                <td>
                                    {{ count( $schedule->class->students) }}
                                </td>
                                <td>
                                    <form action="{{ route('teacher.schedules.status', $schedule->id) }}" method="POST">
                                        @csrf
                                        {{ Form::select('status', $states, $schedule->status, ['class' => 'form-control form-control-sm', 'onchange' => 'this.form.submit()', 'disabled' => $schedule->status == config('config.status.schedule.new')]) }}
                                    </form>
                                <td style="width: 150px">
                                    <div class="d-flex justify-content-center align-items-center">
                                        @if($schedule->status == config('config.status.schedule.inprogress'))
                                        <a class="btn btn-sm btn-outline-success" href="{{ route('teacher.schedules.attendanceShow', $schedule->id) }}" data-toggle="tooltip" data-placement="top" title="Điểm danh">
                                            <i class="fa fa-users"></i>
                                        </a>
                                        @elseif($schedule->status == config('config.status.schedule.marking'))
                                        <a class="btn btn-sm btn-primary" href="{{ route('teacher.schedules.markShow', $schedule->id) }}">Vào Điểm</a>
                                        @if(checkFinishMark($schedule->scheduleDetails->toArray()))
                                        <div class="ml-1">
                                            <a class="btn btn-sm btn-outline-success" href="{{ route('teacher.schedules.markShow', $schedule->id) }}">Hoàn Thành</a>
                                        </div>
                                        @endif()
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @empty
                <div class="pt-3 d-flex justify-content-center">
                    <h4>Empty Data</h4>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection @section('script')
@endsection