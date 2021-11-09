@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Quản Lý Tín Chỉ</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item active">
            <a href="{{ route('admin.schedules.students.index') }}">Danh Sách Sinh Viên</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            Đăng Ký
        </li>
    </ol>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-lg-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <div class="form-row">
                        <div class="col-4">
                            <div>
                                <strong>Sinh Viên</strong>:<span> {{ $student->name }}</span>
                            </div>
                            <div>
                                <strong>Niên Khóa</strong>:<span> {{ $student->grade->name }}</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div>
                                <strong>Chuyên Ngành:</strong> {{ $student->class->specialization->name }}
                            </div>
                            <div>
                                <strong>Kỳ Học:</strong> {{ $student->class->semester }}
                            </div>
                        </div>
                        <div class="col-4">
                            <div>
                                <strong>Số Tín Đăng Kí Hiện Tại:</strong> <span id="total_credit">{{ $totalCreditRegisted }}</span> <span class="d-none text text-danger" id="warning">Quá số tín chỉ cho phép</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive mb-3">
                    {{ Form::open(['url' => route('admin.schedules.register', $student->id), 'method' => 'post']) }}
                    <table class="table table-bordered table-hover" id="subjects">
                        <thead>
                            <tr>
                                <th>Môn Học</th>
                                <th>Kì Học</th>
                                <th>Lớp Tín Chỉ</th>
                                <th>Số sinh viên đã đăng kí</th>
                                <th>Số Tín Chỉ</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($specializationSubjects as $subject)
                            <tr>
                                <td>
                                    {{ $subject->name }}
                                    @if($subject->pivot->force )<span class="badge badge-danger">Bắt Buộc</span> @endif
                                    {{ Form::text('subject_id', $subject->id, ['hidden' => true]) }}
                                </td>
                                <td>
                                    {{ $subject->pivot->semester ?? 'Tự Do' }}
                                </td>
                                <td>
                                    {{ $subject['creditClass']['name'] ?? 'Chưa có lớp' }}
                                </td>
                                <td>
                                    @php
                                    $students = empty($subject['creditClass']) ? 0 : count($subject['creditClass']['schedule_details']);
                                    @endphp
                                    @if($students)
                                    {{ $student }}
                                    @endif
                                </td>
                                <td>
                                    {{ $subject->credit }}
                                    {{ Form::text('credit', $subject->credit, ['hidden' => true]) }}
                                </td>
                                <td class="text-center">
                                    {{ Form::checkbox('checked', $subject->id, $subject['force'] || in_array($subject->id, $scheduleDetails), ['onclick' => (boolean)$subject['force'] ? 'return false' : 'return true', 'class' => 'selectSubject'])  }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ Form::close() }}
                </div>
                <div class="d-flex justify-content-end">
                    {{ Form::submit('Đăng Kí', ['id' => 'submit', 'class' => 'btn btn-sm btn-outline-info']) }}
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
        $('#subjects').find('tbody tr').each(function(index, tr) {
            let subject_id = $(tr).find('' + 'td:eq(0)').find('input').val();
            let selected = $(tr).find('' + 'td:eq(3)').find('input').is(':checked');
            if (selected)
                subjects = [
                    ...subjects,
                    {
                        subject_id,
                    }
                ]
        });
        if (subjects.length)
            $.ajax({
                url: "{{ route('admin.schedules.students.registerSchedule', $student->id) }}",
                method: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    subjects,
                },
                success: function() {
                    window.location.href = "{{ route('admin.schedules.students.index') }}"
                },
                error: function() {
                    alert('Error');
                }
            })
        else {
            alert('Bạn chưa chọn môn học nào')
        };
    });

    $(document).on('change', '.selectSubject', function(event) {
        event.preventDefault();
        let total = $('#subjects').find('tbody tr').filter(function(index, tr) {
                return $(tr).find('' + 'td:eq(3)').find('input').is(':checked');
            })
            .toArray()
            .reduce(function(total, tr) {
                return total += Number($(tr).find('' + 'td:eq(2)').find('input').val());
            }, 0);
        $('#total_credit').text(total)
        if (total > parseInt($('#max_credit_register').text(), 10)) {
            $('#warning').removeClass('d-none')

        } else {
            $('#warning').addClass('d-none')
        }
        $('#submit').attr('disabled', total > parseInt($('#max_credit_register').text(), 10))
    })
</script>
@endsection