@extends('layouts.manager')
@section('title') Quản Lý Môn Học @endsection
@section('breadcrumb')
    <div class="page-header">
        <h3 class="page-title">Tạo mới</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.subjects.index') }}">Danh Sách Môn Học</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Tạo mới</li>
            </ol>
        </nav>
    </div>@endsection
@section('main')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['url' =>route('admin.subjects.store') , 'method' => 'POST']) }}
                    <div class="form-group">
                        {{ Form::label('name', 'Môn Học')}}
                        {{ Form::input('text', 'name', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Môn Học']) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('credit', 'Số Tín Chỉ')}}
                        {{ Form::input('number', 'credit', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Số Tín Chỉ', 'min' => 1]) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('semester', 'Kì Học')}}
                        {{ Form::select('semester', $semesters , null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Kì Học', 'min' => 1, 'max' => config('common.semester.max')]) }}
                    </div>
                    <div class="form-group">
                        <label for="department">Khoa Viện</label>
                        @foreach($departments as $key => $department)
                            <div class="form-check form-check-info">
                                <label class="form-check-label">
                                    {{ Form::radio('department_id', $department->id, false, ['class'=>'form-check-input']) }}
                                    {{ $department->name }}
                                    <i class="input-helper"></i>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <div class="form-check form-check-primary">
                            <label class="form-check-label">
                                {{ Form::checkbox('basic', config('common.subject.type.basic'), false, ['class'=>'form-check-input']) }}
                                Môn Cơ Bản
                                <i class="input-helper"></i>
                            </label>
                        </div>
                    </div>
                    {{Form::submit('Xác Nhận', ['class'=> 'btn btn-gradient-primary mr-2'])}}
                    <a href="{{ route('admin.subjects.index') }}" class="btn btn-light">Huỷ Bỏ</a>
                    {{ Form::close()}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script') @endsection