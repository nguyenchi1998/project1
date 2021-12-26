@extends('layouts.teacher')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Quản Lý Lịch Giảng Dạy</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('teacher.home') }}">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item" href="{{ route('teacher.schedules.index') }}">Danh Sách Lịch Giảng Dạy</li>
        <li class="breadcrumb-item active" aria-current="page">
            Điểm Danh
        </li>
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
                        <div class="col-6">
                            <div class="form-group">
                                Mã Lớp: {{ $schedule->code }}
                            </div>
                            <div class="form-group">
                                Môn Học: {{ $schedule->subject->name }}
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                Số Sinh Viên: {{ count($scheduleDetails) }}
                            </div>
                            <div class="form-group">
                                Ngày: {{ now()->format('d/m/yy') }}
                            </div>
                        </div>
                    </div>
                </div>
                {{ Form::open(['url' =>route('teacher.schedules.attendance', $schedule->id) , 'method' => 'POST', 'class' => "forms-sample" ]) }}
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Sinh Viên</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($scheduleDetails as $student)
                            <tr>
                                <td>
                                    {{ $student->student->name }}
                                </td>
                                <td width="50">
                                    <div class="text-center">
                                        {{ Form::checkbox('studentId[]', $student->id, false, ['class' => 'form-control'])  }}
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 float-right">
                    {{Form::submit('Xác Nhận', ['class'=> 'btn btn-outline-success mr-2']) }}
                    <a href="{{ route('teacher.schedules.index') }}" class="btn btn-outline-dark">Huỷ Bỏ</a>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection @section('script')
@endsection