@extends('layouts.manager')
@section('breadcrumb')
    <div class="col-sm-6">
        <h1 class="m-0">Quản Lý Môn Học</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Bảng Điều Khiển</a></li>
            <li class="breadcrumb-item active">Danh Sách Môn Học</li>
        </ol>
    </div>
@endsection
@section('main')
    <div class="row">
        <div class="col-lg-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-3 justify-content-between">
                        <form action="{{ route('admin.subjects.index') }}">
                            <div class="d-flex justify-content-between">
                                <input type="search" name="keyword" value="{{ $keyword }}"
                                       class="form-control  mr-2" placeholder="Từ Khoá">
                                {{ Form::select('department-filter', $departments, $departmentFilter, ['class' => 'mr-2 form-control ', 'onchange' => 'this.form.submit()', 'placeholder' => 'Tất Cả Khoa Viện']) }}
                                {{ Form::select('type-filter', $types, $typeFilter, ['class' => 'mr-2 form-control ', 'onchange' => 'this.form.submit()', 'placeholder' => 'Tất Cả Thể Loại']) }}
                                <button class="btn-sm btn btn-outline-info" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>
                        <a class="btn btn-sm d-flex align-items-center btn-outline-success"
                           href="{{ route('admin.subjects.create') }}">Tạo Mới</a>
                    </div>
                    <div class="table-responsive table-scroll">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Môn Học</th>
                                <th>Số Tín Chỉ</th>
                                <th>Khoa Viện Phụ Trách</th>
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
                                        {{ $subject->credit }}
                                    </td>
                                    <td>
                                        {{ $subject->department->name }}
                                    </td>
                                    <td style="width: 100px">
                                        <div class="d-flex justify-content-between">
                                            <div class="mr-2">
                                                <a href="{{ route('admin.subjects.edit', $subject->id) }}"
                                                   class="btn btn-sm btn-outline-warning" data-toggle="tooltip"
                                                   data-placement="top" title="Sửa">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </div>
                                            <div>
                                                <form action="{{ route('admin.subjects.destroy', $subject->id) }}"
                                                      method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            data-toggle="tooltip" data-placement="top" title="Xoá">
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
                        {{ $subjects->appends(['department-filter' => $departmentFilter, 'type-filter' => $typeFilter, 'keyword' => $keyword])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')

@endsection