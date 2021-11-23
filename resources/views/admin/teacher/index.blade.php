@extends('layouts.manager')
@section('breadcrumb')
    <div class="col-sm-6">
        <h1 class="m-0">Quản Lý Giảng Viên</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Bảng Điều Khiển</a></li>
            <li class="breadcrumb-item active">Danh Sách Giảng Viên</li>
        </ol>
    </div>
@endsection
@section('main')
    <div class="row">
        <div class="col-lg-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-3 justify-content-between">
                        <form action="{{ route('admin.teachers.index') }}">
                            <div class="d-flex justify-content-between">
                                <input type="search" name="keyword" value="{{ $keyword }}"
                                       class="form-control  mr-2" placeholder="Từ Khoá">
                                {{ Form::select('department-filter', $departments, $departmentFilter, ['class' => 'form-control  mr-2', 'placeholder' => 'Tất Cả Khoa Viện']) }}
                                <button class="btn-sm btn btn-outline-info" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>
                        <a class="btn btn-sm d-flex align-items-center btn-outline-success"
                           href="{{ route('admin.teachers.create') }}">Tạo Mới</a>
                    </div>
                </div>
                <div class="table-responsive table-scroll">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Giảng Viên</th>
                            <th>Email</th>
                            <th>Số Điện Thoại</th>
                            <th>Khoa Viện</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($teachers as $teacher)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="mr-4">
                                            <img class="img-circle img-avatar"
                                                 src="{{ assetStorage($teacher->avatar->path) }}" alt="avatar">
                                        </div>
                                        {{ $teacher->name }}
                                    </div>
                                </td>
                                <td>
                                    {{ $teacher->email }}
                                </td>
                                <td>
                                    {{ $teacher->phone }}
                                </td>
                                <td>
                                    {{ $teacher->department->name }} @if($teacher->department->manager_id == $teacher->id)
                                        <strong class="text text-danger ">(Manager)</strong> @endif
                                </td>
                                <td width="100">
                                    <div class="d-flex justify-content-between">
                                        <div class="mr-2">
                                            <a href="{{ route('admin.teachers.choose_subject_show', $teacher->id) }}"
                                               class="btn btn-sm btn-outline-info" data-toggle="tooltip"
                                               data-placement="top" title="Chọn Môn Giảng Dạy">
                                                <i class="fa fa-book"></i></a>
                                        </div>
                                    <!-- <div class="mr-2">
                                            <a href="{{ route('admin.teachers.change_department_show', $teacher->id) }}" class="btn btn-sm btn-outline-info" data-toggle="tooltip" data-placement="top" title="Chuyển Khoa Viện">
                                                <i class="fa fa-user-cog"></i>
                                            </a>
                                        </div> -->
                                        <div class="mr-2">
                                            <a href="{{ route('admin.teachers.edit', $teacher->id) }}"
                                               class="btn btn-sm btn-outline-warning" data-toggle="tooltip"
                                               data-placement="top" title="Sửa">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </div>
                                        <div>
                                            <form action="{{ route('admin.teachers.destroy', $teacher->id) }}">
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        data-toggle="tooltip" data-placement="top" title="Xoá">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 d-flex justify-content-end">
                    {{ $teachers->appends(['keyword' => $keyword, 'department-filter' => $departmentFilter])->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection @section('script') @endsection