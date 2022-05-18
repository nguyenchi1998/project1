@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Đăng Ký Tín Chỉ</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item active">
            <a href="{{ route('admin.schedules.classes.index') }}">Lớp Đăng Ký</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            Đăng Ký
        </li>
    </ol>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-lg-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="mb-2">
                    <div class="form-row">
                        <div class="col-4">
                            <div class="form-group">
                                <strong>Lớp</strong>:<span> {{ $class->name }}</span>
                            </div>
                            <div class="form-group">
                                <strong>Kỳ Hiện Tại</strong>:<span> {{ $class->semester }}</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <strong>Chuyên Ngành:</strong> {{ $class->specialization->name }}
                            </div>
                            <div class="form-group">
                                <strong>Viện:</strong> {{ $class->specialization->department->name }}
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <strong>Số Tín Tối Đa Cho Phép</strong>:<span id="max_credit_register"> {{ config('credit.max_register') }}</span>
                            </div>
                            <div class="form-group">
                                <strong>Số Tín Đăng Kí Hiện Tại:</strong> <span id="total_credit">{{ $totalRegisterSubjects }}</span> <span class="d-none text text-danger" id="warning">Quá số tín chỉ cho phép</span>
                            </div>
                        </div>
                    </div>
                </div>
                {{ Form::open(['url' => route('admin.schedules.classes.store', $class->id), 'method' => 'POST']) }}
                @csrf
                <div class="table-responsive mb-3 table-scroll">
                    <table class="table table-bordered table-hover" id="subjects">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Viện Khoa Phụ Trách</th>
                                <th>Số Tín Chỉ</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subjects as $subject)
                            <tr>
                                <td>
                                    {{ $subject->name }}
                                </td>
                                <td>
                                    {{ $subject->department->name }}
                                </td>
                                <td>
                                    {{ $subject->credit }}
                                </td>
                                <td width="50">
                                    {{ Form::checkbox('subjectIds[]', $subject->id, in_array($subject->id, $classSubjectIds), ['class' => 'form-control'])  }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class=" mt-3 d-flex justify-content-end">
                    @if(count($subjects))
                    {{ Form::submit('Đăng Ký', ['id' => 'submit', 'class' => 'btn btn-outline-secondary']) }}
                    @endif
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection