@extends('layouts.manager')
@section('title')
    Quản Lý Sinh Viên
@endsection
@section('breadcrumb')
    <div class="page-header">
        <h3 class="page-title">Danh Sách Sinh Viên Đăng Ký Tín Chỉ</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    Danh Sách Sinh Viên Đăng Ký Tín Chỉ
                </li>
            </ol>
        </nav>
    </div>@endsection
@section('main')
    <div class="row">
        <div class="col-lg-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-4 justify-content-between">
                        <div class="w-15">
                            <form action="{{ route('admin.schedules.credits.students.index') }}">
                                <div class="d-flex justify-content-between">
                                    <input type="search" name="keyword" value="{{ $keyword }}" class="form-control mr-2"
                                           placeholder="Từ Khoá">
                                    {{ Form::select('semester', $semesters, $semester ?? null, ['class' => 'form-control mr-2', 'placeholder' => 'Chọn Kì Học', 'onchange' => 'this.form.submit()']) }}
                                    {{ Form::select('grade-filter', $grades, $filterGrade ?? null, ['class' => 'form-control', 'placeholder' => 'Tất Cả Khóa', 'onchange' => 'this.form.submit()']) }}
                                    <button class="ml-2 btn btn-outline-success" type="submit">
                                        <i class="mdi mdi-grease-pencil"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Sinh Viên</th>
                                <th>Khoá</th>
                                <th>Lớp</th>
                                <th>Kỳ Hiện Tại</th>
                                <th>Số Môn Đã Đăng Ký</th>
                                <th>Chuyên Ngành</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($students as $student)
                                <tr>
                                    <td>
                                        {{ $student->name }}
                                    </td>
                                    <td>
                                        {{ $student->grade->name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $student->class->name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $student->class->semester ?? '' }}
                                    </td>
                                    <td>
                                        {{ count($student->scheduleDetails) }}
                                    </td>
                                    <td>
                                        {{ $student->class->specialization->name }}
                                    </td>
                                    <td width="100">
                                        <div class="d-flex justify-content-between">
                                            <div class="mr-3">
                                                <a href="{{ route('admin.schedules.credits.students.registerScheduleShow', $student->id) }}"
                                                   class="btn btn-sm btn-outline-warning" data-toggle="tooltip"
                                                   data-placement="top" title="Đăng Ký Tín Chỉ">
                                                    <i class="mdi mdi-book-open-page-variant"></i>
                                                </a>
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
                        {{ $students->appends(['grade-filter' => $filterGrade, 'keyword' => $keyword])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection