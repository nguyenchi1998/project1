@extends('layouts.manager')
@section('title') Manager Teachers @endsection
@section('breadcrumb')
    <div class="page-header">
        <h3 class="page-title">Update Teacher</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.teachers.index') }}">Teachers</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Subject</li>
            </ol>
        </nav>
    </div>
@endsection
@section('main')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="mb-5">
                        <div class="form-row">
                            <div class="col-6">
                                <div class="form-group">
                                    <strong>Teacher</strong>:<span> {{ $teacher->name }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <strong>Department:</strong> {{ $teacher->department->name }}
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ Form::open(['url' => route('admin.teachers.choose_subject', $teacher->id) , 'method' => 'POST']) }}
                    @method('PUT')
                    <div class="form-group">
                        {{ Form::label('subject', 'Subject')}}
                        @foreach($subjects as $key => $subject)
                            <div class="form-check form-check-info">
                                <label class="form-check-label">
                                    {{ Form::checkbox('subject_id[]', $subject['id'], in_array($subject['id'], $teacherSubjects),  ['class'=>'form-check-input']) }}
                                    {{ $subject['name'] }}
                                    <i class="input-helper"></i>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    {{Form::submit('Submit', ['class'=> 'btn btn-gradient-primary mr-2'])}}
                    <a href="{{ route('admin.teachers.index') }}" class="btn btn-light">Cancel</a>
                    {{ Form::close()}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script') @endsection