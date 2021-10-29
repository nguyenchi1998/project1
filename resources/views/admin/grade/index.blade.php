@extends('layouts.manager')
@section('title')
    Quản Lý Niên Khoá
@endsection
@section('breadcrumb')
    <div class="page-header">
        <h3 class="page-title">Danh Sách Niên Khoá</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
                <li class="breadcrumb-item active" aria-current="page">Danh Sách Niên Khoá</li>
            </ol>
        </nav>
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
                                    <input type="search" name="keyword" value="{{ $keyword }}" class="form-control form-control-sm mr-2" placeholder="Từ Khoá">
                                    <button class="ml-2 btn-sm btn btn-outline-success" type="submit">
                                        <i class="mdi mdi-search-web"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <a class="btn btn-sm align-items-center d-flex btn-outline-success" href="{{ route('admin.grades.create') }}">Tạo mới</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="sticky-top bg-gradient-primary ">
                            <tr>
                                <th class="text text-white">Niên Khoá</th>
                                <th class="text text-white">Tổng số sinh viên</th>
                                <th class="text text-white"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($grades as $grade)
                                <tr>
                                    <td>{{ $grade->name }}</td>
                                    <td>{{ count($grade->students) }}</td>
                                    <td width="100">
                                        <div class="d-flex justify-content-between">
                                            <div class="mr-3">
                                                <a href="{{ route('admin.grades.edit', $grade->id) }}"
                                                   class="btn btn-sm btn-outline-warning" data-toggle="tooltip"
                                                   data-placement="top"
                                                   title="Sửa Thông Tin"><i class="mdi mdi-grease-pencil"></i></a>
                                            </div>
                                            <div>
                                                <form action="">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            data-toggle="tooltip" data-placement="top"
                                                            title="Xoá Thông Tin">
                                                        <i class="mdi mdi-delete"></i></button>
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