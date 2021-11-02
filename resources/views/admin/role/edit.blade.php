@extends('layouts.manager')
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
                    <div class="table-responsive table-scroll">
                        <table class="table table-bordered" id="subjects">
                            <thead>
                            <tr>
                                <th>Quyền Hạn</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($permissions as $key => $permission)
                                <tr>
                                    <td>
                                        <div class="form-check form-check-info m-0">
                                            <label class="form-check-label">
                                                {{ ucwords($permission->display_name) }}
                                            </label>
                                        </div>
                                    </td>
                                    <td style="width: 100px" class="text-center">
                                        {{ Form::checkbox('permissions[]', $permission->id, in_array($permission->id, $role->permissions->pluck('id')->toArray())) }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{Form::submit('Xác Nhận', ['class'=> 'btn btn-outline-success mr-2']) }}
                        <a href="{{ route('admin.classes.index') }}" class="btn btn-outline-dark">Huỷ Bỏ</a>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script') @endsection