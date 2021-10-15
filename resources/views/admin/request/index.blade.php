@extends('layouts.manager')
@section('title')
    Manager Requests
@endsection
@section('main')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Manager Requests</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Manager Requests</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Department</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Teacher</th>
                                    <th>Seniority</th>
                                    <th>Old Department</th>
                                    <th>New Department</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($moveDepartmenteTeachers as $teacher)
                                    <tr>
                                        <td>{{ $teacher->titleRequest }}</td>
                                        <td>{{ $teacher->name }}</td>
                                        <td>{{ $teacher->seniority }} years</td>
                                        <td>
                                            {{ $teacher->department->name }}
                                            <label class="ml-2 badge badge-danger">{{ $teacher->department->manager_id == $teacher->id ? 'Manager' : '' }}</label>
                                        </td>
                                        <td>
                                            {{ $teacher->nextDepartment->name }}
                                            <label class="ml-2 badge badge-danger">{{ $teacher->nextDepartment->next_manager_id == $teacher->id ? 'Manager' : '' }}</label>
                                        </td>
                                        <td width="100">
                                            <div class="d-flex justify-content-between">
                                                <div class="mr-1">
                                                    <form action="{{ route('admin.requests.departments.approve') }}"
                                                          method="post">
                                                        @csrf
                                                        {{ Form::text('teacherId', $teacher->id, ['hidden'=> true]) }}
                                                        <button class="btn btn-sm btn-success">Approve</button>
                                                    </form>
                                                </div>
                                                <div>
                                                    <form action="{{ route('admin.requests.departments.reject') }}"
                                                          method="post">
                                                        @csrf
                                                        {{ Form::text('teacherId', $teacher->id, ['hidden'=> true]) }}
                                                        <button class="btn btn-sm btn-danger">Reject</button>
                                                    </form>
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
    </div>
@endsection
@section('script')
@endsection