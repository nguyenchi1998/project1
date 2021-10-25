@extends('layouts.manager')
@section('title')
    Quản Lý Giảng Viên
@endsection
@section('breadcrumb')
    <div class="page-header">
        <h3 class="page-title">Quản Lý Giảng Viên</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
                <li class="breadcrumb-item active" aria-current="page">Danh Sách Giảng Viên</li>
            </ol>
        </nav>
    </div>@endsection
@section('main')
    <div class="row">
        <div class="col-lg-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-4 justify-content-between">
                        <div class="w-15">
                            <form action="{{route('admin.teachers.index')}}">
                                <select class="form-control" name="filter" onchange="this.form.submit()">
                                    <option value="all"
                                            @if(!$filter || $filter == 'all') selected="selected" @endif>
                                        Tất cả các viện
                                    </option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}"
                                                @if($filter && $filter == $department->id) selected="selected" @endif>{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                        <a class="btn btn-primary" href="{{ route('admin.teachers.create') }}">Tạo mới</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Giảng Viên</th>
                                <th>Số Điện Thoại</th>
                                <th>Giới Tính</th>
                                <th>Ngày Sinh</th>
                                <th>Địa Chỉ</th>
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
                                                <img src="{{ asset($teacher->avatar->path) }}" alt="avatar">
                                            </div>
                                            {{ $teacher->name }}
                                        </div>
                                    </td>
                                    <td>
                                        {{ $teacher->phone }}
                                    </td>
                                    <td>
                                        {{ $teacher->gender ? 'Male' : 'Female' }}
                                    </td>
                                    <td>
                                        {{ $teacher->birthday }}
                                    </td>
                                    <td>
                                        {{ $teacher->address }}
                                    </td>
                                    <td>
                                        {{ $teacher->department->name }}
                                        @if($teacher->department->manager_id == $teacher->id)
                                            <strong class="text text-danger ">(Manager)</strong>
                                        @endif
                                    </td>
                                    <td width="100">
                                        <div class="d-flex justify-content-between">
                                            <div class="mr-3">
                                                <a href="{{ route('admin.teachers.edit', $teacher->id) }}"
                                                   class="btn btn-sm btn-warning" data-toggle="tooltip"
                                                   data-placement="top"
                                                   title="Sửa Thông Tin"><i class="mdi mdi-grease-pencil"></i></a>
                                            </div>
                                            <div class="mr-3">
                                                <a href="{{ route('admin.teachers.choose_subject_show', $teacher->id) }}"
                                                   class="btn btn-sm btn-gradient-light" data-toggle="tooltip"
                                                   data-placement="top"
                                                   title="Chọn Môn Giảng Dạy"><i
                                                            class="mdi mdi-book-open-page-variant"></i></a>
                                            </div>
                                            <div class="mr-3">
                                                <button disabled="disabled"
                                                        href="{{ route('admin.teachers.change_department_show', $teacher->id) }}"
                                                        class="btn btn-sm btn-info" data-toggle="tooltip"
                                                        data-placement="top"
                                                        title="Chuyển Khoa Viện"><i
                                                            class="mdi mdi-account-switch"></i>
                                                </button>
                                            </div>
                                            <div>
                                                <form action="">
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                            data-toggle="tooltip" data-placement="top"
                                                            title="Xoá Thông Tin">
                                                        <i class="mdi mdi-delete"></i>
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
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')

@endsection