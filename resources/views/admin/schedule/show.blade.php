@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Điểm lớp tín chỉ</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.schedules.index') }}">Danh Sách Lớp Tín Chỉ</a></li>
        <li class="breadcrumb-item active">Điểm lớp tín chỉ</li>
    </ol>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-lg-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="mt-6">
                    <div class="form-row">
                        <div class="col-4">
                            <div class="form-group">
                                <strong>Mã Lớp:</strong> {{ $schedule->code }}
                            </div>
                            <div class="form-group">
                                <strong> Môn Học:</strong> {{ $schedule->subject->name }}
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <strong>Số Sinh Viên:</strong> {{ count($schedule->scheduleDetails) }}
                            </div>
                            <div class="form-group">
                                <strong>Thời Gian:</strong> {{ formatDateShow($schedule->start_time) . ' - ' . formatDateShow($schedule->end_time)  }}
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="float-right">
                                {{ Form::open(['url' => route('admin.schedules.export', $schedule->id), 'method' => 'post']) }}
                                <button class="btn btn-outline-success">Xuất Excel</button>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive mb-3 table-scroll">
                    <table class="table table-bordered table-hover" id="mark">
                        <thead>
                            <tr>
                                <th>Mã</th>
                                <th>Sinh Viên</th>
                                <th>Điểm Chuyên Cần</th>
                                <th>Điểm Giữa Kỳ</th>
                                <th>Điểm Cuối Kỳ</th>
                                <th>Điểm Kết Quả</th>
                                <th>Kết Quả</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schedule->scheduleDetails as $student)
                            <tr>
                                <td>
                                    {{ $student->student->code }}
                                </td>
                                <td>
                                    {{ $student->student->name }}
                                </td>
                                <td>
                                    {{ $student->activity_mark }}
                                </td>
                                <td>
                                    {{ $student->middle_mark }}
                                </td>
                                <td>
                                    {{ $student->final_mark }}
                                </td>
                                <td>
                                    {{ result_mark($student->activity_mark, $student->middle_mark, $student->final_mark) }}
                                </td>
                                <td style="width: 200px">
                                    @switch(result_schedule_detail($student->activity_mark, $student->middle_mark, $student->final_mark))
                                    @case(config('schedule.detail.status.result.pass'))
                                    {{ 'Qua Môn' }}
                                    @break
                                    @case(config('schedule.detail.status.result.retest'))
                                    {{ 'Thi Lại' }}
                                    @break
                                    @default
                                    {{ 'Học Lại' }}
                                    @endswitch
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection