@extends('layouts.manager')
@section('title')
    Quản Lý Lớp Học
@endsection
@section('breadcrumb')
    <div class="page-header">
        <h3 class="page-title">Manager Classes</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
                <li class="breadcrumb-item active" aria-current="page">Danh Sách Lớp Học</li>
            </ol>
        </nav>
    </div>
@endsection
@section('main')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-4 justify-content-between">
                        <div class="w-15">

                        </div>
                        <a class="btn btn-primary" href="{{ route('admin.classes.create') }}">Tạo mới</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Class</th>
                                <th>Number Student</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($classes as $class)
                                <tr>
                                    <td>
                                        {{ $class->name }}
                                    </td>
                                    <td>
                                        {{ count($class->students) }}
                                    </td>
                                    <td width="100">
                                        <div class="d-flex justify-content-between">
                                            <div class="mr-3">
                                                <a href="{{ route('admin.classes.show', $class->id) }}"
                                                   class="btn btn-sm btn-info" data-toggle="tooltip"
                                                   data-placement="top"
                                                   title="Danh Sách Sinh Viên"><i class="mdi mdi-account-multiple"></i></a>
                                            </div>
                                            <div class="mr-3">
                                                <a href="{{ route('admin.classes.edit', $class->id) }}"
                                                   class="btn btn-sm btn-warning" data-toggle="tooltip"
                                                   data-placement="top"
                                                   title="Sửa Thông Tin"><i class="mdi mdi-grease-pencil"></i></a>
                                            </div>
                                            <div>
                                                <form action="">
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                            data-toggle="tooltip" data-placement="top"
                                                            title="Xoá Thông Tin"><i class="mdi mdi-delete"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <div class="pt-3 d-flex justify-content-center">
                                    <h4>Empty Data</h4>
                                </div>
                            @endforelse
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