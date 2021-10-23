@extends('layouts.manager')
@section('title') Quản lý Lớp Học @endsection
@section('breadcrumb')
    <div class="page-header">
        <h3 class="page-title">Tạo Mới</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.subjects.index') }}">Quản lý Lớp Học</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Tạo mới</li>
            </ol>
        </nav>
    </div>
@endsection
@section('main')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['url' =>route('admin.classes.store') , 'method' => 'POST']) }}
                    <div class="form-group">
                        <label for="name">Name</label>
                        {{ Form::input('text', 'name', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Tên lớp']) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('subject', 'Sinh Viên')}}
                        @foreach($students as $key => $student)
                            <div class="form-check form-check-info">
                                <label class="form-check-label">
                                    {{ Form::checkbox('students[]', $student->id, false,  ['class'=>'form-check-input']) }}
                                    {{ $student->name }}
                                    <i class="input-helper"></i>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    {{ Form::submit('Xác Nhận', ['class'=> 'btn btn-gradient-primary mr-2']) }}
                    <a href="{{ route('admin.classes.index') }}" class="btn btn-light">Huỷ Bỏ</a>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script') @endsection