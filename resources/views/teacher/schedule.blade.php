@extends('layouts.teacher')
@section('title')
Manager Schedules
@endsection
@section('main')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Manager Schedules</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('teacher.home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    Manager Schedules
                </li>
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
        <div class="col-lg-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-4">
                        <div class="w-25">
                            <form action="">
                                {{ Form::select('status', $states, $status ?? null, ['class' => 'form-control', 'placeholder' => 'Choose semester', 'onchange' => 'this.form.submit()']) }}
                            </form>
                        </div>
                    </div>
                    @forelse($schedules as $key => $schedule)
                    <div class="text text-uppercase">
                        <h4>{{ getNameSchedule($key) }}</h4>
                    </div>
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Class</th>
                                    <th>Start time</th>
                                    <th>Students</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($schedule as $detail)
                                <tr>
                                    <td>
                                        {{ $detail->subject->name }}
                                    </td>
                                    <td style="width: 150px">
                                        {{ $detail->start_time }}
                                    </td>
                                    <td style="width: 150px">
                                        {{ count($detail->scheduleDetails) }}
                                    </td>
                                    <td style="width: 150px">
                                        <div class="d-flex justify-content-center align-items-center">
                                            @if($detail->status == config('common.status.schedule.in_progress'))
                                            <a class="btn btn-sm btn-success" href="{{ route('teacher.schedules.attendanceShow', $detail->id) }}">Attendance</a>
                                            @elseif($detail->status == config('common.status.schedule.marking'))
                                            <a class="btn btn-sm btn-primary" href="{{ route('teacher.schedules.markShow', $detail->id) }}">Mark</a>
                                            @if(chexkFinishMark($detail->scheduleDetails->toArray()))
                                            <div class="ml-1">
                                                <a class="btn btn-sm btn-success" href="{{ route('teacher.schedules.markShow', $detail->id) }}">Finish</a></div>
                                            @endif()
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @empty
                    <div class="pt-3 d-flex justify-content-center">
                        <h4>Empty Data</h4>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection @section('script') @endsection