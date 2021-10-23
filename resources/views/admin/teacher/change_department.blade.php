@extends('layouts.manager')
@section('title') Quản Lý Giảng Viên @endsection
@section('breadcrumb')
    <div class="page-header">
        <h3 class="page-title">Yêu Cầu Đổi Viện</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.subjects.index') }}">Danh Sách Giảng Viên</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Yêu Cầu Đổi Viện</li>
            </ol>
        </nav>
    </div>
@endsection
@section('main')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['url' => route('admin.teachers.change_department', $teacher->id) , 'method' => 'POST']) }}
                    @method('PUT')
                    <div class="form-group">
                        {{ Form::label('department', 'Khoa Viện')}}
                        @foreach($departments as $key => $department)
                            <div class="form-check form-check-info">
                                <label class="form-check-label">
                                    {{ Form::radio('department_id', $department->id, $teacher->department->id == $department->id ,  ['class'=>'form-check-input']) }}
                                    {{ $department->name }}
                                    <i class="input-helper"></i>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <div class="form-check form-check-primary">
                            <label class="form-check-label">
                                {{ Form::checkbox('isManager', 1, $teacher->department->manager_id == $teacher->id, ['class'=>'form-check-input']) }}
                                Viện Trưởng
                                <i class="input-helper"></i>
                            </label>
                        </div>
                    </div>
                    {{Form::submit('Xác Nhận', ['class'=> 'btn btn-gradient-primary mr-2'])}}
                    <a href="{{ route('admin.teachers.index') }}" class="btn btn-light">Huỷ Bỏ</a>
                    {{ Form::close()}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script') @endsection