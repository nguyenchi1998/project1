@extends('layouts.manager')
@section('breadcrumb')
    <div class="col-sm-6">
        <h1 class="m-0">Quản Lý Vai Trò</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
            <li class="breadcrumb-item active">Danh Sách Vai Trò</li>
        </ol>
    </div>
@endsection
@section('main')
    <div class="row">
        <div class="col-lg-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive table-scroll">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Quyền</th>
                                <th>Hành Động</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>
                                        {{ ucwords(str_replace('-', ' ', $role->display_name)) }}
                                    </td>
                                    <td>
                                        {{ count($role->permissions) }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.roles.edit', $role->id) }}"
                                           class="btn btn-sm btn-outline-warning" data-toggle="tooltip"
                                           data-placement="top" title="Sửa"><i class="fa fa-edit"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection