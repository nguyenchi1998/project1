@extends('layouts.manager')
@section('title')
    Manager Classes
@endsection
@section('main')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Manager Classes</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item " aria-current="page"><a href="">Manager Classes</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Manager Student</li>
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
                        <div class="row">
                            <div class="col-lg-12 ">
                                <h2 class="text-center">{{ $class->name }}</h2>
                            </div>
                        </div>
                        <div class="d-flex mb-4">
                            <a class="btn btn-primary" href="{{ route('admin.classes.create') }}">Add Student</a>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Student</th>
                                <th>Phone</th>
                                <th>Gender</th>
                                <th>Birthday</th>
                                <th>Address</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($class->students as $student)
                                <tr>
                                    <td>
                                        {{ $student->name }}
                                    </td>
                                    <td>
                                        {{ $student->phone }}
                                    </td>
                                    <td>
                                        {{ $student->gender ? 'Male' : 'Female' }}
                                    </td>
                                    <td>
                                        {{ $student->birthday }}
                                    </td>
                                    <td>
                                        {{ $student->address }}
                                    </td>
                                    <td width="100">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <form action="">
                                                    <button type="submit" class="btn btn-sm btn-danger">Remove</button>
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
@endsection