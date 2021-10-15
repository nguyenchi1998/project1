@extends('layouts.manager')
@section('title')
    Manager Specializations
@endsection
@section('main')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Manager Specializations</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Manager Specializations</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex mb-4">
                            <a class="btn btn-primary" href="{{ route('admin.specializations.create') }}">Create</a>
                        </div>
                        <div class="table-responsive"><table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Number Subject</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($specializations as $specialization)
                                <tr>
                                    <td>
                                        {{ $specialization->name }}
                                    </td>
                                    <td>
                                        {{ count($specialization->subjects) }}
                                    </td>
                                    <td width="100">
                                        <div class="d-flex justify-content-between">
                                            <div class="mr-3">
                                                <a href="{{ route('admin.specializations.edit', $specialization->id) }}"
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