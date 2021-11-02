@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Quản Lý Giảng Viên</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.teachers.index') }}">Danh Sách Giảng Viên</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Chọn Môn Giảng Dạy</li>
    </ol>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <div class="form-row">
                        <div class="col-6">
                            <div class="form-group">
                                Giảng Viên: {{ $teacher->name }}
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                Khoa Viện: {{ $teacher->department->name }}
                            </div>
                        </div>
                    </div>
                </div>
                {{ Form::open(['url' => route('admin.teachers.choose_subject', $teacher->id) , 'method' => 'POST']) }}
                @method('PUT')
                <div class="table-responsive table-scroll">
                    <table class="table table-bordered" id="subjects">
                        <thead>
                            <tr>
                                <th>Môn Học</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subjects as $key => $subject)
                            <tr>
                                <td>
                                    {{ $subject['name'] }}
                                </td>
                                <td class="text-center">
                                    {{ Form::checkbox('subject_id[]', $subject['id'], in_array($subject['id'], $teacherSubjects)) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{Form::submit('Xác Nhận', ['class'=> 'btn btn-outline-success mr-2']) }}
                    <a href="{{ route('admin.teachers.index') }}" class="btn btn-outline-dark">Huỷ Bỏ</a>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script') @endsection