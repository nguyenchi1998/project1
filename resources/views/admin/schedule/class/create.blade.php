@extends('layouts.manager')
@section('title')
    Quản Lý Tín Chỉ
@endsection
@section('breadcrumb')
    <div class="page-header">
        <h3 class="page-title">Đăng Ký</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.schedules.index') }}">Danh Sách Tín Chỉ</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    Đăng Ký
                </li>
            </ol>
        </nav>
    </div>
@endsection
@section('main')
    <div class="row">
        <div class="col-lg-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="mb-5">
                        <div class="form-row">
                            <div class="col-6">
                                <div class="form-group">
                                    <strong>Lớp Học</strong>:<span> {{ $class->name }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <strong>Chuyên Ngành:</strong> {{ $class->specialization->name }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Môn Học</th>
                                <th>Số Tín Chỉ</th>
                                <th>Thời Gian Bắt Đầu</th>
                                <th>Giảng Viên Dạy</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($unCreditSubjects as $subject)
                                {{ Form::open(['url' => route('admin.schedules.register', $id), 'method' => 'post']) }}
                                <tr>
                                    <td>
                                        {{ $subject->name }}
                                    </td>
                                    <td>
                                        {{ $subject->credit }}
                                    </td>
                                    <td>
                                        {{ Form::date('start_time', null, ['class' => 'form-control form-control-sm', 'required' => true]) }}
                                    </td>
                                    <td>
                                        {{ Form::select('teacher_id', $subject->teachers->pluck('name', 'id')->toArray(), null, ['placeholder'=> 'Chọn Giảng Viên', 'class' => 'form-control form-control-sm']) }}
                                    </td>
                                    <td style="width: 100px">
                                        <div class="d-flex justify-content-between">
                                            <div class="mr-3">
                                                {{ Form::text('class_id', $id, ['hidden' => true])}}
                                                {{ Form::text('subject_id', $subject->id, ['hidden' => true])}}
                                                {{ Form::submit('Đăng Ký', ['class' => 'btn btn-success']) }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                {{ Form::close() }}
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection @section('script') @endsection