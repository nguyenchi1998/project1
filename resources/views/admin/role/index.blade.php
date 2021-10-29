@extends('layouts.manager')
@section('title')
    Quản Lý Quyền
@endsection
@section('breadcrumb')
    <div class="page-header">
        <h3 class="page-title">Danh Sách Quyền</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
                <li class="breadcrumb-item active" aria-current="page">Danh Sách Quyền</li>
            </ol>
        </nav>
    </div>
@endsection
@section('main')
    <div class="row">
        <div class="col-lg-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="sticky-top bg-gradient-primary ">
                            <tr>
                                <th class="text text-white">Quyền</th>
                                <th class="text text-white">Hành Động</th>
                                <th class="text text-white"></th>
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
                                    <td width="100">
                                        <div class="d-flex justify-content-between">
                                            <div class="mr-3">
                                                <a href="{{ route('admin.roles.edit', $role->id) }}"
                                                   class="btn btn-sm btn-outline-warning" data-toggle="tooltip"
                                                   data-placement="top"
                                                   title="Sửa Thông Tin"><i class="mdi mdi-grease-pencil"></i></a>
                                            </div>
                                        </div>
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