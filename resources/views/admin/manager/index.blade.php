@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Quản Lý Quản Trị Viên</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item active">Danh Sách Quản Trị Viên</li>
    </ol>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-lg-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex mb-4 justify-content-between">
                    <div class="">
                        <form action="{{ route('admin.managers.index') }}">
                            <div class="d-flex justify-content-between">
                                <input type="search" name="keyword" value="{{ $keyword }}" class="form-control form-control-sm mr-2" placeholder="Từ Khoá">
                                <button class="ml-2 btn btn-sm btn-outline-success" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <a class="btn btn-sm d-flex align-items-center btn-outline-success" href="{{ route('admin.managers.create') }}">Tạo mới</a>
                </div>
                <div class="table-responsive table-scroll">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Quản Trị Viên</th>
                                <th>Email</th>
                                <th>Số Điện Thoại</th>
                                <th>Giới Tính</th>
                                <th>Ngày Sinh</th>
                                <th>Địa Chỉ</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($managers as $manager)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="mr-4">
                                            <img class="img-circle elevation-2 img-avatar" src="{{ assetStorage($manager->avatar->path) }}" alt="avatar">
                                        </div>
                                        {{ $manager->name }}
                                    </div>
                                </td>
                                <td>
                                    {{ $manager->email }}
                                </td>
                                <td>
                                    {{ $manager->phone }}
                                </td>
                                <td>
                                    {{ $manager->gender ? 'Male' : 'Female' }}
                                </td>
                                <td>
                                    {{ $manager->birthday }}
                                </td>
                                <td>
                                    {{ $manager->address }}
                                </td>
                                <td width="100">
                                    <div class="d-flex justify-content-between">
                                        <div class="mr-2">
                                            <a href="{{ route('admin.managers.edit', $manager->id) }}" class="btn btn-sm btn-outline-warning" data-toggle="tooltip" data-placement="top" title="Sửa"><i class="fa fa-edit"></i></a>
                                        </div>
                                        <div>
                                            <form method="post" action="{{ route('admin.managers.destroy', $manager->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" data-toggle="tooltip" data-placement="top" title="Xoá">
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
                    {{ $managers->appends(['keyword' => $keyword])->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

@endsection