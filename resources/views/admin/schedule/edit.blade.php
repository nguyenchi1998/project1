@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Sửa Đổi Tín Chỉ</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.home') }}">Bảng Điều Khiển</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.schedules.index') }}">Danh Sách Lớp Tín Chỉ</a>
        </li>
        <li class="breadcrumb-item active">Sửa Đổi Tín Chỉ</li>
    </ol>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                {{ Form::open([
                        'url' => route('admin.schedules.update', $schedule->id),
                        'method' => 'POST',
                    ]) }}
                @method('PUT')
                <div class="row">
                    <div class="form-group col-lg-6">
                        {{ Form::label('name', 'Lớp Tín Chỉ') }}
                        {{ Form::input('text', 'code', $schedule->code, [
                                'readonly' => true,
                                'class' => 'form-control',
                                'id' => 'name',
                                'placeholder' => 'Lớp Tín Chỉ',
                            ]) }}
                    </div>
                    <div class="form-group col-lg-6">
                        {{ Form::label('teacher_id', 'Giảng Viên') }}
                        {{ Form::select('teacher_id', $teachers, $schedule->teacher_id ?? null, [
                                'class' => 'form-control ',
                                'placeholder' => 'Chọn Giảng Viên',
                                'disabled' => (bool) $schedule->teacher_id,
                            ]) }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 form-group">
                        {{ Form::label('start_time', 'Thời Gian Bắt Đầu') }}
                        {{ Form::date('start_time', $schedule->start_time, [
                                'class' => 'form-control ',
                                'disabled' => (bool) $schedule->start_time,
                            ]) }}
                    </div>
                    <div class="col-lg-6 form-group">
                        {{ Form::label('end_time', 'Thời Gian Kết Thúc') }}
                        {{ Form::date('end_time', $schedule->end_time, [
                                'class' => 'form-control ',
                                'disabled' => (bool) $schedule->end_time,
                            ]) }}
                    </div>
                </div>
                <div class="mt-3">
                    {{ Form::submit('Xác Nhận', [
                            'class' => 'btn btn-outline-success mr-2',
                        ]) }}
                    <a href="{{ route('admin.schedules.index') }}" class="btn btn-outline-dark">Huỷ Bỏ</a>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection