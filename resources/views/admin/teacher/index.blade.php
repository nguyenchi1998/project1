@extends('layouts.manager')
@section('title')
    Manager Teachers
@endsection
@section('main')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Manager Teachers</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Manager Teachers</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex mb-4 justify-content-between">
                            <div class="w-15">
                                <form action="{{route('admin.subjects.index')}}">
                                    <select class="form-control" name="filter" onchange="this.form.submit()">
                                        <option value="all"
                                                @if(!$filter || $filter == 'all') selected="selected" @endif>
                                            All Department
                                        </option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}"
                                                    @if($filter && $filter == $department->id) selected="selected" @endif>{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                            <a class="btn btn-primary" href="{{ route('admin.teachers.create') }}">Create</a>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Gender</th>
                                <th>Birthday</th>
                                <th>Address</th>
                                <th>Department</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($teachers as $teacher)
                                <tr>
                                    <td>
                                        {{ $teacher->name }}
                                    </td>
                                    <td>
                                        {{ $teacher->phone }}
                                    </td>
                                    <td>
                                        {{ $teacher->gender ? 'Male' : 'Female' }}
                                    </td>
                                    <td>
                                        {{ $teacher->birthday }}
                                    </td>
                                    <td>
                                        {{ $teacher->address }}
                                    </td>
                                    <td>
                                        {{ $teacher->department->name }}
                                        @if($teacher->department->manager_id == $teacher->id)
                                            <strong class="text text-danger ">(Manager)</strong>
                                        @endif
                                    </td>
                                    <td width="100">
                                        <div class="d-flex justify-content-between">
                                            <div class="mr-3">
                                                <a href="{{ route('admin.teachers.edit', $teacher->id) }}"
                                                   class="btn btn-sm btn-warning">Edit</a>
                                            </div>
                                            <div class="mr-3">
                                                <a href="{{ route('admin.teachers.change_department_show', $teacher->id) }}"
                                                   class="btn btn-sm btn-info">Change Department</a>
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
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#list-subject').DataTable();
        });
    </script>
@endsection