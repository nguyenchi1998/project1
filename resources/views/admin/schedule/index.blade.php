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
                <div class="d-flex mb-4 justify-content-between">
                    <div class="w-25">
                        <form action="">
                            {{ Form::select('status', $states, $status , ['class' => 'form-control form-control-sm', 'placeholder' => 'Chọn Trạng Thái', 'onchange' => 'this.form.submit()']) }}
                        </form>
                    </div>
                    @if($hasScheduleDetails)
                    <a class="btn d-flex align-items-center btn-sm btn-outline-success" href="{{ route('admin.schedules.create') }}">Tạo Mới</a>
                    @endif
                </div>
                <div class="table-responsive table-scroll">
                    <h4>Lớp Tín Chỉ Theo Lớp</h4>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Lớp Tín Chỉ</th>
                                <th>Lớp Học</th>
                                <th>Số Sinh Viên</th>
                                <th>Thời Gian Bắt Đầu</th>
                                <th>Thời Gian Kết Thúc</th>
                                <th>Giảng Viên</th>
                                <th>Trạng Thái</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($classSchedules as $schedule)
                            <tr>
                                <td>
                                    {{ $schedule->name }}
                                </td>
                                <td>
                                    {{ $schedule->class->name }}
                                </td>
                                <td class="text-center">
                                    {{ count($schedule->scheduleDetails) ? count($schedule->scheduleDetails) : count($schedule->class->students)}}
                                </td>
                                <td>
                                    {{ Form::date('start_time', $schedule->start_time, ['class' => 'form-control form-control-sm', 'disabled' => (boolean)$schedule->status]) }}
                                </td>
                                <td>
                                    {{ Form::date('end_time', $schedule->start_time, ['class' => 'form-control form-control-sm', 'disabled' => (boolean)$schedule->status]) }}
                                </td>
                                <td>
                                    <form action="{{ route('admin.schedules.teacher', $schedule->id) }}" method="post">
                                        @csrf
                                        {{ Form::select('teacher_id', $schedule->subject->teachers->pluck('name', 'id')->toArray(), $schedule->teacher->id ?? null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Chọn Giảng Viên', 'onchange' => 'this,form.submit()', 'disabled' => (boolean)$schedule->status])}}
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route('admin.schedules.start', $schedule->id) }}" method="POST">
                                        @csrf
                                        {{ Form::select('status', $states, $schedule->status, ['class' => 'form-control form-control-sm', 'onchange' => 'this.form.submit()']) }}
                                    </form>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-between">
                                        <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn mr-1 btn-sm btn-outline-danger" href="#" data-toggle="tooltip" data-placement="top" title="Xóa lớp tín chỉ">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
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

                <div class="mt-4 table-responsive table-scroll">
                    <h4>Lớp Tín Chỉ Tự Do</h4>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Lớp Tín Chỉ</th>
                                <th>Số Sinh Viên</th>
                                <th>Thời Gian Bắt Đầu</th>
                                <th>Thời Gian Kết Thúc</th>
                                <th>Giảng Viên</th>
                                <th>Trạng Thái</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($freeSchedules as $schedule)
                            <tr>
                                <td>
                                    {{ $schedule->name }}
                                </td>
                                <td class="text-center">
                                    {{ count($schedule->scheduleDetails) }}
                                </td>
                                <td>
                                    {{ Form::date('start_time', $schedule->start_time, ['class' => 'form-control form-control-sm', 'disabled' => (boolean)$schedule->status]) }}
                                </td>
                                <td>
                                    {{ Form::date('end_time', $schedule->start_time, ['class' => 'form-control form-control-sm', 'disabled' => (boolean)$schedule->status]) }}
                                </td>
                                <td>
                                    <form action="{{ route('admin.schedules.teacher', $schedule->id) }}" method="post">
                                        @csrf
                                        {{ Form::select('teacher_id', $schedule->subject->teachers->pluck('name', 'id')->toArray(), $schedule->teacher->id ?? null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Chọn Giảng Viên', 'onchange' => 'this,form.submit()', 'disabled' => (boolean)$schedule->status])}}
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route('admin.schedules.start', $schedule->id) }}" method="POST">
                                        @csrf
                                        {{ Form::select('status', $states, $schedule->status, ['class' => 'form-control form-control-sm', 'onchange' => 'this.form.submit()']) }}
                                    </form>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-between">
                                        <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn mr-1 btn-sm btn-outline-danger" href="#" data-toggle="tooltip" data-placement="top" title="Xóa lớp tín chỉ">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <div class="pt-2 d-flex justify-content-center">
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
@endsection @section('script') @endsection