@extends('layouts.manager')
@section('breadcrumb')
    <div class="col-sm-6">
        <h1 class="m-0">Teacher Management</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="#">Bảng Điều Khiển</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.teachers.index') }}">Danh Sách Teacher</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Yêu Cầu Đổi Viện</li>
        </ol>
    </div>
@endsection
@section('main')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {{ Form::open([
                        'url' => route('admin.teachers.change_department', $teacher->id),
                        'method' => 'POST',
                    ]) }}
                    @method('PUT')
                    <div class="form-group">
                        {{ Form::label('department', 'Viện') }}
                        @foreach ($departments as $key => $department)
                            <div class="form-check form-check-info">
                                <label class="form-check-label">
                                    {{ Form::radio('department_id', $department->id, $teacher->department->id == $department->id, [
                                        'class' => 'form-check-input',
                                    ]) }}
                                    {{ $department->name }}
                                    <i class="input-helper"></i>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-3">
                        {{ Form::submit('Submit', [
                            'class' => 'btn btn-outline-success mr-2',
                        ]) }}
                        <a href="{{ route('admin.teachers.index') }}" class="btn btn-outline-dark">Cancel</a>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
