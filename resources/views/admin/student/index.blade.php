@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Quản Lý Sinh Viên</h1>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-lg-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex mb-3 justify-content-between">
                    <div class="">
                        <form action="{{ route('admin.students.index') }}" class="form-inline">
                            <input type="search" name="keyword" value="{{ $keyword }}" class="form-control  mr-2" placeholder="Từ Khoá">
                            {{ Form::select('specialization-filter', $specializations, $specializationFilter, ['class' => 'form-control  mr-2','placeholder' => 'Tất Cả Chuyên Ngành']) }}
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    </div>
                    <a class="btn Tìm Kiếmd-flex align-items-center btn-outline-success" href="{{ route('admin.students.create') }}"><i class="fa fa-plus"></i></a>
                </div>
                <div class="table-responsive table-scroll">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Mã</th>
                                <th>Sinh Viên</th>
                                <th>Email</th>
                                <th>Số Điện Thoại</th>
                                <th>Lớp</th>
                                <th>Chuyên Ngành</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $student)
                            <tr>
                                <td>
                                    {{ $student->code }}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="mr-2">
                                            <img class="img-circle img-avatar" src="{{ assetStorage($student->avatar) }}" alt="avatar">
                                        </div>
                                        {{ $student->name }}
                                    </div>
                                </td>
                                <td>
                                    {{ $student->email }}
                                </td>
                                <td>
                                    {{ $student->phone }}
                                </td>
                                <td>
                                    {{ $student->class->name ?? '' }}
                                </td>
                                <td>
                                    {{ $student->class->specialization->name ?? '' }}
                                </td>
                                <td width="100">
                                    <div class="d-flex justify-content-between">
                                        <div class="mr-1">
                                            <a href="{{ route('admin.students.edit', $student->id) }}" class="btn btn-outline-warning">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </div>
                                        <div>
                                            <form action="{{ route('admin.students.destroy', $student->id) }}" method="post">
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
                    {{ $students->appends(['specialization-filter' => $specializationFilter, 'keyword' => $keyword])->links() }}
                </div>
            </div>
        </div>
    </div>
</div>