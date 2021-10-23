@extends('layouts.manager')
@section('title')
    Quản Lý Môn Học
@endsection
@section('breadcrumb')
    <div class="page-header">
        <h3 class="page-title">Danh Sách Môn Học</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
                <li class="breadcrumb-item active" aria-current="page">Danh Sách Môn Học</li>
            </ol>
        </nav>
    </div>@endsection
@section('main')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-4 justify-content-between">
                        <div class="w-15">
                            <form action="{{route('admin.subjects.index')}}">
                                <select class="form-control" name="filter" onchange="this.form.submit()">
                                    <option value="all"
                                            @if(!$filter || $filter == 'all') selected="selected" @endif>Tất Cả Khoa
                                        Viện
                                    </option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}"
                                                @if($filter && $filter == $department->id) selected="selected" @endif>{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                        <a class="btn btn-primary" href="{{ route('admin.subjects.create') }}">Tạo mới</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Môn Học</th>
                                <th>Số Tín Chỉ</th>
                                <th>Khoa Viện</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($subjects as $subject)
                                <tr>
                                    <td>
                                        {{ $subject->name }}
                                    </td>
                                    <td>
                                        {{ $subject->credit }}
                                    </td>
                                    <td>
                                        {{ $subject->department->name }}
                                    </td>
                                    <td width="100">
                                        <div class="d-flex justify-content-between">
                                            <div class="mr-3">
                                                <a href="{{ route('admin.subjects.edit', $subject->id) }}"
                                                   class="btn btn-sm btn-warning" data-toggle="tooltip"
                                                   data-placement="top"
                                                   title="Sửa Thông Tin"><i class="mdi mdi-grease-pencil"></i></a>
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
    <script type="text/javascript">
        $(document).ready(function () {
            $('#list-subject').DataTable();
        });
    </script>
@endsection