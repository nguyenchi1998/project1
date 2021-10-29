@extends('layouts.manager')
@section('title')
    Quản Lý Yêu Cầu
@endsection
@section('breadcrumb')
    <div class="page-header">
        <h3 class="page-title">Danh Sách Yêu Cầu</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
                <li class="breadcrumb-item active" aria-current="page">Danh Sách Yêu Cầu</li>
            </ol>
        </nav>
    </div>@endsection
@section('main')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Yêu Cầu Về Khoa</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="sticky-top bg-gradient-primary ">
                            <tr>
                                <th class="text text-white">Tiêu Đề</th>
                                <th class="text text-white">Giảng Viên</th>
                                <th class="text text-white">Thâm Niên</th>
                                <th class="text text-white">Viện Cũ</th>
                                <th class="text text-white">Viện Mới</th>
                                <th class="text text-white"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($moveDepartmenteTeachers as $teacher)
                                <tr>
                                    <td>{{ $teacher->titleRequest }}</td>
                                    <td>{{ $teacher->name }}</td>
                                    <td>{{ $teacher->seniority }} years</td>
                                    <td>
                                        {{ $teacher->department->name }}
                                        <label class="ml-2 badge badge-danger">{{ $teacher->department->manager_id == $teacher->id ? 'Manager' : '' }}</label>
                                    </td>
                                    <td>
                                        {{ $teacher->nextDepartment->name }}
                                        <label class="ml-2 badge badge-danger">{{ $teacher->nextDepartment->next_manager_id == $teacher->id ? 'Manager' : '' }}</label>
                                    </td>
                                    <td width="100">
                                        <div class="d-flex justify-content-between">
                                            <div class="mr-1">
                                                <form action="{{ route('admin.requests.departments.approve') }}"
                                                      method="post">
                                                    @csrf
                                                    {{ Form::text('teacherId', $teacher->id, ['hidden'=> true]) }}
                                                    <button class="btn btn-sm btn-outline-success">Chấp Nhận</button>
                                                </form>
                                            </div>
                                            <div>
                                                <form action="{{ route('admin.requests.departments.reject') }}"
                                                      method="post">
                                                    @csrf
                                                    {{ Form::text('teacherId', $teacher->id, ['hidden'=> true]) }}
                                                    <button class="btn btn-sm btn-outline-danger">Từ Chối</button>
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
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection