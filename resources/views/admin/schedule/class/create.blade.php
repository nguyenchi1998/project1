@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Quản Lý Tín Chỉ</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item active">
            <a href="{{ route('admin.schedules.class.index') }}">Danh Sách Lớp Học</a>
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
                <div class="mb-2">
                    <div class="form-row">
                        <div class="col-6">
                            <div class="form-group">
                                <strong>Lớp</strong>:<span> {{ $class->name }}</span>
                            </div>
                            <div class="form-group">
                                <strong>Kì Tiếp Theo</strong>:<span> {{ $class->semester  + 1 }}</span>
                            </div>
                            <div class="form-group">
                                <strong>Số Tín Tối Đa</strong>:<span id="max_credit_register"> {{ config('config.max_credit_register') }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <strong>Chuyên Ngành:</strong> {{ $class->specialization->name }}
                            </div>
                            <div class="form-group">
                                <strong>Số Tín Đăng Kí:</strong> <span id="total_credit">0</span> <span class="d-none text text-danger" id="warning">Quá số tín chỉ cho phép</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive mb-3">
                    <table class="table table-bordered table-hover" id="subjects">
                        <thead>
                            <tr>
                                <th>Môn Học</th>
                                <th>Số Tín Chỉ</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subjects as $subject)
                            <tr>
                                <td>
                                    {{ $subject->name }}
                                    {{ Form::text('subject_id', $subject->id, ['hidden' => true]) }}
                                </td>
                                <td>
                                    {{ $subject->credit }}
                                    {{ Form::text('credit[]', $subject->credit, ['hidden' => true]) }}
                                </td>
                                <td class="text-center">
                                    {{ Form::checkbox('checked', $subject->id, false, ['class' => 'selectSubject'])  }}
                                </td>
                            </tr>
                            @endforeach
                            <tr align="right">
                                <td colspan="3">{{ Form::submit('Register', ['id' => 'submit', 'class' => 'btn btn-sm btn-outline-info']) }}</td>
                            </tr>
                        </tbody>
                    </table>
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
            let selected = $(tr).find('' + 'td:eq(2)').find('input').is(':checked');
            if (selected)
                subjects = [
                    ...subjects,
                    {
                        subject_id
                    }
                ]
        });
        $.ajax({
            url: "{{ route('admin.schedules.class.registerSchedule', $class->id) }}",
            method: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                subjects,
            },
            success: function() {
{{--                window.location.href = "{{ route('admin.schedules.class.index') }}"--}}
            },
            error: function() {
                alert('Error');
            }
        });
    });

    $(document).on('change', '.selectSubject', function(event) {
        event.preventDefault();
        let total = $('#subjects').find('tbody tr:not(:last-child)').filter(function(index, tr) {
            return $(tr).find('' + 'td:eq(2)').find('input').is(':checked');
        }).toArray().reduce(function(total, tr) {
            return total += Number($(tr).find('' + 'td:eq(1)').find('input').val());
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