@extends('layouts.manager')
@section('title')
    Manager Schedules
@endsection
@section('main')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Manager Schedules</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Manager Schedules
                    </li>
                </ol>
            </nav>
        </div>
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Warning!</strong> {{ $errors->first() }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session()->get('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-5">
                            <div class="form-row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <strong>Class</strong>:<span> {{ $class->name }}</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <strong>Specialization:</strong> {{ $class->specialization->name }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive mb-3">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>Credit</th>
                                    <th>Start Time</th>
                                    <th>Teachers</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($unCreditSubjects as $subject)
                                    {{ Form::open(['url' => route('admin.schedules.register', $id), 'method' => 'post']) }}
                                    <tr>
                                        <td>
                                            {{ $subject->name }}
                                        </td>
                                        <td>
                                            {{ $subject->credit }}
                                        </td>
                                        <td>
                                            {{ Form::date('start_time', null, ['placeholder'=> 'Choose teacher', 'class' => 'form-control form-control-sm', 'required' => true]) }}
                                        </td>
                                        <td>
                                            {{ Form::select('teacher_id', $subject->teachers->pluck('name', 'id')->toArray(), null, ['placeholder'=> 'Choose teacher', 'class' => 'form-control form-control-sm']) }}
                                        </td>
                                        <td width="100">
                                            <div class="d-flex justify-content-between">
                                                <div class="mr-3">
                                                    {{ Form::text('class_id', $id, ['hidden' => true])}}
                                                    {{ Form::text('subject_id', $subject->id, ['hidden' => true])}}
                                                    {{ Form::submit('Register', ['class' => 'btn btn-success']) }}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    {{ Form::close() }}
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection @section('script') @endsection