@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Danh Sách Môn Học</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item active">
            <a href="{{ route('admin.schedules.students.index') }}">Đăng Ký Tín Chỉ Cho Sinh Viên</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            Danh Sách Môn Học
        </li>
    </ol>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-lg-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <div class="form-row">
                        <div class="col-5">
                            <div class="mb-3">
                                <strong>Sinh Viên</strong>:<span> {{ $student->name }}</span>
                            </div>
                            <div>
                                <strong>Niên Khóa</strong>:<span> {{ $student->grade->name }}</span>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="mb-2">
                                <strong>Chuyên Ngành:</strong> {{ $student->class->specialization->name }}
                            </div>
                            <div>
                                <strong>Niên Khóa</strong>:<span> {{ $student->class->semester }}</span>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="mb-3">
                                <strong>Số Tín Tối Đa</strong>:<span id="max_credit_register"> {{ config('credit.max_register') }}</span>
                            </div>
                            <div>
                                <strong>Tổng số tín:</strong> <span id="total_credit">{{ $totalCreditRegisted }}</span> <span class="d-none text text-danger" id="warning">Quá số tín chỉ cho phép</span>
                            </div>
                        </div>
                    </div>
                </div>
                {{ Form::open(['url' => route('admin.schedules.students.store', $student->id), 'method' => 'post']) }}
                @csrf
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="subjects">
                        <thead>
                            <tr>
                                <th>Môn Học</th>
                                <th>Số Tín Chỉ</th>
                                <th>Kỳ Học</th>
                                <th>Lớp Tín Chỉ</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subjects as $subject)
                            <tr>
                                <td>
                                    {{ $subject->name }}
                                    @if($subject->force)<span class="badge badge-danger">Bắt Buộc</span> @endif
                                </td>
                                <td>
                                    {{ $subject->credit }}
                                </td>
                                <td>
                                    {{ $subject->semester ?? 'Tự Do' }}
                                </td>
                                <td>
                                    {{ ($subject->hasClass ? 'Đã' : 'Chưa') . ' có lớp' }}
                                </td>
                                <td width="50">
                                    {{ Form::checkbox('subjectIds[]', $subject->id, $subject->isSelected, ['class' => 'form-control'])  }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class=" mt-3 d-flex justify-content-end">
                    {{ Form::submit('Đăng Ký', ['id' => 'submit', 'class' => 'btn btn-outline-secondary']) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection