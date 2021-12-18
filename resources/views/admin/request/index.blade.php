@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Danh Sách Yêu Cầu</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item active">Danh Sách Yêu Cầu</li>
    </ol>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4>Giảng Viên</h4>
                <div class="table-responsive table-scroll">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Giảng Viên</th>
                                <th>Viện Cũ</th>
                                <th>Viện Mới</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($changeDepartmentTeacherRequest as $teacher)
                            <tr>
                                <td>{{ $teacher->name }}</td>
                                <td>{{ $teacher->department->name }}</td>
                                <td>{{ $teacher->nextDepartment->name }}</td>
                                <td style="width: 210px;">
                                    <div class="d-flex justify-content-between">
                                        <div class="mr-1">
                                            <form action="{{ route('admin.requests.departmentTeacher', $teacher->id) }}" method="post">
                                                @csrf
                                                {{ Form::text('status', true, ['hidden'=> true]) }}
                                                {{ Form::text('next_department_id', $teacher->next_department_id, ['hidden'=> true]) }}
                                                <button class="btn btn-outline-success">Chấp Nhận</button>
                                            </form>
                                        </div>
                                        <div>
                                            <form action="{{ route('admin.requests.departmentTeacher', $teacher->id) }}" method="post">
                                                @csrf
                                                {{ Form::text('status', false, ['hidden'=> true]) }}
                                                <button class="btn btn-outline-danger">Từ Chối</button>
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

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4>Viện</h4>
                <div class="table-responsive table-scroll">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Viện</th>
                                <th>Trưởng Viện Cũ</th>
                                <th>Trưởng Viện Mới</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($changeDepartmentManagerRequest as $department)
                            <tr>
                                <td>{{ $department->name }}</td>
                                <td>{{ $department->manager->name }}</td>
                                <td>{{ $department->nextManager->name }}</td>
                                <td style="width: 210px;">
                                    <div class="d-flex justify-content-between">
                                        <div class="mr-1">
                                            <form action="{{ route('admin.requests.departmentManager', $department->id) }}" method="post">
                                                @csrf
                                                {{ Form::text('status', true, ['hidden'=> true]) }}
                                                {{ Form::text('next_manager_id', $department->next_manager_id, ['hidden'=> true]) }}
                                                <button class="btn btn-outline-success">Chấp Nhận</button>
                                            </form>
                                        </div>
                                        <div>
                                            <form action="{{ route('admin.requests.departmentManager', $department->id) }}" method="post">
                                                @csrf
                                                {{ Form::text('status', false, ['hidden'=> true]) }}
                                                <button class="btn btn-outline-danger">Từ Chối</button>
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