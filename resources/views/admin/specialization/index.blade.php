@extends('layouts.manager')
@section('title')
    Quản lý chuyên ngành
@endsection
@section('breadcrumb')
    <div class="page-header">
        <h3 class="page-title">Quản lý chuyên ngành</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
                <li class="breadcrumb-item active" aria-current="page">Danh sách chuyên ngành</li>
            </ol>
        </nav>
    </div>@endsection
@section('main')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-4 justify-content-between">
                        <div class="w-15"></div>
                        <a class="btn btn-primary" href="{{ route('admin.specializations.create') }}">Tạo mới</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Chuyên ngành</th>
                                <th>Số môn học</th>
                                <th>Số tín chỉ tối thiểu</th>
                                <th>Tổng số kì học</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($specializations as $specialization)
                                <tr>
                                    <td>
                                        {{ $specialization->name }}
                                    </td>
                                    <td>
                                        {{ count($specialization->subjects) }}
                                    </td>
                                    <td>
                                        {{ $specialization->min_credit }}
                                    </td>
                                    <td>
                                        {{ $specialization->total_semester }}
                                    </td>
                                    <td width="100">
                                        <div class="d-flex justify-content-between">
                                            <div class="mr-3">
                                                <a href="{{ route('admin.specializations.edit', $specialization->id) }}"
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