@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Đăng Ký Tín Chỉ Cho Student</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item active">Đăng Ký Tín Chỉ Cho Student</li>
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
                        <form action="{{ route('admin.schedules.students.index') }}" class="form-inline">
                            <input type="search" name="keyword" value="{{ $keyword }}" class="form-control  mr-2" placeholder="Keyword">
                            {{ Form::select('semester-filter', $semesters, $filterSemester, ['class' => 'form-control  mr-2', 'placeholder' => 'Tất Cả Kỳ Học']) }}
                            {{ Form::select('grade-filter', $grades, $filterGrade , ['class' => 'form-control mr-2', 'placeholder' => 'Tất Cả Khóa']) }}
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
                                <th>Student</th>
                                <th>Khóa</th>
                                <th>Kỳ Hiện Tại</th>
                                <th>Chuyên Ngành</th>
                                <th>Môn Đăng Ký</th>
                                <th>Trạng Thái Đăng Ký</th>
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
                                    {{ $student->grade->name }}
                                </td>
                                <td>
                                    {{ $student->class->semester }}
                                </td>
                                <td>
                                    {{ $student->class->specialization->name }}
                                </td>
                                <td>
                                    {{ count($student->scheduleDetails) }}
                                </td>
                                <td style="width: 180px;">
                                    <form action="{{ route('admin.schedules.students.creditStatus', $student->id) }}" method="post">
                                        @csrf
                                        <select name="can_register_credit" class="form-control" onchange="this.form.submit()">
                                            <option value="{{ config('credit.register.open') }}" @if($student->can_register_credit ==config('credit.register.open')) selected @endif>Mở</option>
                                            <option value="{{ config('credit.register.close') }}" @if($student->can_register_credit ==config('credit.register.close')) selected @endif>Đóng</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="text-center" style="width: 180px;">
                                    <a href="{{ route('admin.schedules.students.show', $student->id) }}" class="btn btn-outline-success">
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
                    {{ $students->appends(['semester-filter' => $filterSemester, 'grade-filter' => $filterGrade, 'keyword' => $keyword])->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection