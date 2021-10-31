@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Quản Lý Tín Chỉ</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item active">Danh Sách Sinh Viên</li>
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
                        <form action="{{ route('admin.schedules.students.index') }}">
                            <div class="d-flex justify-content-between">
                                <input type="search" name="keyword" value="{{ $keyword }}" class="form-control form-control-sm mr-2" placeholder="Từ Khoá">
                                {{ Form::select('semester', $semesters, $semester ?? null, ['class' => 'form-control form-control-sm mr-2', 'placeholder' => 'Chọn Kì Học', 'onchange' => 'this.form.submit()']) }}
                                <button class="ml-2 btn-sm btn btn-outline-info" type="submit">
                                    <i class="fa fa-edit"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive table-scroll">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>LỚp Học</th>
                                <th>Số Sinh Viên</th>
                                <th>Kì Hiện Tại</th>
                                <th>Chuyên Ngành</th>
                                <th>Số Môn Đăng Ký</th>
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
                                    {{ $class->specialization->name }}
                                </td>
                                <td>
                                    {{ count($class->schedules) }}
                                </td>
                                <td class="text-center">
                                    @if($class['can_register'])
                                    <a href="{{ route('admin.schedules.class.registerScheduleShow', $class->id) }}" class="btn btn-sm btn-outline-success" data-toggle="tooltip" data-placement="top" title="Đăng Ký Tín Chỉ">
                                        <i class="fa fa-book"></i>
                                    </a>
                                    @endif
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
                    {{ $classes->appends(['grade-filter' => $filterGrade, 'keyword' => $keyword])->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection