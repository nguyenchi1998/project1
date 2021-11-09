@extends('layouts.manager')

@section('breadcrumb')
    <div class="col-sm-6">
        <h1 class="m-0">Quản Lý Niên Khoá</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
            <li class="breadcrumb-item">Danh Sách Niên Khoá</li>
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
                            <form action="{{ route('admin.grades.index') }}">
                                <div class="d-flex justify-content-between">
                                    <input type="search" name="keyword" value="{{ $keyword }}"
                                           class="form-control form-control-sm mr-2" placeholder="Từ Khoá">
                                    <button class="ml-2 btn-sm btn btn-outline-info" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <a class="btn btn-sm align-items-center d-flex btn-outline-success"
                           href="{{ route('admin.grades.create') }}">Tạo mới</a>
                    </div>
                    <div class="table-responsive table-scroll">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Niên Khoá</th>
                                <th>Tổng số sinh viên</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($grades as $grade)
                                <tr>
                                    <td>{{ $grade->name }}</td>
                                    <td>{{ count($grade->students) }}</td>
                                    <td width="100">
                                        <div class="d-flex justify-content-between">
                                            <div class="mr-2">
                                                <a href="{{ route('admin.grades.edit', $grade->id) }}"
                                                   class="btn btn-sm btn-outline-warning" data-toggle="tooltip"
                                                   data-placement="top" title="Sửa"><i class="fa fa-edit"></i></a>
                                            </div>
                                            <div>
                                                <form action="">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            data-toggle="tooltip" data-placement="top" title="Xoá">
                                                        <i class="fa fa-trash"></i></button>
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