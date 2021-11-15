@extends('layouts.manager')

@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Quản Lý Giảng Viên</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.teachers.index') }}">Danh Sách Giảng Viên</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Sửa Đổi</li>
    </ol>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                {{ Form::open(['url' => route('admin.teachers.update', $teacher->id) , 'method' => 'POST', 'files' => true]) }}
                @method('PUT')
                {{ Form::text('id',$teacher->id, ['hidden'=>true]) }}

                <div class="form-group">
                    <label for="name">Họ Tên</label>
                    {{ Form::input('text', 'name', $teacher->name, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Họ tên']) }}
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
                                {{ Form::radio('gender', config('config.gender.male'),  $teacher->gender == config('config.gender.male'),  ['class'=>'form-check-input']) }}
                                {{ 'Nam' }}
                                <i class="input-helper"></i>
                            </label>
                        </div>
                        <div class="ml-3 form-check form-check-info">
                            <label class="form-check-label">
                                {{ Form::radio('gender', config('config.gender.female'), $teacher->gender == config('config.gender.female'),  ['class'=>'form-check-input']) }}
                                {{ 'Nữ' }}
                                <i class="input-helper"></i>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    {{ Form::input('email', 'email', $teacher->email, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Email']) }}
                </div>
                <div class="form-group">
                    <label for="phone">Số Điện Thoại</label>
                    {{ Form::input('text', 'phone', $teacher->phone, ['class' => 'form-control', 'id' => 'name',  'placeholder' => 'Số điện thoại']) }}
                </div>
                <div class="form-group">
                    <label for="birthday">Ngày Sinh</label>
                    {{ Form::input('date', 'birthday', $teacher->birthday, ['class' => 'form-control', 'id' => 'credit']) }}
                </div>
                <div class="form-group">
                    <label for="address">Địa chỉ</label>
                    {{ Form::input('text', 'address', $teacher->address, ['class' => 'form-control', 'id' => 'credit', 'placeholder' => 'Đại chỉ liên hệ']) }}
                </div>
                <div class="form-group">
                    <label for="experience">Kinh Nghiệm</label>
                    {{ Form::textarea('experience', null, ['class' => ' form-control', 'id' => 'experience', 'placeholder' => 'Miêu tả về kinh nghiệm công viện']) }}
                </div>
                {{Form::submit('Xác Nhận', ['class'=> 'btn btn-outline-success mr-2']) }}
                <a href="{{ route('admin.teachers.index') }}" class="btn btn-outline-dark">Huỷ Bỏ</a>
                {{ Form::close() }}
            </div>
        </div>
        @endsection
        @section('script') @endsection