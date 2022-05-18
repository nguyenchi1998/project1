@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Teacher Management</h1>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-lg-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex mb-3 justify-content-between">
                    <div class="">
                        <form action="{{ route('admin.teachers.index') }}" class="form-inline">
                            <input type="search" name="keyword" value="{{ $keyword }}" class="form-control  mr-2" placeholder="Keyword">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    </div>
                    <a class="btn Tìm Kiếmd-flex align-items-center btn-outline-success" href="{{ route('admin.teachers.create') }}"><i class="fa fa-plus"></i></a>
                </div>
                <div class="table-responsive table-scroll">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Teacher</th>
                                <th>Gender</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($teachers as $teacher)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="mr-4">
                                            <img class="img-circle img-avatar" src="{{ assetStorage($teacher->avatar) }}" alt="avatar">
                                        </div>
                                        {{ $teacher->name }}
                                    </div>
                                </td>
                                <td>
                                    <p class="text-capitalize">{{ array_search($teacher->gender, config('config.gender')) }}</p>
                                </td>
                                <td>
                                    {{ $teacher->email }}
                                </td>
                                <td>
                                    {{ $teacher->phone }}
                                </td>
                                <td width="100">
                                    <div class="d-flex justify-content-between">
                                        <div class="mr-2">
                                            <a href="{{ route('admin.teachers.edit', $teacher->id) }}" class="btn btn-outline-primary">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </div>
                                        <div class="mr-2">
                                            <a href="{{ route('admin.teachers.choose_subject_show', $teacher->id) }}" class="btn btn-outline-dark">
                                               <i class="fa fa-book"></i>
                                            </a>
                                        </div>
                                        <div>
                                            <form action="{{ route('admin.teachers.destroy', $teacher->id) }}">
                                                <button type="submit" class="btn btn-outline-danger">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 d-flex justify-content-end">
                    {{ $teachers->appends(['keyword' => $keyword])->links() }}
                </div>
            </div>
        </div>
    </div>
    @endsection @section('script')
    @endsection