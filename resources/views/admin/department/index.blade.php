@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Danh Sách Viện</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item active">Danh Sách Viện</li>
    </ol>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-lg-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex mb-3 justify-content-between">
                    <form action="{{ route('admin.departments.index') }}" class="form-inline">
                        <input type="search" name="keyword" value="{{ $keyword }}" class="form-control mr-2 " placeholder="Từ Khoá">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                    <a class="btn Tìm Kiếmd-flex align-items-center btn-outline-success" href="{{ route('admin.departments.create') }}"><i class="fa fa-plus"></i></a>
                </div>
                <div class="table-responsive table-scroll">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Viện</th>
                                <th>Viện Trưởng</th>
                                <th>Số chuyên ngành</th>
                                <th>Sô Giáo Viên</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($departments as $department)
                            <tr>
                                <td>{{ $department->name }}</td>
                                <td>
                                    <form action="{{ route('admin.departments.changeManager', $department->id) }}" method="post">
                                        @csrf
                                        {{ Form::select('next_manager_id', $department->teachers->pluck('name', 'id')->toArray(), $department->manager->id ?? null, ['onchange' => 'this.form.submit()', 'class' => 'form-control', 'placeholder' => 'Chọn Viện Trưởnng']) }}
                                    </form>
                                </td>
                                <td>{{ count($department->specializations) }}</td>
                                <td>{{ count($department->teachers) }}</td>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <div class="mr-2">
                                            <a href="{{ route('admin.departments.edit', $department->id) }}" class="btn btn-outline-warning"><i class="fa fa-edit"></i></a>
                                        </div>
                                        <div>
                                            <form action="">
                                                <button type="submit" class="btn btn-outline-danger"><i class="fa fa-trash"></i>
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
                    {{ $departments->appends(['keyword' => $keyword])->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection