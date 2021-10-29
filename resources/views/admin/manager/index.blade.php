@extends('layouts.manager')
@section('title')
    Quản Lý Quản Trị Viên
@endsection
@section('breadcrumb')
    <div class="page-header">
        <h3 class="page-title">Danh Sách Quản Trị Viên</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
                <li class="breadcrumb-item active" aria-current="page">Danh Sách Quản Trị Viên</li>
            </ol>
        </nav>
    </div>@endsection
@section('main')
    <div class="row">
        <div class="col-lg-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-4 justify-content-between">
                        <div class="">
                            <form action="{{ route('admin.managers.index') }}">
                                <div class="d-flex justify-content-between">
                                    <input type="search" name="keyword" value="{{ $keyword }}" class="form-control form-control-sm mr-2"
                                           placeholder="Từ Khoá">
                                    <button class="ml-2 btn btn-sm btn-outline-success" type="submit">
                                        <i class="mdi mdi-search-web"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <a class="btn btn-sm d-flex align-items-center btn-outline-success" href="{{ route('admin.managers.create') }}">Tạo mới</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="sticky-top bg-gradient-primary ">
                            <tr>
                                <th class="text text-white">Quản Trị Viên</th>
                                <th class="text text-white">Email</th>
                                <th class="text text-white">Số Điện Thoại</th>
                                <th class="text text-white">Giới Tính</th>
                                <th class="text text-white">Ngày Sinh</th>
                                <th class="text text-white">Địa Chỉ</th>
                                <th class="text text-white"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($managers as $manager)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="mr-4">
                                                <img src="{{ assetStorage($manager->avatar->path) }}" alt="avatar">
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
                                            <div class="mr-3">
                                                <a href="{{ route('admin.managers.edit', $manager->id) }}"
                                                   class="btn btn-sm btn-outline-warning" data-toggle="tooltip"
                                                   data-placement="top"
                                                   title="Sửa Thông Tin"><i class="mdi mdi-grease-pencil"></i></a>
                                            </div>
                                            <div>
                                                <form method="post"
                                                      action="{{ route('admin.managers.destroy', $manager->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            data-toggle="tooltip" data-placement="top"
                                                            title="Xoá Thông Tin">
                                                        <i class="mdi mdi-delete"></i>
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
                    <div class="mt-2 d-flex justify-content-end">
                        {{ $managers->appends(['keyword' => $keyword])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')

@endsection