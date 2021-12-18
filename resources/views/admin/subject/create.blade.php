@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Tạo Mới Môn Học</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.subjects.index') }}">Danh Sách Môn Học</a></li>
        <li class="breadcrumb-item active">Tạo Mới Môn Học</li>
    </ol>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                {{ Form::open(['url' =>route('admin.subjects.store') , 'method' => 'POST']) }}
                <div class="form-group">
                    {{ Form::label('name', 'Môn Học') }}
                    {{ Form::input('text', 'name', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Môn Học']) }}
                </div>
                <div class="form-group">
                    {{ Form::label('credit', 'Số Tín Chỉ') }}
                    {{ Form::input('number', 'credit', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Số Tín Chỉ', 'min' => 1]) }}
                </div>
                <div class="form-group">
                    <label for="type">Loại Môn Học</label>
                    <select name="type" class="form-control" id="type">
                        <option value="">Chọn Loại Môn</option>
                        <option value="{{ config('subject.type.basic') }}">Đại Cương</option>
                        <option value="{{ config('subject.type.specialization') }}">Chuyên Ngành</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="type">Loại Môn Học</label>
                </div>
                <div class="form-group">
                    <label for="department">Viện</label>
                    {{ Form::select('department_id', $departments, null, ['class' => 'form-control', 'id' => 'department', 'placeholder' => 'Chọn Viện'] )}}
                </div>
                <div class="mt-3">
                    {{Form::submit('Xác Nhận', ['class'=> 'btn btn-outline-success mr-2']) }}
                    <a href="{{ route('admin.subjects.index') }}" class="btn btn-outline-dark">Huỷ Bỏ</a>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script') @endsection