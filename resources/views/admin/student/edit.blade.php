@extends('layouts.manager')
@section('title') Quản Lý Giảng Viên @endsection
@section('breadcrumb')
    <div class="page-header">
        <h3 class="page-title">Sửa Đổi</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.subjects.index') }}">Danh Sách Giảng Viên</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Sửa Đổi</li>
            </ol>
        </nav>
    </div>
@endsection
@section('main')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['url' => route('admin.teachers.update', $student->id) , 'method' => 'POST', 'files' => true]) }}
                    @method('PUT')
                    {{ Form::text('id',$student->id, ['hidden'=>true]) }}
                    <div class="form-group">
                        <label for="name">Họ Tên</label>
                        {{ Form::input('text', 'name', $student->name, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Họ tên']) }}
                    </div>
                    <div class="form-group">
                        <label for="name">Ảnh Đại Diện</label>
                        {{ Form::file('avatar', ['class' =>'form-control']) }}
                    </div>
                    <div class="form-group ">
                        {{ Form::label('gender', 'Giới Tính')}}
                        <div class="form-inline">
                            <div class="form-check form-check-info">
                                <label class="form-check-label">
                                    {{ Form::radio('gender', 1,  $student->gender == 1,  ['class'=>'form-check-input']) }}
                                    {{ 'Nam' }}
                                    <i class="input-helper"></i>
                                </label>
                            </div>
                            <div class="ml-3 form-check form-check-info">
                                <label class="form-check-label">
                                    {{ Form::radio('gender', 0, $student->gender == 0,  ['class'=>'form-check-input']) }}
                                    {{ 'Nữ' }}
                                    <i class="input-helper"></i>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        {{ Form::input('email', 'email', $student->email, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Email']) }}
                    </div>
                    <div class="form-group">
                        <label for="phone">Số Điện Thoại</label>
                        {{ Form::input('text', 'phone', $student->phone, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Số điện thoại']) }}
                    </div>
                    <div class="form-group">
                        <label for="birthday">Ngày Sinh</label>
                        {{ Form::input('date', 'birthday', $student->birthday, ['class' => 'form-control', 'id' => 'credit']) }}
                    </div>
                    <div class="form-group">
                        <label for="address">Địa chỉ</label>
                        {{ Form::input('text', 'address', $student->address, ['class' => 'form-control', 'id' => 'credit', 'placeholder' => 'Đại chỉ liên hệ']) }}
                    </div>
                    {{Form::submit('Xác Nhận', ['class'=> 'btn btn-gradient-primary mr-2'])}}
                    <a href="{{ route('admin.students.index') }}" class="btn btn-light">Huỷ Bỏ</a>
                    {{ Form::close()}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script') @endsection