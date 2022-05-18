@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Tạo Mới Quản Trị Viên</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.managers.index') }}">Danh Sách Quản Trị Viên</a></li>
        <li class="breadcrumb-item active">Tạo Mới Quản Trị Viên</li>
    </ol>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                {{ Form::open(['url' => route('admin.managers.store'), 'method' => 'POST', 'files' => true]) }}
                <div class="form-group">
                    <label for="email">Email</label>
                    {{ Form::input('email', 'email', null, ['class' => 'form-control', 'id' => 'email', 'placeholder' => 'Email']) }}
                </div>
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label for="name">Name</label>
                        {{ Form::input('text', 'name', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Name']) }}
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="avatar">Avatar</label>
                        {{ Form::file('avatar', ['class' =>'form-control', 'id' => 'avatar']) }}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label for="phone">Phone</label>
                        {{ Form::input('text', 'phone', null, ['class' => 'form-control', 'id' => 'phone', 'placeholder' => 'Phone']) }}
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="birthday">Birthday</label>
                        {{ Form::input('date', 'birthday', null, ['class' => 'form-control', 'id' => 'birthday']) }}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6">
                        {{ Form::label('gender', 'Gender') }}
                        <div class="form-inline">
                            <div class="form-check form-check-info">
                                <label class="form-check-label">
                                    {{ Form::radio('gender', config('config.gender.male'), false ,  ['class'=>'form-check-input']) }}
                                    {{ 'Nam' }}
                                    <i class="input-helper"></i>
                                </label>
                            </div>
                            <div class="ml-3 form-check form-check-info">
                                <label class="form-check-label">
                                    {{ Form::radio('gender', config('config.gender.female'), false ,  ['class'=>'form-check-input']) }}
                                    {{ 'Nữ' }}
                                    <i class="input-helper"></i>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="address">Address</label>
                        {{ Form::input('text', 'address', null, ['class' => 'form-control', 'id' => 'credit', 'placeholder' => 'Address']) }}
                    </div>
                </div>
                <div class="mt-3">
                    {{Form::submit('Submit', ['class'=> 'btn btn-outline-success mr-2']) }}
                    <a href="{{ route('admin.managers.index') }}" class="btn btn-outline-dark">Cancel</a>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script') @endsection