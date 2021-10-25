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
<div class="row page-min-height">
    <div class="col-lg-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex mb-4 justify-content-between">
                    <div class="w-15">
                        <form action="{{route('admin.classes.index')}}">
                            <div class="d-flex justify-content-between">
                                <input type="search" name="keyword" value="{{ $keyword }}" class="form-control mr-2" placeholder="Từ Khoá">
                                <select class="form-control" name="filter_specializaiton">
                                    <option value="all" @if(!$filterSpecialization || $filterSpecialization=='all' ) selected="selected" @endif>
                                        Tất Cả Các Chuyên Ngành
                                    </option>
                                    @foreach($specializations as $specialization)
                                    <option value="{{ $specialization->id }}" @if($filterSpecialization && $filterSpecialization==$specialization->id) selected="selected" @endif>{{
                                        $specialization->name }}</option>
                                    @endforeach
                                </select>
                                <button class="ml-2 btn btn-success" type="submit">
                                    <i class="mdi mdi-grease-pencil"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <a class="btn btn-primary" href="{{ route('admin.classes.create') }}">Tạo mới</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
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
                                    {{ $class->specialization->name }}
                                </td>
                                <td style="width: 100px">
                                    <div class="d-flex justify-content-between">
                                        <div class="mr-3">
                                            <a href="{{ route('admin.classes.show', $class->id) }}" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Danh Sách Sinh Viên"><i class="mdi mdi-account-multiple"></i></a>
                                        </div>
                                        <div class="mr-3">
                                            <a href="{{ route('admin.classes.edit', $class->id) }}" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Sửa Thông Tin"><i class="mdi mdi-grease-pencil"></i></a>
                                        </div>
                                        <div>
                                            <form action="">
                                                <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Xoá Thông Tin"><i class="mdi mdi-delete"></i>
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