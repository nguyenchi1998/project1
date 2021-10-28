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
        <div class="col-lg-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-4 justify-content-between">
                        <div class="w-15">
                            <form action="{{ route('admin.departments.index') }}">
                                <div class="d-flex justify-content-between">
                                    <input type="search" name="keyword" value="{{ $keyword }}"
                                           class="form-control form-control-sm mr-2" placeholder="Từ Khoá">
                                    <button class="ml-2 btn btn-sm btn-outline-success" type="submit">
                                        <i class="mdi mdi-search-web"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <a class="btn btn-sm d-flex align-items-center btn-outline-success"
                           href="{{ route('admin.specializations.create') }}">Tạo mới</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Chuyên ngành</th>
                                <th>Khoa Viện</th>
                                <th>Số môn học</th>
                                <th>Số tín chỉ tối thiểu</th>
                                <th>Tổng số kì học</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($specializations as $specialization)
                                <tr>
                                    <td>
                                        {{ $specialization->name }}
                                    </td>
                                    <td>
                                        {{ $specialization->department->name ?? '' }}
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
                                                <a href="{{ route('admin.specializations.choose_subject_show', $specialization->id) }}"
                                                   class="btn btn-sm btn-gradient-light" data-toggle="tooltip"
                                                   data-placement="top" title="Chọn Môn Giảng Dạy">
                                                    <i class="mdi mdi-book-open-page-variant"></i></a>
                                            </div>
                                            <div class="mr-3">
                                                <a href="{{ route('admin.specializations.edit', $specialization->id) }}"
                                                   class="btn btn-sm btn-outline-warning" data-toggle="tooltip"
                                                   data-placement="top" title="Sửa Thông Tin"><i
                                                            class="mdi mdi-grease-pencil"></i></a>
                                            </div>
                                            <div>
                                                <form action="">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
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
                    <div class="mt-2 d-flex justify-content-end">
                        {{ $specializations->appends(['keyword' => $keyword])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')

@endsection