@extends('layouts.manager')
@section('title')
    Manager Schedules
@endsection
@section('breadcrumb')
    <div class="page-header">
        <h3 class="page-title">Manager Schedules</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    Schedules
                </li>
            </ol>
        </nav>
    </div>
@endsection
@section('main')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-4">
                        <div class="w-25">
                            <form action="">
                                {{ Form::select('semester', $semesters, $semester ?? null, ['class' => 'form-control', 'placeholder' => 'Choose semester', 'onchange' => 'this.form.submit()']) }}
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Class</th>
                                <th>Current Semester</th>
                                <th>Specialization</th>
                                <th>Students</th>
                                <th>Uncredit Subjects</th>
                                <th>Basic Subjects</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($allClasses as $class)
                                <tr>
                                    <td>
                                        {{ $class->name }}
                                    </td>
                                    <td>
                                        {{ $class->semester }}
                                    </td>
                                    <td>
                                        {{ $class->specialization->name }}
                                    </td>
                                    <td>
                                        {{ count($class->students) }}
                                    </td>
                                    <td>
                                        {{ count($class->unCreditSubjects) }}
                                    </td>
                                    <td>
                                        {{ count($basicSubjects) }}
                                    </td>
                                    <td width="100">
                                        <div class="d-flex justify-content-between">
                                            <div class="mr-3">
                                                <a class="btn btn-sm btn-success"
                                                   href="{{route('admin.schedules.registerShow', $class->id) }}">Register</a>
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
@endsection @section('script') @endsection