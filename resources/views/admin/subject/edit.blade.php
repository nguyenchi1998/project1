@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Quản Lý Môn Học</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item"> <a href="{{ route('admin.subjects.index') }}">Danh Sách Môn Học</a></li>
        <li class="breadcrumb-item active">Sửả Đổi</a></li>
    </ol>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                {{ Form::open(['url' => route('admin.subjects.update', $subject->id) , 'method' => 'POST']) }}
                @method('PUT')
                {{ Form::text('id',$subject->id, ['hidden'=>true]) }}
                <div class="form-group">
                    <label for="name">Name</label>
                    {{ Form::input('text', 'name', $subject->name, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Môn Học']) }}
                </div>
                <div class="form-group">
                    <label for="credit">Credit</label>
                    {{ Form::input('number', 'credit', $subject->credit, ['class' => 'form-control', 'id' => 'credit', 'placeholder' => 'Sô Tín Chỉ', 'min' => 1]) }}
                </div>
                <div class="form-group">
                    {{ Form::label('department', 'Khoa Viện') }}
                    @foreach($departments as $key => $department)
                    <div class="form-check form-check-info">
                        <label class="form-check-label">
                            {{ Form::radio('department_id', $department->id, $department->id == $subject->department_id, ['class'=>'form-check-input']) }}
                            {{ $department->name }}
                            <i class="input-helper"></i>
                        </label>
                    </div>
                    @endforeach
                </div>
                <div class="form-group">
                    <div class="form-check form-check-primary">
                        <label class="form-check-label">
                            {{ Form::checkbox('basic', config('config.subject.type.basic'), $subject->type == config('config.subject.type.basic'), ['class'=>'form-check-input']) }}
                            Môn Cơ Bản
                            <i class="input-helper"></i>
                        </label>
                    </div>
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