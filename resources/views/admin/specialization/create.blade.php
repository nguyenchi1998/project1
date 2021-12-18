@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Sửa Đổi Quản Trị Viên</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.managers.index') }}">Danh Sách Quản Trị Viên</a></li>
        <li class="breadcrumb-item active">Sửa Đổi Quản Trị Viên</li>
    </ol>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                {{ Form::open(['url' =>route('admin.specializations.store') , 'method' => 'POST']) }}
                <div class="form-group">
                    <label for="name">Chuyên Ngành</label>
                    {{ Form::input('text', 'name', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Chuyên ngành']) }}
                </div>
                <div class="form-group">
                    <label for="min_creddit">Số Tín Chỉ Tối Thiểu</label>
                    {{ Form::input('number', 'min_credit', null, ['class' => 'form-control', 'id' => 'min_creddit', 'placeholder' => 'Số tín chỉ tối thiểu', 'min' => 0]) }}
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('department', 'Viện') }}
                {{ Form::select('department_id', $departments, null, ['class' => 'form-control', 'id' => 'department', 'placeholder' => 'Tất Cả Viện']) }}
            </div>
            <div class="mt-3">
                {{ Form::submit('Xác Nhận', ['class'=> 'btn btn-outline-success mr-2']) }}
                <a href="{{ route('admin.specializations.index') }}" class="btn btn-outline-dark">Huỷ Bỏ</a>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('script') @endsection