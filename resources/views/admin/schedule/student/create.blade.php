@extends('layouts.manager')
@section('title')
Quản Lý Tín Chỉ
@endsection
@section('breadcrumb')
<div class="page-header">
    <h3 class="page-title">Đăng Ký</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.home') }}">Bảng Điều Khiển</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.schedules.credits.students.index') }}">Danh Sách Sinh Viên Đăng Ký Tín Chỉ</a>
            </li>
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
                                <strong>Sinh Viên</strong>:<span> {{ $student->name }}</span>
                            </div>
                            <div class="form-group">
                                <strong>Niên Khóa</strong>:<span> {{ $student->grade->name }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <strong>Chuyên Ngành:</strong> {{ $student->class->specialization->name }}
                            </div>
                            <div class="form-group">
                                <strong>Kỳ Học:</strong> {{ $student->class->semester }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive mb-3">
                    {{ Form::open(['url' => route('admin.schedules.register', $student->id), 'method' => 'post']) }}
                    <table class="table table-bordered table-hover" id="subjects">
                        <thead class="sticky-top bg-gradient-primary ">
                            <tr>
                                <th class="text text-white">Môn Học</th>
                                <th class="text text-white">Số Tín Chỉ</th>
                                <th class="text text-white"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($specializationSubjects as $subject)
                            <tr>
                                <td>
                                    {{ $subject->name }}
                                    {{ Form::text('subject_id', $subject->id, ['hidden' => true]) }}
                                </td>
                                <td>
                                    {{ $subject->credit }}
                                    {{ Form::text('student_id', $student->id, ['hidden' => true]) }}
                                </td>
                                <td style="width: 100px">
                                    <div class="d-flex justify-content-between">
                                        <div class="mr-3">
                                            {{ Form::checkbox('checked', $subject->id, $subject->pivot->force || in_array($subject->id, $scheduleDetails), ['onclick' => (boolean)$subject->pivot->force ? 'return false' : 'return true'])  }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            <tr align="right">
                                <td colspan="3">{{ Form::submit('Register', ['id' => 'submit', 'class' => 'btn btn-sm btn-outline-info']) }}</td>
                            </tr>
                        </tbody>
                    </table>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).on('click', '#submit', function(event) {
        event.preventDefault();
        let subjects = [];
        $('#subjects').find('tbody tr:not(:last-child)').each(function(index, tr) {
            let subject_id = $(tr).find('' + 'td:eq(0)').find('input').val();
            let student_id = $(tr).find('' + 'td:eq(1)').find('input').val();
            let selected = $(tr).find('' + 'td:eq(2)').find('input').is(':checked');
            if (selected)
                subjects = [
                    ...subjects,
                    {
                        subject_id,
                        student_id,
                    }
                ]
        });
        $.ajax({
            url: "{{ route('admin.schedules.credits.students.registerSchedule', $student->id) }}",
            method: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                subjects,
            },
            success: function() {
                window.location.href = "{{ route('admin.schedules.credits.students.index') }}"
            },
            error: function() {
                alert('Error');
            }
        });
    })
</script>
@endsection