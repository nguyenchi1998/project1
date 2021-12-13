@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Danh Sách Sinh Viên</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.classes.index') }}">Danh Sách Lớp Học</a></li>
        <li class="breadcrumb-item active">Danh Sách Sinh Viên</li>
    </ol>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-lg-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 ">
                        <h2 class="text-center">Lớp: {{ $class->name }}</h2>
                    </div>
                </div>
                <div class="d-flex mb-3 justify-content-between">
                    <div class=""></div>
                    <a class="btn btn-outline-success" href="{{ route('admin.classes.create') }}">Thêm Sinh
                        Viên</a>
                </div>
                <div class="table-responsive table-scroll">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Phone</th>
                                <th>Gender</th>
                                <th>Birthday</th>
                                <th>Address</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($class->students as $student)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="mr-4">
                                            <img class="img-circle img-avatar" src="{{ assetStorage($student->avatar->path) }}" alt="avatar">
                                        </div>
                                        {{ $student->name }}
                                    </div>
                                </td>
                                <td>
                                    {{ $student->phone }}
                                </td>
                                <td>
                                    {{ $student->gender ? 'Male' : 'Female' }}
                                </td>
                                <td>
                                    {{ $student->birthday }}
                                </td>
                                <td>
                                    {{ $student->address }}
                                </td>
                                <td width="100">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <form action="{{ route('admin.classes.remove_student', $class->id) }}" method="POST">
                                                @csrf()
                                                {{ Form::text('student_id', $student->id, ['hidden' => true]) }}
                                                <button type="submit" class="btn btn-outline-danger">
                                                    Xóa
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