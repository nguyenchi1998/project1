@extends('layouts.teacher')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Quản Lý Lịch Giảng Dạy</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('teacher.home') }}">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item active">Danh Sách Lịch Giảng Dạy</li>
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
                                Lớp Học: {{ $schedule->name }}
                            </div>
                            <div class="form-group">
                                Môn Học: {{ $schedule->subject->name }}
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                Số  Sinh Viên: {{ count($scheduleDetails) }}
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
                <div class="table-responsive mb-3 table-scroll">
                    <table class="table table-bordered table-hover" id="mark">
                        <thead>
                            <tr>
                                <th>Sinh Viên</th>
                                <th>Điểm Chuyên Cần</th>
                                <th>Điểm Giữa Kì</th>
                                <th>Điểm Cuối Kì</th>
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
                        <button class="btn btn-sm btn-outline-success" id="submit">Xác Nhận</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    jQuery(document).on('click', '#submit', function() {
        let students = [];
        jQuery('#mark').find('tbody tr').each(function(index, tr) {
            let student = {};
            jQuery(tr).find('' + 'td').find('input').each(function(index, input) {
                student = {
                    ...student,
                    [jQuery(input).attr('name')]: jQuery(input).val(),
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
            success: function() {
                window.location.href = "{{ route('teacher.schedules.index') }}"
            },
            error: function() {
                alert('Error');
            }
        })
    })
</script>
@endsection