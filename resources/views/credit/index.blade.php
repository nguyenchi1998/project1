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
                        <div class="d-flex mb-4 justify-content-between">
                            <div class="w-15">
{{--                                <form action="">--}}
{{--                                    {{ Form::select('semester', $semester, $semesterFilter, ['class' =>'form-control', 'onchange' => 'this.form.submit()']) }}--}}
{{--                                </form>--}}
                            </div>
                            <a class="btn btn-primary" href="{{ route('credits.create') }}">Register</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Class</th>
                                    <th>Start time</th>
                                    <th>Subject</th>
                                    <th>Credit</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($credits as $credit)
                                    <tr>
                                        <td>
                                            {{ $credit->schedule ?? '' }}
                                        </td>
                                        <td>
                                            {{ $credit->schedule->start_time ?? '' }}
                                        </td>
                                        <td>
                                            {{ $credit->subject->name }}
                                        </td>
                                        <td>
                                            {{ $credit->subject->credit }}
                                        </td>
                                        <td>
                                            {{ !isset($credit->schedule) ? 'Progress' : 'Success'  }}
                                        </td>
                                        <td width="100">
                                            <div class="d-flex justify-content-between">
                                                {{ Form::open(['url' => route('credits.destroy', $credit->id)])}}
                                                    {{ Form::submit('Cancel', ['class' => 'btn btn-sm btn-danger']) }}
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