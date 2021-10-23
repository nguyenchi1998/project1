@extends('layouts.student')
@section('title')
    Manager Credits
@endsection
@section('main')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Manager Credits</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Bảng Điều Khiển</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Manager Credits</li>
                </ol>
            </nav>
        </div>
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Warning!</strong> {{ $errors->first() }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
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
                                        Register Credit: {{ $student->can_register_credit ? 'Open' : 'Close' }}
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
                        <div class="table-responsive">
                            <table class="table table-bordered">
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
                                <tr>
                                    <td colspan="3"></td>
                                    <td>{{ Form::submit('Register', ['class' => 'btn btn-sm btn-info']) }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection