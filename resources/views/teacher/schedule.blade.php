@extends('layouts.teacher')
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
                    <div class="">
                        <form action="">
                            {{ Form::select('status', $states, $status ?? null, ['class' => 'form-control', 'placeholder' => 'Tất Cả Trạng Thái']) }}
                            <button class="ml-2 btn-sm btn btn-outline-info" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
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
                                    {{ $schedule->specializationSubject->subject->name }}
                                </td>
                                <td style="width:200px">
                                    {{ $schedule->start_time }}
                                </td>
                                <td style="width:150px">
                                    {{ count( $schedule->scheduleDetails) }}
                                </td>
                                <td style="width:150px">
                                    <form action="{{ route('teacher.schedules.status', $schedule->id) }}" method="POST">
                                        @csrf
                                        {{ Form::select('status', $states, $schedule->status, ['class' => 'form-control ', 'onchange' => 'this.form.submit()', 'disabled' => in_array($schedule->status, [config('schedule.status.new'),config('schedule.status.finish')]) ]) }}
                                    </form>
                                <td style="width: 150px">
                                    <div class="d-flex justify-content-center align-items-center">
                                        @if($schedule->status == config('schedule.status.inprogress'))
                                        <a class="btn btn-sm btn-outline-success" href="{{ route('teacher.schedules.attendanceShow', $schedule->id) }}">
                                            Điểm danh
                                        </a>
                                        @elseif($schedule->status == config('schedule.status.marking'))
                                        <a class="btn btn-sm btn-primary" href="{{ route('teacher.schedules.markShow', $schedule->id) }}">
                                            Vào Điểm
                                        </a>
                                        @if(checkFinishMark($schedule->scheduleDetails->toArray()))
                                        <div class="ml-1">
                                            <a class="btn btn-sm btn-outline-success" href="{{ route('teacher.schedules.markShow', $schedule->id) }}">
                                                Hoàn Thành
                                            </a>
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