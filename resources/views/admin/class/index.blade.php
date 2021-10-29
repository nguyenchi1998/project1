@extends('layouts.manager')
@section('title') Quản Lý Lớp Học
@endsection
@section('breadcrumb')
    <div class="page-header">
        <h3 class="page-title">Danh Sách Lớp Học</h3>
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
        <div class="col-lg-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-4 justify-content-between">
                        <div class="">
                            <form action="{{ route('admin.classes.index') }}">
                                <div class="d-flex justify-content-between">
                                    <input type="search" name="keyword" value="{{ $keyword }}"
                                           class="form-control form-control-sm mr-2" placeholder="Từ Khoá">
                                    {{ Form::select('specializaiton-filter', $specializations, $filterSpecialization, ['class' => 'form-control form-control-sm', 'onchange' => 'this.form.submit()', 'placeholder' => 'Tất Cả Chuyên Ngành']) }}
                                    <button class="ml-2 btn btn-sm btn-outline-success" type="submit">
                                        <i class="mdi mdi-search-web"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="d-flex justify-content-around">
                            <form action="{{ route('admin.classes.next_semester') }}" method="POST">
                                @csrf()
                                <button class="btn-sm h-100 btn btn-outline-warning" type="submit">
                                    Chuyển Kỳ Mới
                                </button>
                            </form>
                            <a class="ml-2 d-flex align-items-center btn-sm btn btn-outline-success"
                               href="{{ route('admin.classes.create') }}">Tạo mới</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="sticky-top bg-gradient-primary ">
                            <tr>
                                <th class="text text-white">Lớp Học</th>
                                <th class="text text-white">Số Sinh Viên</th>
                                <th class="text text-white">Kỳ Hiện Tại</th>
                                <th class="text text-white">Chuyên Ngành</th>
                                <th class="text text-white"></th>
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
                                            <div class="mr-3">
                                                <a href="{{ route('admin.classes.show', $class->id) }}"
                                                   class="btn btn-sm btn-outline-info" data-toggle="tooltip"
                                                   data-placement="top" title="Danh Sách Sinh Viên"><i
                                                            class="mdi mdi-account-multiple"></i></a>
                                            </div>
                                            <div class="mr-3">
                                                <a href="{{ route('admin.classes.edit', $class->id) }}"
                                                   class="btn btn-sm btn-outline-warning" data-toggle="tooltip"
                                                   data-placement="top" title="Sửa Thông Tin"><i
                                                            class="mdi mdi-grease-pencil"></i></a>
                                            </div>
                                            <div>
                                                <form action="{{ route('admin.classes.destroy', $class->id) }}">
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
                        {{ $classes->appends(['filter' => $filterSpecialization, 'keyword' => $keyword])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection