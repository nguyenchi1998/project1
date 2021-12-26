@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Quản Lý Tín Chỉ</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item avtive">Danh Sách Lớp Tín Chỉ</li>
    </ol>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-lg-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex mb-3 justify-content-between">
                    <div class="">
                        <form action="{{ route('admin.schedules.index') }}" class="form-inline">
                            <input type="search" name="keyword" value="{{ $keyword }}" class="form-control  mr-2" placeholder="Từ Khoá">
                            <select name="status" class="form-control">
                                <option value="{{ config('schedule.status.new') }}" @if($status==config('schedule.status.new')) selected @endif>
                                    {{ getNameSchedule(config('schedule.status.new')) }}
                                </option>
                                <option value="{{ config('schedule.status.inprogress') }}" @if($status==config('schedule.status.inprogress')) selected @endif>
                                    {{ getNameSchedule(config('schedule.status.inprogress')) }}
                                </option>
                                <option value="{{ config('schedule.status.finish') }}" @if($status==config('schedule.status.finish')) selected @endif>
                                    {{ getNameSchedule(config('schedule.status.finish')) }}
                                </option>
                                <option value="{{ config('schedule.status.marking') }}" @if($status==config('schedule.status.marking')) selected @endif>
                                    {{ getNameSchedule(config('schedule.status.marking')) }}
                                </option>
                                <option value="{{ config('schedule.status.done') }}" @if($status==config('schedule.status.done')) selected @endif>
                                    {{ getNameSchedule(config('schedule.status.done')) }}
                                </option>
                            </select>
                            {{ Form::select('class-type', [0 => 'Lớp Học', 1 => 'Tự Do'], $classType, ['class' => 'ml-2 form-control mr-2', 'placeholder' => 'Tất Cả Thể Loại']) }}
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    </div>
                    @if($hasScheduleDetails)
                    <a class="btn d-flex align-items-center btn-outline-success" href="{{ route('admin.schedules.create') }}">Tạo Lớp</a>
                    @endif
                </div>
                <div class="table-responsive table-scroll">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Mã Lớp</th>
                                <th>Môn Học</th>
                                <th>Kỳ Học</th>
                                <th>Số Sinh Viên</th>
                                <th>Thời Gian</th>
                                <th>Giảng Viên</th>
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
                                <td>
                                    {{ $schedule->semester ?? 'Tự Do' }}
                                </td>
                                <td>
                                    {{ count($schedule->scheduleDetails) ?? count($schedule->class->students)}}
                                </td>
                                <td style="width:200px">
                                    {{ formatDateShow($schedule->start_time) . ' - ' . formatDateShow($schedule->end_time)  }}
                                </td>
                                <td>
                                    @if($schedule->teacher)
                                    {{ $schedule->teacher->name }}
                                    @else
                                    <span class="text text-danger">Chưa Chọn</span>
                                    @endif
                                </td>
                                <td style="width: 130px">
                                    <form action="{{ route('admin.schedules.update', $schedule->id) }}" method="POST">
                                        @csrf
                                        @method('put')
                                        <select name="status" class="form-control" onchange="this.form.submit()" @if($schedule->status==config('schedule.status.done') || (!$schedule->teacher_id || !$schedule->start_time)) disabled @endif>
                                            <option value="{{ config('schedule.status.new') }}" @if($schedule->status == config('schedule.status.new')) selected @endif>
                                                {{ getNameSchedule(config('schedule.status.new')) }}
                                            </option>
                                            <option value="{{ config('schedule.status.inprogress') }}" @if($schedule->status == config('schedule.status.inprogress')) selected @endif>
                                                {{ getNameSchedule(config('schedule.status.inprogress')) }}
                                            </option>
                                            <option value="{{ config('schedule.status.finish') }}" @if($schedule->status == config('schedule.status.finish')) selected @endif>
                                                {{ getNameSchedule(config('schedule.status.finish')) }}
                                            </option>
                                            <option value="{{ config('schedule.status.marking') }}" @if($schedule->status == config('schedule.status.marking')) selected @endif>
                                                {{ getNameSchedule(config('schedule.status.marking')) }}
                                            </option>
                                            <option value="{{ config('schedule.status.done') }}" @if($schedule->status == config('schedule.status.done')) selected @endif>
                                                {{ getNameSchedule(config('schedule.status.done')) }}
                                            </option>
                                        </select>
                                    </form>
                                </td>
                                <td style="width: 150px;">
                                    <div class="d-flex justify-content-between">
                                        @if ($schedule->status == config('schedule.status.done'))
                                        <div class="mr-2">
                                            <form action="{{ route('admin.schedules.show', $schedule->id) }}">
                                                <button class="btn btn-outline-info">Xem Điểm</button>
                                            </form>
                                        </div>
                                        @endif
                                        <div class="mr-2">
                                            <form action="{{ route('admin.schedules.edit', $schedule->id) }}">
                                                <button class="btn btn-outline-warning" @if ($schedule->status == config('schedule.status.done')) disabled @endif>Sửa</button>
                                            </form>
                                        </div>
                                        @if ($schedule->status != config('schedule.status.done'))
                                        <div>
                                            <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn mr-1 btn-outline-danger" @if ($schedule->status == config('schedule.status.done')) disabled @endif type="submit">
                                                    Xóa
                                                </button>
                                            </form>
                                        </div>
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
                    {{ $schedules->appends(['status' => $status, 'class-type' => $classType, 'keyword' => $keyword])->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection @section('script') @endsection