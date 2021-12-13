@extends('layouts.student')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Danh Sách Điểm Thi</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item active">Danh Sách Điểm Thi</li>
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
                                Name: {{ $student->name }}
                            </div>
                            <div class="form-group">
                                Class: {{ $student->class->name }}
                            </div>
                            <div class="form-group">
                                Register Credit: {{ $student->grade->can_register_credit ? 'Open' : 'Close' }}
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                Specialization: {{ $student->class->specialization->name }}
                            </div>
                            <div class="form-group">
                                Grade: {{ $student->grade->name }}
                            </div>
                            <div class="form-group">
                                Semester: {{ $student->class->semester }}
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
                                <th>Subject</th>
                                <th>Credit</th>
                                <th>Force</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subjects as $subject)
                            <tr>
                                <td>
                                    {{ $subject->name }}
                                </td>
                                <td>
                                    {{ $subject->credit }}
                                </td>
                                <td>
                                    {{ $subject->force ? 'Force' : 'Custom' }}
                                </td>
                                <td width="100">
                                    <div class="text-center">
                                        {{ Form::checkbox('subject_id[]', $subject->id, (boolean)$subject->force, ['onclick' => (boolean)$subject->force ? 'return false' : 'return true'])  }}
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 d-flex justify-content-end">
                    {{ Form::submit('Đăng Ký', ['id' => 'submit', 'class' => 'btn btn-outline-secondary']) }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection