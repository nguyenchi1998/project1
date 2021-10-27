@extends('layouts.manager')
@section('title') Quản Lý Niên Khoá @endsection
@section('breadcrumb')
    <div class="page-header">
        <h3 class="page-title">Sửa Đổi</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.grades.index') }}">Danh Sách Niên Khoá</a>
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
                    {{ Form::open(['url' =>route('admin.grades.update', $grade->id) , 'method' => 'POST']) }}
                    <div class="form-group">
                        <label for="name">Niên Khoá</label>
                        {{ Form::input('text', 'name', $grade->name, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Enter tên niên khoá']) }}
                    </div>
                    {{Form::submit('Xác Nhận', ['class'=> 'btn btn-gradient-primary mr-2']) }}
                    <a href="{{ route('admin.grades.index') }}" class="btn btn-light">Huỷ Bỏ</a>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script') @endsection