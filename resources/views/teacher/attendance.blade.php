@extends('layouts.teacher')
@section('title')
    Manager Schedules
@endsection
@section('main')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Manager Schedules</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('teacher.home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('teacher.schedules.index') }}">Manager Schedules</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Attendance
                    </li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="mt-6">
                            {{ Form::open(['url' =>route('admin.classes.store') , 'method' => 'POST', 'class' => "forms-sample" ]) }}
                            <div class="form-row">
                                <div class="col-6">
                                    <div class="form-group">
                                        Name: {{ $schedule->name }}
                                    </div>
                                    <div class="form-group">
                                        Subject: {{ $schedule->subject->name }}
                                    </div>
                                    <div class="form-group">
                                        Teacher: {{ $schedule->teacher->name }}
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        Students: {{ count($scheduleDetails) }}
                                    </div>
                                    <div class="form-group">
                                        Date: {{ now()->format('d/m/yy') }}
                                    </div>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                        <div class="table-responsive mb-3">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Student</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($scheduleDetails as $student)
                                    <tr>
                                        <td>
                                            {{ $student->student->name }}
                                        </td>
                                        <td width="100">
                                            <div class="text-center">
                                                {{ Form::checkbox('student_id[]', $student->id, false)  }}
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
    </div>
@endsection @section('script') @endsection