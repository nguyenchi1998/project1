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
                    <div class="d-flex mb-3 justify-content-between">
                        <div class="">
                            <form action="{{ route('admin.schedules.students.index') }}">
                                <div class="d-flex justify-content-between">
                                    <input type="search" name="keyword" value="{{ $keyword }}"
                                           class="form-control  mr-2" placeholder="Từ Khoá">
                                    {{ Form::select('semester', $semesters, $semester ?? null, ['class' => 'form-control  mr-2', 'placeholder' => 'Tất Cả Kỳ Học', 'onchange' => 'this.form.submit()']) }}
                                    {{ Form::select('grade-filter', $grades, $filterGrade ?? null, ['class' => 'form-control ', 'placeholder' => 'Tất Cả Khóa', 'onchange' => 'this.form.submit()']) }}
                                    <button class="ml-2 btn-sm btn btn-outline-info" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive table-scroll">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Sinh Viên</th>
                                <th>Khóa - Lớp - Kỳ Hiện Tại</th>
                                <th>Số Môn Đã Đăng Ký (Số Tín)</th>
                                <th>Chuyên Ngành</th>
                                <th>Trạng Thái</th>
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
                                        {{ $student->grade->name ?? '' }} - {{ $student->class->name ?? '' }}
                                        - {{ 'Kỳ ' . $student->class->semester ?? '' }}
                                    </td>

                                    <td>
                                        {{ count($student->scheduleDetails) }} ({{ $student['total_credit'] }})
                                    </td>
                                    <td>
                                        {{ $student->class->specialization->name }}
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.schedules.students.creditStatus', $student->id) }}"
                                              method="post">
                                            @csrf
                                            {{ Form::select('can_register_credit', $states, $student->can_register_credit, ['class' => 'form-control ', 'onchange' => 'this.form.submit()'])}}
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.schedules.students.registerScheduleShow', $student->id) }}"
                                           class="btn btn-sm btn-outline-success" data-toggle="tooltip"
                                           data-placement="top" title="Đăng Ký Tín Chỉ">
                                            <i class="fa fa-book"></i>
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
                        {{ $students->appends(['grade-filter' => $filterGrade, 'keyword' => $keyword])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection