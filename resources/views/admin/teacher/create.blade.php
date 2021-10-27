@extends('layouts.manager')
@section('title') Quản Lý Giảng Viên @endsection
@section('breadcrumb')
    <div class="page-header">
        <h3 class="page-title">Tạo mới</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.subjects.index') }}">Danh Sách Giảng Viên</a>
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
                    {{ Form::open(['url' => route('admin.teachers.store') , 'method' => 'POST', 'files' => true]) }}
                    <div class="form-group">
                        <label for="name">Họ Tên</label>
                        {{ Form::input('text', 'name', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Enter name']) }}
                    </div>
                    <div class="form-group">
                        <label for="name">Ảnh Đại Diện</label>
                        {{ Form::file('avatar', ['class' =>'form-control']) }}
                    </div>
                    <div class="form-group ">
                        {{ Form::label('gender', 'Giới Tính') }}
                        <div class="form-inline">
                            <div class="form-check form-check-info">
                                <label class="form-check-label">
                                    {{ Form::radio('gender', 1, false , ['class'=>'form-check-input']) }}
                                    {{ 'Nam' }}
                                    <i class="input-helper"></i>
                                </label>
                            </div>
                            <div class="ml-3 form-check form-check-info">
                                <label class="form-check-label">
                                    {{ Form::radio('gender', 0, false , ['class'=>'form-check-input']) }}
                                    {{ 'Nữ' }}
                                    <i class="input-helper"></i>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        {{ Form::input('email', 'email', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Enter Email']) }}
                    </div>
                    <div class="form-group">
                        <label for="phone">Số Điện Thoại</label>
                        {{ Form::input('text', 'phone', null, ['class' => 'form-control', 'id' => 'name',  'placeholder' => 'Enter Phone']) }}
                    </div>
                    <div class="form-group">
                        <label for="birthday">Ngày Sinh</label>
                        {{ Form::input('date', 'birthday', null, ['class' => 'form-control', 'id' => 'credit', 'placeholder' => 'Enter Credit']) }}
                    </div>
                    <div class="form-group">
                        <label for="address">Địa chỉ</label>
                        {{ Form::input('text', 'address', null, ['class' => 'form-control', 'id' => 'credit', 'placeholder' => 'Enter Address']) }}
                    </div>
                    <div class="form-group">
                        <label for="experience">Kinh Nghiệm</label>
                        {{ Form::textarea('experience', null, ['class' => ' form-control', 'id' => 'credit', 'placeholder' => 'Enter Address']) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('department', 'Khoa Viện') }}
                        @foreach($departments as $key => $department)
                            <div class="form-check form-check-info">
                                <label class="form-check-label">
                                    {{ Form::radio('department_id', $department->id, false, ['class'=>'form-check-input']) }}
                                    {{ $department->name }}
                                    <i class="input-helper"></i>
                                </label>
                            </div>
                        @endforeach
                        {{Form::submit('Xác Nhận', ['class'=> 'btn btn-gradient-primary mr-2']) }}
                        <a href="{{ route('admin.teachers.index') }}" class="btn btn-light">Huỷ Bỏ</a>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
@endsection
@section('script') @endsection