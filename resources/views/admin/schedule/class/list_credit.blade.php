@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Danh Sách Tín Chỉ</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.schedules.classes.index') }}">Danh Sách Lớp</a></li>
        <li class="breadcrumb-item active">Danh Sách Tín Chỉ</li>
    </ol>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-lg-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex mb-3 justify-content-between">
                    <div class="col-lg-12 row">
                        <div class="col-lg-6">
                            <div class="d-flex align-items-center h-100">
                                <strong class="mr-1">Lớp: </strong>{{ $class->name }}
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="d-flex align-items-center">
                                <strong class="mr-1">Kỳ Hiện Tại: </strong>
                                <form action="">
                                    {{ Form::select('semester-filter', $semesters, $semesterFilter, ['class' => 'form-control mr-2', 'placeholder' => 'Tất Cả Kỳ Học', 'onchange' => 'this.form.submit()']) }}
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive table-scroll">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Môn Học</th>
                                <th>Số Tín Chỉ</th>
                                <th>Kỳ Học</th>
                                <th>Trạng Thái</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($schedules as $schedule)
                            <tr @if($schedule->status == config('schedule.status.done')) class="table-secondary" @endif>
                                <td>
                                    {{ $schedule->specializationSubject->subject->name }}
                                </td>
                                <td>
                                    {{ $schedule->credit ?? $schedule->specializationSubject->subject->credit }}
                                </td>
                                <td>
                                    {{ $schedule->specializationSubject->semester }}
                                </td>
                                <td style="width: 150px">
                                    @switch($schedule->status)
                                    @case(config('schedule.status.new'))
                                    Mới
                                    @break
                                    @case(config('schedule.status.inprogress'))
                                    Đang Học
                                    @break
                                    @case(config('schedule.status.finish'))
                                    Kết Thúc
                                    @break
                                    @case(config('schedule.status.marking'))
                                    Đang Vào Điểm
                                    @break
                                    @default
                                    Hoàn Thành
                                    @endswitch
                                </td>
                                <td style="width: 120px">
                                    @if($schedule->status == config('schedule.status.done') || $schedule->status == config('schedule.status.marking'))
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('admin.schedules.classes.registerScheduleShow', $schedule->class_id) }}" class="btn btn-outline-success">
                                            Xem Điểm
                                        </a>
                                    </div>
                                    @endif
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
                    {{ $schedules->appends(['specialization-filter' => $specializationFilter, 'semester-filter' => $semesterFilter, 'keyword' => $keyword])->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection