@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Danh Sách Lớp Học</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item active">Danh Sách Lớp Học</li>
    </ol>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-lg-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex mb-3 justify-content-between">
                    <div class="">
                        <form action="{{ route('admin.classes.index') }}" class="form-inline">
                            <input type="search" name="keyword" value="{{ $keyword }}" class="form-control  mr-2" placeholder="Từ Khoá">
                            {{ Form::select('specializaiton-filter', $specializations, $filterSpecialization, ['class' => 'form-control mr-2', 'placeholder' => 'Tất cả Viện']) }}
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    </div>
                    <form action="{{ route('admin.classes.next_semester') }}" method="post">
                        @csrf
                        <button class="btn btn-outline-info" type="submit">
                            Chuyển Kỳ Mới
                        </button>
                    </form>
                    @if($showCreateClassBtn)
                    <a class="btn Tìm Kiếmd-flex align-items-center btn-outline-success" href="{{ route('admin.classes.create') }}"><i class="fa fa-plus"></i></a>
                    @endif
                </div>
                <div class="table-responsive table-scroll">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Mã</th>
                                <th>Lớp Học</th>
                                <th>Số Sinh Viên</th>
                                <th>Kỳ Hiện Tại</th>
                                <th>Chuyên Ngành</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($classes as $class)
                            <tr>
                                <td>
                                    {{ $class->code }}
                                </td>
                                <td>
                                    {{ $class->name }}
                                </td>
                                <td>
                                    {{ count($class->students) }}
                                </td>
                                <td>
                                    {{ $class->semester }}
                                </td>
                                <td>
                                    <span class="{{ modelTrash($class->specialization) }}">
                                        {{ $class->specialization->name }}
                                    </span>
                                </td>
                                <td style="width: 100px">
                                    <div class="d-flex justify-content-between">
                                        <div class="mr-2">
                                            <a href="{{ route('admin.classes.edit', $class->id) }}" class="btn btn-outline-warning">
                                                Sửa
                                            </a>
                                        </div>
                                        <div>
                                            <form action="{{ route('admin.classes.destroy', $class->id) }}">
                                                <button type="submit" class="btn btn-outline-danger"><i class="fa fa-trash"></i></button>
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
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection