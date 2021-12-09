@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Quản Lý Chuyên Ngành</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item active">Danh Sách Chuyên Ngành</li>
    </ol>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-lg-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex mb-3 justify-content-between">
                    <div class="max-50">
                        <form action="{{ route('admin.specializations.index') }}">
                            <div class="d-flex justify-content-between">
                                <input type="search" name="keyword" value="{{ $keyword }}" class="form-control  mr-2" placeholder="Từ Khoá">
                                {{ Form::select('department-filter', $departments, $departmentFilter, ['class' => 'mr-2 form-control ', 'placeholder' => 'Tất Cả Khoa Viện']) }}
                                <button class="btn btn-sm btn-outline-info" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <a class="btn btn-sm d-flex align-items-center btn-outline-success" href="{{ route('admin.specializations.create') }}">Tạo Mới</a>
                </div>
                <div class="table-responsive table-scroll">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Chuyên Ngành</th>
                                <th>Khoa Viện</th>
                                <th>Số Môn Học</th>
                                <th>Số Tín Chỉ Tối Thiểu</th>
                                <th>Số Kỳ Học</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($specializations as $specialization)
                            <tr class="{{ modelTrash($specialization) }}">
                                <td>
                                    {{ $specialization->name }}
                                </td>
                                <td>
                                    {{ $specialization->department->name ?? '' }}
                                </td>
                                <td>
                                    {{ count($specialization->subjects) }}
                                </td>
                                <td>
                                    {{ $specialization->min_credit }}
                                </td>
                                <td>
                                    {{ $specialization->max_semester }}
                                </td>
                                <td style="width: 100px">
                                    <div class="d-flex justify-content-center">
                                        @if($specialization->deleted_at)
                                        <form action="{{ route('admin.specializations.restore', $specialization->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger" data-toggle="tooltip" data-placement="top" title="Khôi Phục">
                                                <i class="fa fa-trash-restore-alt"></i>
                                            </button>
                                        </form>
                                        @else
                                        <div class="mr-2">
                                            <a href="{{ route('admin.specializations.choose_subject_show', $specialization->id) }}" class="btn btn-sm btn-outline-info" data-toggle="tooltip" data-placement="top" title="Chọn Môn Giảng Dạy">
                                                <i class="fa fa-book"></i>
                                            </a>
                                        </div>
                                        <div class="mr-2">
                                            <a href="{{ route('admin.specializations.edit', $specialization->id) }}" class="btn btn-sm btn-outline-warning" data-toggle="tooltip" data-placement="top" title="Sửa">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </div>
                                        <form action="{{ route('admin.specializations.destroy', $specialization->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" data-toggle="tooltip" data-placement="top" title="Xoá">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                        @endif
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
                    {{ $specializations->appends(['keyword' => $keyword])->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

@endsection