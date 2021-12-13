@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Đăng Ký Tín Chỉ</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item active">
            <a href="{{ route('admin.schedules.students.index') }}">Danh Sách Sinh Viên</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            Đăng Ký Tín Chỉ
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
                        <div class="col-5">
                            <div class="mb-3">
                                <strong>Sinh Viên</strong>:<span> {{ $student->name }}</span>
                            </div>
                            <div>
                                <strong>Niên Khóa</strong>:<span> {{ $student->grade->name }}</span>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="mb-2">
                                <strong>Chuyên Ngành:</strong> {{ $student->class->specialization->name }}
                            </div>
                            <div class="d-flex justify-content-start align-items-center">
                                <strong>Kỳ Học</strong>:
                                <div class="ml-1">
                                    <form action="">
                                        {{ Form::select('semester-filter', $semesters, $semesterFilter, ['class' => 'form-control', 'onchange' => 'this.form.submit()']) }}
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="mb-3">
                                <strong>Số Tín Tối Đa</strong>:<span id="max_credit_register"> {{ config('credit.max_register') }}</span>
                            </div>
                            <div>
                                <strong>Tổng số tín:</strong> <span id="total_credit">{{ $totalCreditRegisted }}</span> <span class="d-none text text-danger" id="warning">Quá số tín chỉ cho phép</span>
                            </div>
                        </div>
                    </div>
                </div>
                {{ Form::open(['url' => route('admin.schedules.register', $student->id), 'method' => 'post']) }}
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="subjects">
                        <thead>
                            <tr>
                                <th>Môn Học</th>
                                <th>Kỳ Học</th>
                                <th>Lớp Tín Chỉ</th>
                                <th>Số Sinh Viên Đã Đăng Ký</th>
                                <th>Số Tín Chỉ</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subjects as $subject)
                            <tr>
                                <td>
                                    {{ $subject->subject->name }}
                                    @if($subject->force)<span class="badge badge-danger">Bắt Buộc</span> @endif
                                    {{ Form::text('subject_id', $subject->subject_id, ['hidden' => true]) }}

                                </td>
                                <td>
                                    {{ $subject->semester ?? 'Tự Do' }}
                                    {{ Form::text('semseter', $student->class->semester, ['hidden' => true]) }}
                                    {{ Form::text('specialization_id', $subject->specialization_id, ['hidden' => true]) }}
                                </td>
                                <td>
                                    {{ ($subject->hasCreditClass ? 'Đã' : 'Chưa') . ' có lớp' }}
                                </td>
                                <td>
                                    {{ 0 }}
                                </td>
                                <td>
                                    {{ $subject->credit }}
                                    {{ Form::text('credit', $subject->credit, ['hidden' => true]) }}
                                </td>
                                <td class="text-center">
                                    {{ Form::checkbox('checked', $subject->id, $subject->isSelected, ['class' => 'selectSubject'])  }}
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
<script>
    jQuery(document).on('click', '#submit', function(event) {
        event.preventDefault();
        let subjects = [];
        jQuery('#subjects').find('tbody tr:not(:last-child)').each(function(index, tr) {
            const subject_id = jQuery(tr).find('' + 'td:eq(0)').find('input').val();
            const semester = jQuery(tr).find('' + 'td:eq(1)').find('input:eq(0)').val();
            const specialization_id = jQuery(tr).find('' + 'td:eq(1)').find('input:eq(1)').val();
            const selected = jQuery(tr).find('' + 'td:eq(5)').find('input').is(':checked');
            if (selected)
                subjects = [
                    ...subjects,
                    {
                        subject_id,
                        semester,
                        specialization_id
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
                    window.location.href = "{{ route('admin.schedules.students.registerScheduleShow', $student->id) }}"
                },
                error: function() {
                    alert('Error');
                }
            })
        else {
            alert('Bạn chưa chọn môn học nào')
        }
    });

    jQuery(document).on('change', '.selectSubject', function(event) {
        event.preventDefault();
        let total = jQuery('#subjects').find('tbody tr').filter(function(index, tr) {
                return jQuery(tr).find('' + 'td:eq(5)').find('input').is(':checked');
            })
            .toArray()
            .reduce(function(total, tr) {
                return total + Number(jQuery(tr).find('' + 'td:eq(4)').find('input').val());
            }, 0);
        jQuery('#total_credit').text(total)
        let maxCreditRegisterCurrent = parseInt(jQuery('#max_credit_register').text(), 10);
        if (total > maxCreditRegisterCurrent) {
            jQuery('#warning').removeClass('d-none')

        } else {
            jQuery('#warning').addClass('d-none')
        }
        jQuery('#submit').attr('disabled', total > maxCreditRegisterCurrent)
    })
</script>
@endsection