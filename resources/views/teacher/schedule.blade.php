@extends('layouts.teacher')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Quản Lý Lịch Giảng Dạy</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="{{ route('teacher.home') }}">Bảng Điều Khiển</a>
        </li>
        <li class="breadcrumb-item active">Danh Sách Lịch Giảng Dạy</li>
    </ol>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-lg-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex mb-4 justify-content-between">
                    <div class="">
                        <form action="{{ route('teacher.schedules.index') }}" class="form-inline">
                            <input type="search" name="keyword" value="{{ $keyword }}" class="form-control  mr-2" placeholder="Từ Khoá">
                            <select name="status-filter" class="form-control">
                                <option value="{{ config('schedule.status.new') }}" @if ($statusFilter==config('schedule.status.new')) selected @endif>
                                    {{ getNameSchedule(config('schedule.status.new')) }}
                                </option>
                                <option value="{{ config('schedule.status.inprogress') }}" @if ($statusFilter==config('schedule.status.inprogress')) selected @endif>
                                    {{ getNameSchedule(config('schedule.status.inprogress')) }}
                                </option>
                                <option value="{{ config('schedule.status.finish') }}" @if ($statusFilter==config('schedule.status.finish')) selected @endif>
                                    {{ getNameSchedule(config('schedule.status.finish')) }}
                                </option>
                                <option value="{{ config('schedule.status.marking') }}" @if ($statusFilter==config('schedule.status.marking')) selected @endif>
                                    {{ getNameSchedule(config('schedule.status.marking')) }}
                                </option>
                                <option value="{{ config('schedule.status.done') }}" @if ($statusFilter==config('schedule.status.done')) selected @endif>
                                    {{ getNameSchedule(config('schedule.status.done')) }}
                                </option>
                            </select>
                            <button class="ml-2 btn btn-outline-info" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="table-responsive mb-3">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Mã Lớp</th>
                                <th>Môn Học</th>
                                <th>Thời Gian Bắt Đầu</th>
                                <th>Thời Gian Kết Thú<code></code></th>
                                <th>Số Sinh Viên</th>
                                <th>Trạng Thái</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($schedules as $schedule)
                            <tr>
                                <td>
                                    {{ $schedule->code }}
                                </td>
                                <td>
                                    {{ $schedule->subject->name }}
                                </td>
                                <td style="width:200px">
                                    {{ formatDateShow($schedule->start_time) }}
                                </td>
                                <td style="width:200px">
                                    {{ formatDateShow($schedule->end_time) }}
                                </td>
                                <td style="width:150px">
                                    {{ count($schedule->scheduleDetails) }}
                                </td>
                                <td style="width:150px">
                                    <form action="{{ route('teacher.schedules.status', $schedule->id) }}" method="POST">
                                        @csrf
                                        {{ Form::select('status', $states, $schedule->status, [
                                                    'class' => 'form-control ',
                                                    'onchange' => 'this.form.submit()',
                                                    'disabled' => in_array($schedule->status, [config('schedule.status.new'), config('schedule.status.done')]),
                                                ]) }}
                                    </form>
                                <td style="width: 150px">
                                    <div class="d-flex justify-content-center align-items-center">
                                        @if ($schedule->status == config('schedule.status.inprogress'))
                                        <a class="btn btn-outline-success" href="{{ route('teacher.schedules.attendanceShow', $schedule->id) }}">
                                            Điểm danh
                                        </a>
                                        @elseif($schedule->status == config('schedule.status.marking'))
                                        <a class="btn btn-outline-primary" href="{{ route('teacher.schedules.markShow', $schedule->id) }}">
                                            Vào Điểm
                                        </a>
                                        @if (checkFinishMark($schedule->scheduleDetails->toArray()))
                                        <div class="ml-1">
                                            <a class="btn btn-outline-success" href="{{ route('teacher.schedules.markShow', $schedule->id) }}">
                                                Hoàn Thành
                                            </a>
                                        </div>
                                        @endif()
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <div class="pt-3 d-flex justify-content-center">
                                <h4>Empty Data</h4>
                            </div>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 d-flex justify-content-end">
                    {{ $schedules->appends([
                                'keyword' => $keyword,
                                'status-filter' => $statusFilter,
                                'keyword' => $keyword,
                            ])->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection @section('script')
@endsection