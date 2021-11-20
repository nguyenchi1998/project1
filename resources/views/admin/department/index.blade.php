@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Quản Lý Khoa Viện</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item active">Danh Sách Khoa Viện</li>
    </ol>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-lg-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex mb-3 justify-content-between">
                    <div class="">
                        <form action="{{ route('admin.departments.index') }}">
                            <div class="d-flex justify-content-between">
                                <input type="search" name="keyword" value="{{ $keyword }}" class="form-control mr-2 form-control-sm" placeholder="Từ Khoá">
                                <button class="btn-sm btn btn-outline-info" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <a class="btn btn-sm d-flex align-items-center btn-outline-success" href="{{ route('admin.departments.create') }}">Tạo mới</a>
                </div>
                <div class="table-responsive table-scroll">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Khoa Viện</th>
                                <th>Số chuyên ngành</th>
                                <th>Sô Giáo Viên</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($departments as $department)
                            <tr>
                                <td>{{ $department->name }}</td>
                                <td>{{ count($department->specializations) }}</td>
                                <td>{{ count($department->teachers) }}</td>

                                <td width="100">
                                    <div class="d-flex justify-content-between">
                                        <div class="mr-2">
                                            <a href="{{ route('admin.departments.edit', $department->id) }}" class="btn btn-sm btn-outline-warning" data-toggle="tooltip" data-placement="top" title="Sửa"><i class="fa fa-edit"></i></a>
                                        </div>
                                        <div>
                                            <form action="">
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
                <div class="mt-3 d-flex justify-content-end">
                    {{ $departments->appends(['keyword' => $keyword])->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection