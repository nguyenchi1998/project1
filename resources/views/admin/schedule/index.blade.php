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
                    <li class="breadcrumb-item active" aria-current="page">Manager Schedules</li>
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
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex mb-4">
                            <a class="btn btn-primary" href="{{ route('admin.schedules.create') }}">Create</a>
                        </div>
                        <div class="table-responsive"><table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Schedule</th>
                                <th>Subject</th>
                                <th>Teacher</th>
                                <th>Number Student</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($schedules as $schedule)
                                <tr>
                                    <td>
                                        {{ $schedule->subject->name }}
                                    </td>
                                    <td>
                                        {{ $schedule->subject->name }}
                                    </td>
                                    <td>
                                        {{ $schedule->teacher->name }}
                                    </td>
                                    <td>
                                        {{ count($schedule->scheduleDetails) }}
                                    </td>
                                    <td width="100">
                                        <div class="d-flex justify-content-between">
                                            <div class="mr-3">
                                                <a href="{{ route('admin.classes.show', $schedule->id) }}"
                                                   class="btn btn-sm btn-info">Student</a>
                                            </div>
                                            <div class="mr-3">
                                                <a href="{{ route('admin.classes.edit', $schedule->id) }}"
                                                   class="btn btn-sm btn-warning">Edit</a>
                                            </div>
                                            <div>
                                                <form action="">
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection