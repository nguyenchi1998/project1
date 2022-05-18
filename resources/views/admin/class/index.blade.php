@extends('layouts.manager')
@section('breadcrumb')
    <div class="col-sm-6">
        <h1 class="m-0">Class Management</h1>
    </div>
@endsection
@section('main')
    <div class="row">
        <div class="col-lg-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-3 justify-content-between">
                        <form action="{{ route('admin.classes.index') }}" class="form-inline">
                            <input type="search" name="keyword" value="{{ $keyword }}" class="form-control mr-2"
                                   placeholder="Keyword">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                        <a class="btn Tìm Kiếmd-flex align-items-center btn-outline-success"
                           href="{{ route('admin.classes.create') }}">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                    <div class="table-responsive table-scroll">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Class</th>
                                <th>Total Student</th>
                                <th>Manager Teacher</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($classes as $class)
                                <tr>
                                    <td>
                                        {{ $class->name }}
                                    </td>
                                    <td>
                                        {{ count($class->students) }}
                                    </td>
                                    <td>
                                        {{ $class->teacher->name ?? 'Unset' }}
                                    </td>
                                    <td style="width: 100px">
                                        <div class="d-flex justify-content-between">
                                            <div class="mr-2">
                                                <a href="{{ route('admin.classes.edit', $class->id) }}"
                                                   class="btn btn-outline-primary">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </div><div class="mr-2">
                                                <a href="{{ route('admin.classes.students', $class->id) }}"
                                                   class="btn btn-outline-dark">
                                                    <i class="fa fa-users"></i>
                                                </a>
                                            </div>
                                            <div>
                                                <form action="{{ route('admin.classes.destroy', $class->id) }}">
                                                    <button type="submit" class="btn btn-outline-danger">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <div class="pt-3 d-flex justify-content-center">
                                    <h4>Empty Data</h4>
                                </div>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection