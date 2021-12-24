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
                        <form action="" class="form-inline">
                            {{ Form::select('status', $states, $status , ['class' => 'form-control', 'placeholder' => 'Tất Cả Trạng Thái']) }}
                            {{ Form::select('class-type', [0 => 'Lớp Học', 1 => 'Tự Do'], $classType, ['class' => 'ml-2 form-control mr-2', 'placeholder' => 'Tất Cả Thể Loại']) }}
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    </div>
                    @if($hasScheduleDetails)
                    <a class="btn d-flex align-items-center btn-outline-success" href="{{ route('admin.schedules.create') }}">Tạo Mới</a>
                    @endif
                </div>
                <div class="table-responsive table-scroll">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Lớp Tín Chỉ</th>
                                <th>Kỳ Học</th>
                                <th>Số Tín Chỉ</th>
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
                                    {{ $schedule->name ?? ('Lớp Tín Chỉ Môn ' . $schedule->subject->name) }}
                                    @if(!$schedule->class_id) <span class="badge bg-primary">Tự Do</span>@endif
                                </td>
                                <td>
                                    {{ $schedule->semester }}
                                </td>
                                <td>
                                    {{ $schedule->credit ?? $schedule->subject->credit }}
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
                                    <form action="{{ route('admin.schedules.start', $schedule->id) }}" method="POST">
                                        @csrf
                                        {{ Form::select('status', $states, $schedule->status, ['class' => 'form-control', 'onchange' => 'this.form.submit()', 'disabled' => $schedule->status]) }}
                                    </form>
                                </td>
                                <td style="width: 100px;">
                                    <div class="d-flex justify-content-between">
                                        <div class="mr-2">
                                            <form action="{{ route('admin.schedules.edit', $schedule->id) }}">
                                                <button class="btn btn-outline-warning" @if ($schedule->status) disabled @endif>Sửa</button>
                                            </form>
                                        </div>
                                        <div>
                                            <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn mr-1 btn-outline-danger" type="submit">
                                                    Xóa
                                                </button>
                                            </form>
                                        </div>
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
                    {{ $schedules->appends(['status' => $status, 'class-type' => $classType])->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection @section('script') @endsection