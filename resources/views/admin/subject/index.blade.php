@extends('layouts.manager')
@section('title')
    Manager Subjects
@endsection
@section('main')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Manager Subjects</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Manager Subjects</li>
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
                                                @if(!$filter || $filter == 'all') selected="selected" @endif>All
                                            Specialization
                                        </option>
                                        @foreach($specializations as $specialization)
                                            <option value="{{ $specialization->id }}"
                                                    @if($filter && $filter == $specialization->id) selected="selected" @endif>{{ $specialization->name }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                            <a class="btn btn-primary" href="{{ route('admin.subjects.create') }}">Create</a>
                        </div>
                        <div class="table-responsive"><table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Credit</th>
                                <th>Specializations</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($subjects as $subject)
                                <tr>
                                    <td>{{ $subject->name }}</td>
                                    <td>{{ $subject->credit }}</td>
                                    <td style="white-space:normal">
                                        @if($subject->type == config('common.subjectType.basic'))
                                            Basic
                                        @else
                                            {{ $subject->specializations }}
                                        @endif
                                    </td>
                                    <td width="100">
                                        <div class="d-flex justify-content-between">
                                            <div class="mr-3">
                                                <a href="{{ route('admin.subjects.edit', $subject->id) }}"
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
    <script type="text/javascript">
        $(document).ready(function () {
            $('#list-subject').DataTable();
        });
    </script>
@endsection