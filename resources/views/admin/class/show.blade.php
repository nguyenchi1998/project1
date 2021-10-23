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
                <li class="breadcrumb-item " aria-current="page"><a href="">Danh Sách Lớp Học</a></li>
                <li class="breadcrumb-item active" aria-current="page">Danh Sách Sinh Viên</li>
            </ol>
        </nav>
    </div>
@endsection
@section('main')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 ">
                            <h2 class="text-center">{{ $class->name }}</h2>
                        </div>
                    </div>
                    <div class="d-flex mb-4 justify-content-between">
                        <div class="w-15"></div>
                        <a class="btn btn-primary" href="{{ route('admin.classes.create') }}">Thêm Sinh Viên</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
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
                                                <img src="{{ asset($student->avatar->path) }}" alt="avatar">
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
                                                <form action="">
                                                    <button type="submit" class="btn btn-sm btn-danger"
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