@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Quản Lý Chuyên Ngành</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item"> <a href="#">Danh Sách Chuyên Ngành</a></li>
        <li class="breadcrumb-item active">Chọn Môn Giảng Dạy</li>
    </ol>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <div class="form-row">
                        <div class="col-6">
                            <div class="form-group">
                                Chuyên Ngành: {{ $specialization->name }}
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                Khoa Viện: {{ $specialization->department->name }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive table-scroll">
                    {{ Form::open(['url' => route('admin.specializations.choose_subject', $specialization->id) , 'method' => 'POST']) }}
                    @method('PUT')
                    <table class="table table-bordered" id="subjects">
                        <thead>
                            <tr>
                                <th>Môn Học</th>
                                <th>Kỳ Học</th>
                                <th>Số Tín Chỉ</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subjects as $key => $subject)
                            <tr>
                                <td>
                                    <div class="form-check form-check-info m-0" style="min-width: 400px">
                                        <label class="form-check-label">
                                            {{ Form::checkbox('subject_id', $subject->id, in_array($subject->id, $specializationSubject),  ['class'=>'form-check-input selectedSubject']) }}
                                            {{ $subject->name }}
                                            <i class="input-helper"></i>
                                        </label>
                                    </div>
                                </td>
                                <td style="width: 150px">
                                    {{ Form::input('number', 'semester', $subject['semester'] ?? null, ['class'=> 'form-control form-control-sm', 'disabled'=> true]) }}
                                </td>
                                <td style="width: 150px" class="text-center">
                                    {{ $subject->credit }}
                                </td>
                                <td style="width: 150px">
                                    <div class="form-check form-check-info m-0">
                                        <label class="form-check-label">
                                            {{ Form::checkbox('force', config('config.subject.force'), checkForceSubject($specialization->subjects, $subject), ['class'=>'form-check-input']) }}
                                            {{ 'Bắt Buộc' }}
                                            <i class="input-helper"></i>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-2">
                    {{Form::submit('Xác Nhận', ['id' => 'submit', 'class'=> 'btn btn-outline-success mr-2']) }}
                    <a href="{{ route('admin.specializations.index') }}" class="btn btn-outline-dark">Huỷ Bỏ</a>
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
        $('#subjects').find('tbody tr').each(function(index, tr) {
            let subject_id = $(tr).find('' + 'td:first-child').find('input').val();
            let semester = $(tr).find('' + 'td:eq(1)').find('input').val();
            let selected = $(tr).find('' + 'td:first-child').find('input').is(':checked');
            let force = $(tr).find('' + 'td:last-child').find('input').is(':checked');
            if (selected)
                subjects = {
                    ...subjects,
                    [subject_id]: {
                        force: Number(force),
                        semester: Number(semester),
                    }
                }
        });
        $.ajax({
            url: "{{ route('admin.specializations.choose_subject', $specialization->id) }}",
            method: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                subjects,
            },
            success: function() {
                window.location.href = "{{ route('admin.specializations.index') }}"
            },
            error: function() {
                alert('Error');
            }
        });
    });
    $(document).on('change', '.selectedSubject', function(event) {
        $(event.target).closest('tr')
            .find('td:eq(1)')
            .find('input')
            .attr('disabled', !this.checked)
    });
</script>
@endsection