@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Quản Lý Lớp Học</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item active">Danh Sách Lớp Học</li>
    </ol>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-lg-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex mb-4 justify-content-between">
                    <div class="">
                        <form action="{{ route('admin.departments.index') }}">
                            <div class="d-flex justify-content-between">
                                <input type="search" name="keyword" value="{{ $keyword }}" class="form-control form-control-sm mr-2" placeholder="Từ Khoá">
                                <button class="ml-2 btn btn-sm btn-outline-success" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <a class="btn btn-sm d-flex align-items-center btn-outline-success" href="{{ route('admin.classes.create') }}">Tạo mới</a>
                </div>
                <div class="table-responsive table-scroll">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Lớp Học</th>
                                <th>Số Sinh Viên</th>
                                <th>Kỳ Hiện Tại</th>
                                <th>Chuyên Ngành</th>
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
                                <td>
                                    {{ $class->semester }}
                                </td>
                                <td>
                                    {{ $class->specialization->name ?? '' }}
                                </td>
                                <td style="width: 100px">
                                    <div class="d-flex justify-content-between">
                                        <div class="mr-2">
                                            <a href="{{ route('admin.classes.students', $class->id) }}" class="btn btn-sm btn-outline-info" data-toggle="tooltip" data-placement="top" title="Danh Sách Sinh Viên">
                                                <i class="fa fa-users"></i>
                                            </a>
                                        </div>
                                        <div class="mr-2">
                                            <a href="{{ route('admin.classes.edit', $class->id) }}" class="btn btn-sm btn-outline-warning" data-toggle="tooltip" data-placement="top" title="Sửa">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </div>
                                        <div>
                                            <form action="{{ route('admin.classes.destroy', $class->id) }}">
                                                <button type="submit" class="btn btn-sm btn-outline-danger" data-toggle="tooltip" data-placement="top" title="Xoá"><i class="fa fa-trash"></i>
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