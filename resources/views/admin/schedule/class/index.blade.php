@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Đăng Ký Tín Chỉ Cho Lớp Quản Lý</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.home') }}">Bảng Điều Khiển</a>
        </li>
        <li class="breadcrumb-item active">Đăng Ký Tín Chỉ Cho Lớp Quản Lý</li>
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
                        <form action="{{ route('admin.schedules.classes.index') }}" class="form-inline">
                            <input type="search" name="keyword" value="{{ $keyword }}" class="form-control  mr-2" placeholder="Từ Khoá">
                            {{ Form::select('semester-filter', $semesters, $semesterFilter, [
                                    'class' => 'form-control  mr-2',
                                    'placeholder' => 'Tất Cả Kỳ Học',
                                ]) }}
                            {{ Form::select('specialization-filter', $specializations, $specializationFilter, [
                                    'class' => 'form-control mr-2',
                                    'placeholder' => 'Tất Cả Chuyên Ngành',
                                ]) }}
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="table-responsive table-scroll">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Lớp Học</th>
                                <th>Sinh Viên</th>
                                <th>Kỳ Hiện Tại</th>
                                <th>Chuyên Ngành</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($classes as $class)
                            <tr>
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
                                    <span>
                                        {{ $class->specialization->name }}
                                    </span>
                                </td>
                                <td class="text-center" style="width: 200px">
                                    <a href="{{ route('admin.schedules.classes.show', $class->id) }}" class="btn btn-outline-success">
                                        Danh Sách Tín Chỉ
                                    </a>
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
                    {{ $classes->appends([
                                'specialization-filter' => $specializationFilter,
                                'semester-filter' => $semesterFilter,
                                'keyword' => $keyword,
                            ])->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection