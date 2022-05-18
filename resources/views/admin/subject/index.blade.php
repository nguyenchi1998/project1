@extends('layouts.manager')
@section('breadcrumb')
    <div class="col-sm-6">
        <h1 class="m-0">Subject Management</h1>
    </div>
@endsection
@section('main')
    <div class="row">
        <div class="col-lg-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-3 justify-content-between">
                        <div class="">
                            <form action="{{ route('admin.subjects.index') }}" class="form-inline">
                                <input type="search" name="keyword" value="{{ $keyword }}" class="form-control  mr-2"
                                       placeholder="Keyword">
                                <select name="type-filter" class="form-control mr-2">
                                    <option value="">All type</option>
                                    <option value="{{ config('constant.subject_type.natural') }}"
                                            @if($typeFilter===config('constant.subject_type.natural')) selected @endif>
                                       Natural Subject
                                    </option>
                                    <option value="{{ config('constant.subject_type.social') }}"
                                            @if($typeFilter===config('constant.subject_type.social')) selected @endif>
                                       Social Subject
                                    </option>
                                </select>
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </form>
                        </div>
                        <a class="btn Tìm Kiếmd-flex align-items-center btn-outline-success"
                           href="{{ route('admin.subjects.create') }}"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="table-responsive table-scroll">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Number Lessons</th>
                                <th>Type</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($subjects as $subject)
                                <tr>
                                    <td>
                                        {{ $subject->name }}
                                    </td>
                                    <td>
                                        {{ $subject->number_lessons }}
                                    </td>
                                    <td>
                                        <p class="text-capitalize">{{ array_search($subject->name, config('constant.subject_type')) }}</p>
                                    </td>
                                    <td style="width: 100px">
                                        <div class="d-flex justify-content-between">
                                            <div class="mr-2">
                                                <a href="{{ route('admin.subjects.edit', $subject->id) }}"
                                                   class="btn btn-outline-primary">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </div>
                                            <div>
                                                <form action="{{ route('admin.subjects.destroy', $subject->id) }}"
                                                      method="post">
                                                    @csrf
                                                    @method('DELETE')
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
                        {{ $subjects->appends([
                                'type-filter' => $typeFilter,
                                'keyword' => $keyword
                            ])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
