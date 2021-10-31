@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Quản Lý Khoa Viện</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item"> <a href="{{ route('admin.departments.index') }}">Danh Sách Khoa Viện</a></li>
        <li class="breadcrumb-item active">Sửa Đổi</li>
    </ol>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                {{ Form::open(['url' =>route('admin.departments.update', $department->id) , 'method' => 'POST']) }}
                <div class="form-group">
                    <label for="name">Khoa Viện</label>
                    {{ Form::input('text', 'name', $department->name, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Enter tên khoa/viện']) }}
                </div>
                <div class="mt-2">
                    {{Form::submit('Xác Nhận', ['class'=> 'btn btn-outline-success mr-2']) }}
                    <a href="{{ route('admin.departments.index') }}" class="btn btn-outline-dark">Huỷ Bỏ</a>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script') @endsection