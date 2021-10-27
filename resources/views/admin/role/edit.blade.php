@extends('layouts.manager')
@section('title') Manager Roles @endsection
@section('breadcrumb')
    <div class="page-header">
        <h3 class="page-title">Sửa Đổi</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.specializations.index') }}">Danh Sách Quyền</a>
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
                    {{ Form::open(['url' => route('admin.roles.update', $role->id) , 'method' => 'POST']) }}
                    @method('PUT')
                    {{ Form::text('id', $role->id, ['hidden'=>true]) }}
                    <div class="form-group">
                        Quyền: {{ ucwords(str_replace('-', ' ', $role->display_name)) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('permission', 'Hành Động') }}
                        <div class="row">
                            @foreach($permissions as $key => $permission)
                                <div class="col">
                                    <div class="form-check form-check-info" style="min-width: 200px">
                                        <label class="form-check-label">
                                            {{ Form::checkbox('permissions[]', $permission->id, in_array($permission->id, $role->permissions->pluck('id')->toArray()), ['class'=>'form-check-input']) }}
                                            {{ ucwords($permission->display_name) }}
                                            <i class="input-helper"></i>
                                        </label>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                    {{Form::submit('Xác Nhận', ['class'=> 'btn btn-gradient-primary mr-2']) }}
                    <a href="{{ route('admin.classes.index') }}" class="btn btn-light">Huỷ Bỏ</a>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script') @endsection