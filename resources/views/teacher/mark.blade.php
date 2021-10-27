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
                    <li class="breadcrumb-item"><a href="{{ route('teacher.schedules.index') }}">Manager Schedules</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Mark
                    </li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="mt-6">
                            {{ Form::open(['url' =>route('admin.classes.store') , 'method' => 'POST', 'class' => "forms-sample" ]) }}
                            <div class="form-row">
                                <div class="col-6">
                                    <div class="form-group">
                                        Name: {{ $schedule->name }}
                                    </div>
                                    <div class="form-group">
                                        Subject: {{ $schedule->subject->name }}
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        Students: {{ count($scheduleDetails) }}
                                    </div>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                        <div class="table-responsive mb-3">
                            <table class="table table-bordered" id="mark">
                                <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Activity mark</th>
                                    <th>Middle mark</th>
                                    <th>Final mark</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($scheduleDetails as $student)
                                    <tr>
                                        <td>
                                            {{ $student->student->name }}
                                            {{ Form::text('student_id', $student->id, ['hidden' => true, 'class' => 'form-control']) }}
                                        </td>
                                        <td style="width: 200px">
                                            {{ Form::number('activity_mark', $student->activity_mark, ['class' => 'form-control', 'min' => 0, 'max' =>10]) }}
                                        </td>
                                        <td style="width: 200px">
                                            {{ Form::number('middle_mark', $student->middle_mark, ['class' => 'form-control', 'min' => 0, 'max' =>10]) }}
                                        </td>
                                        <td style="width: 200px">
                                            {{ Form::number('final_mark', $student->final_mark, ['class' => 'form-control', 'min' => 0, 'max' =>10]) }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="mt-3 d-flex justify-content-end">
                                <button class="btn btn-sm btn-outline-success" id="submit">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).on('click', '#submit', function () {
            let students = [];
            $('#mark').find('tbody tr').each(function (index, tr) {
                let student = {};
                $(tr).find('' + 'td').find('input').each(function (index, input) {
                    student = {
                        ...student,
                        [$(input).attr('name')]: $(input).val(),
                    }
                })
                students.push(student);
            });
            $.ajax({
                url: "{{ route('teacher.schedules.mark', $schedule->id) }}",
                method: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    students,
                },
                success: function () {
                    window.location.href = "{{ route('teacher.schedules.index') }}"
                },
                error: function () {
                    alert('Error');
                }
            })
        })
    </script>
@endsection