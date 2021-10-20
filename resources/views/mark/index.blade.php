@extends('layouts.student')
@section('title')
    Student Marks
@endsection
@section('main')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Manager Credits</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Manager Credits</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex mb-4 justify-content-between">
                            <div class="w-15">
                                <form action="">
                                    {{ Form::select('semester', $semester, $semesterFilter, ['placeholder' => 'Choose Semester','class' =>'form-control', 'onchange' => 'this.form.submit()']) }}
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>Acticity Mark</th>
                                    <th>Middle Mark</th>
                                    <th>Final Mark</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($subjects as $subject)
                                    <tr>
                                        <td>
                                            {{ $subject->subject }}
                                        </td>
                                        <td>
                                            {{ $subject->activity_mark }}
                                        </td>
                                        <td>
                                            {{ $subject->middle_mark }}
                                        </td>
                                        <td>
                                            {{ $subject->final_mark }}
                                        </td>
                                        <td>
                                            {{ $subject->status }}
                                        </td>
                                        <td width="100">
                                            <div class="d-flex justify-content-between">
                                                {{ Form::open(['url' => route('credits.destroy', $credit->id)])}}
                                                    {{ Form::submit('Relearn', ['class' => 'btn btn-sm btn-danger']) }}
                                                {{ Form::close() }}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection