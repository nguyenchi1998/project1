@extends('layouts.manager')
@section('title')
    Quản Lý Lớp Học
@endsection
@section('breadcrumb')
    <div class="page-header">
        <h3 class="page-title">Manager Classes</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
                <li class="breadcrumb-item " aria-current="page"><a href="{{ route('admin.classes.index') }}">Danh Sách Lớp Học</a></li>
                <li class="breadcrumb-item active" aria-current="page">Danh Sách Sinh Viên</li>
            </ol>
        </nav>
    </div>
@endsection
@section('main')
    <div class="row">
        <div class="col-lg-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 ">
                            <h2 class="text-center">{{ $class->name }}</h2>
                        </div>
                    </div>
                    <div class="d-flex mb-4 justify-content-between">
                        <div class=""></div>
                        <a class="btn btn-outline-success btn-sm" href="{{ route('admin.classes.create') }}">Thêm Sinh Viên</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="sticky-top bg-gradient-primary ">
                            <tr>
                                <th class="text text-white">Student</th>
                                <th class="text text-white">Phone</th>
                                <th class="text text-white">Gender</th>
                                <th class="text text-white">Birthday</th>
                                <th class="text text-white">Address</th>
                                <th class="text text-white"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($class->students as $student)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="mr-4">
                                                <img src="{{ assetStorage($student->avatar->path) }}" alt="avatar">
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
                                                <form action="{{ route('admin.classes.remove_student', $class->id) }}"
                                                      method="POST">
                                                    @csrf()
                                                    {{ Form::text('student_id', $student->id, ['hidden' => true]) }}
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            data-toggle="tooltip" data-placement="top"
                                                            title="Xoá Sinh Viên Khỏi Lớp">Remove
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