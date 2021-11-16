@extends('layouts.student')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Danh Sách Tín Chỉ</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item"><a href="{{ route('credits.index') }}">Danh Sách Tín Chỉ</a></li>
        <li class="breadcrumb-item active">Đăng Ký Tín Chỉ</li>
    </ol>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-lg-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="mt-6">
                    {{ Form::open(['url' =>route('admin.classes.store') , 'method' => 'POST', 'class' => "forms-sample" ]) }}
                    <div class="form-row">
                        <div class="col-6">
                            <div class="form-group">
                                <strong>Sinh Viên: </strong>{{ $student->name }}
                            </div>
                            <div class="form-group">
                                <strong>Lớp: </strong>{{ $student->class->name }}
                            </div>
                            <div class="form-group">
                                <strong>Trạng Thái Đăng Kí: </strong>{{ $student->grade->can_register_credit ? 'Mở' : 'Đóng' }}
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <strong>Chuyên Ngành: </strong>{{ $student->class->specialization->name }}
                            </div>
                            <div class="form-group">
                                <strong>Niên Khóa: </strong> {{ $student->grade->name }}
                            </div>
                            <div class="form-group">
                                <strong>Kỳ Hiện Tại: </strong>{{ $student->class->semester }}
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
                {{ Form::open(['url' => route('credits.store'), 'method' => 'post']) }}
                <div class="table-responsive table-scroll">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Môn Học</th>
                                <th>Lớp Học Sẵn Có</th>
                                <th>Kỳ Học</th>
                                <th>Số Tín Chỉ</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subjects as $subject)
                            <tr>
                                <td>
                                    {{ $subject->name }}
                                    @if($subject->pivot->force )<span class="badge badge-danger">Bắt Buộc</span> @endif
                                </td>
                                <td>
                                    {{ $subject->schedules[0]->name ?? 'Chưa có lớp' }}
                                </td>
                                <td>
                                    {{ $subject->pivot->semester ?? 'Tự Do' }}
                                </td>
                                <td>
                                    {{ $subject->credit }}
                                </td>
                                <td width="100">
                                    <div class="text-center">
                                        {{ Form::checkbox('subject_id[]', $subject->id, in_array($subject->id, $scheduleDetails), ['onclick' => (boolean)$subject->force ? 'return false' : 'return true'])  }}
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 d-flex justify-content-end">
                    {{ Form::submit('Đăng Ký', ['id' => 'submit', 'class' => 'btn btn-sm btn-outline-info']) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection