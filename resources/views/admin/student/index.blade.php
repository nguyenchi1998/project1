@extends('layouts.manager')
@section('breadcrumb')
    <div class="col-sm-6">
        <h1 class="m-0">Student Management</h1>
    </div>
@endsection
@section('main')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-3 justify-content-between">
                        <div class="">
                            <form action="{{ route('admin.students.index') }}" class="form-inline">
                                <input type="search" name="keyword" value="{{ $keyword }}" class="form-control  mr-2"
                                       placeholder="Keyword">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </form>
                        </div>
                        <a class="btn Tìm Kiếmd-flex align-items-center btn-outline-success"
                           href="{{ route('admin.students.create') }}"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="table-responsive table-scroll">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Student</th>
                                <th>Email</th>
                                <th>Birthday</th>
                                <th>Phone</th>
                                <th>Class</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($students as $student)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="mr-2">
                                                <img class="img-circle img-avatar"
                                                     src="{{ assetStorage($student->avatar) }}" alt="avatar">
                                            </div>
                                            {{ $student->name }}
                                        </div>
                                    </td>
                                    <td>
                                        {{ $student->email }}
                                    </td>
                                    <td>
                                        {{ $student->birthday }}
                                    </td>
                                    <td>
                                        {{ $student->phone }}
                                    </td>
                                    <td>
                                        {{ $student->classRoom->name ?? '' }}
                                    </td>

                                    <td width="100">
                                        <div class="d-flex justify-content-between">
                                            <div class="mr-1">
                                                <a href="{{ route('admin.students.edit', $student->id) }}"
                                                   class="btn btn-outline-primary">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </div>
                                            <div>
                                                <form action="{{ route('admin.students.destroy', $student->id) }}"
                                                      method="post">
                                                    @method('DELETE')
                                                    @csrf()
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
                    <div class="mt-3 d-flex justify-content-end">
                        {{ $students->appends(['keyword' => $keyword])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection