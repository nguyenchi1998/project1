@extends('layouts.manager')
@section('title') Quản Lý Môn Học @endsection
@section('breadcrumb')
    <div class="page-header">
        <h3 class="page-title">Sửa Đổi</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.subjects.index') }}">Danh Sách Môn Học</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Sửa Đổi</li>
            </ol>
        </nav>
    </div>@endsection
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
                    {{Form::submit('Xác Nhận', ['class'=> 'btn btn-gradient-primary mr-2']) }}
                    <a href="{{ route('admin.subjects.index') }}" class="btn btn-light">Huỷ Bỏ</a>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script') @endsection