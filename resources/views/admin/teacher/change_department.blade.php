@extends('layouts.manager')
@section('title') Manager Teachers @endsection
@section('main')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Update Teacher</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.subjects.index') }}">Manager Teachers</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Update</li>
                </ol>
            </nav>
        </div>
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>[Warning]</strong> {{ $errors->first() }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        {{ Form::open(['url' => route('admin.teachers.change_department', $teacher->id) , 'method' => 'POST', 'class' => "forms-sample" ]) }}
                        @method('PUT')
                        <div class="form-group">
                            {{ Form::label('department', 'Department')}}
                            <div class="scroll-list">
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
                        </div>
                        <div class="form-group">
                            <div class="form-check form-check-primary">
                                <label class="form-check-label">
                                    {{ Form::checkbox('isManager', 1, $teacher->department->manager_id == $teacher->id, ['class'=>'form-check-input']) }}
                                    Manager Department
                                    <i class="input-helper"></i>
                                </label>
                            </div>
                        </div>
                        {{Form::submit('Submit', ['class'=> 'btn btn-gradient-primary mr-2'])}}
                        <a href="{{ route('admin.teachers.index') }}" class="btn btn-light">Cancel</a>
                        {{ Form::close()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script') @endsection