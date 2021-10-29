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
                    <li class="breadcrumb-item"><a href="#">Bảng Điều Khiển</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Manager Credits</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex mb-4 justify-content-between">
                            <div class="">
                                <form action="">
                                    {{ Form::select('semester', $semester, $semesterFilter, ['placeholder' => 'Choose Semester','class' =>'form-control', 'onchange' => 'this.form.submit()']) }}
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="sticky-top bg-gradient-primary ">
                                <tr>
                                    <th class="text text-white">Subject</th>
                                    <th class="text text-white">Acticity Mark</th>
                                    <th class="text text-white">Middle Mark</th>
                                    <th class="text text-white">Final Mark</th>
                                    <th class="text text-white">Status</th>
                                    <th class="text text-white"></th>
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
                                                {{ Form::open(['url' => route('credits.destroy', $credit->id)]) }}
                                                    {{ Form::submit('Relearn', ['class' => 'btn btn-sm btn-outline-danger']) }}
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