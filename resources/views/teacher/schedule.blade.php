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
                    @forelse($schedules as $key => $schedule)
                        <div class="text text-uppercase">
                            <h4>{{ getNameSchedule($key) }}</h4>
                        </div>
                        <div class="table-responsive mb-3">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Class</th>
                                    <th>Start time</th>
                                    <th>Students</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($schedule as $detail)
                                    <tr>
                                        <td>
                                            {{ $detail->subject->name }}
                                        </td>
                                        <td style="width: 150px">
                                            {{ $detail->start_time }}
                                        </td>
                                        <td style="width: 150px">
                                            {{ count($detail->scheduleDetails) }}
                                        </td>
                                        <td style="width: 150px">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div class="mr-1">
                                                    <a class="btn btn-sm btn-outline-info"
                                                       href="{{ route('teacher.schedules.markShow', $detail->id) }}"
                                                       data-toggle="tooltip" data-placement="top" title="Thông tin">
                                                        <i class="fa fa-calendar-times"></i>
                                                    </a>
                                                </div>
                                                @if($detail->status == config('config.status.schedule.inprogress'))
                                                    <a class="btn btn-sm btn-outline-success"
                                                       href="{{ route('teacher.schedules.attendanceShow', $detail->id) }}"
                                                       data-toggle="tooltip" data-placement="top" title="Điểm danh">
                                                        <i class="fa fa-users"></i>
                                                    </a>
                                                @elseif($detail->status == config('config.status.schedule.marking'))
                                                    <a class="btn btn-sm btn-primary"
                                                       href="{{ route('teacher.schedules.markShow', $detail->id) }}">Mark</a>
                                                    @if(checkFinishMark($detail->scheduleDetails->toArray()))
                                                        <div class="ml-1">
                                                            <a class="btn btn-sm btn-outline-success"
                                                               href="{{ route('teacher.schedules.markShow', $detail->id) }}">Finish</a>
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