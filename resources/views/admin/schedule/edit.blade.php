@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Quản Lý Tín Chỉ</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item"> <a href="{{ route('admin.schedules.index') }}">Danh Sách Lớp Tín Chỉ</a></li>
        <li class="breadcrumb-item active">Sửa Đổi</li>
    </ol>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                {{ Form::open(['url' => route('admin.classes.update', $class->id) , 'method' => 'POST']) }}
                @method('PUT')
                {{ Form::text('id',$class->id, ['hidden'=>true]) }}
                <div class="form-group">
                    <label for="name">Name</label>
                    {{ Form::input('text', 'name', $class->name, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Enter name']) }}
                </div>
                <div class="form-group">
                    {{ Form::label('subject', 'Subject') }}
                    @foreach($students as $key => $student)
                    <div class="form-check form-check-info">
                        <label class="form-check-label">
                            {{ Form::checkbox('students[]', $student->id, in_array($student->id, $class->students->pluck('id')->toArray()),  ['class'=>'form-check-input']) }}
                            {{ $student->name }}
                            <i class="input-helper"></i>
                        </label>
                    </div>
                    @endforeach
                </div>
                <div class="mt-3">
                    {{Form::submit('Xác Nhận', ['class'=> 'btn btn-outline-success mr-2']) }}
                    <a href="{{ route('admin.classes.index') }}" class="btn btn-outline-dark">Huỷ Bỏ</a>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script') @endsection