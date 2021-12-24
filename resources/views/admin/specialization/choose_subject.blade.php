@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Chọn Môn Học</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item"><a href="#">Danh Sách Chuyên Ngành</a></li>
        <li class="breadcrumb-item active">Chọn Môn Học</li>
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
                                Viện: {{ $specialization->department->name }}
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
                                <th>Số Tín Chỉ</th>
                                <th>Loại</th>
                                <th>Kỳ Học</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subjects as $key => $subject)
                            <tr>
                                <td>
                                    <div class="form-check form-check-info m-0" style="min-width: 400px">
                                        <label class="form-check-label">
                                            {{ Form::checkbox('subject_id', $subject->id, $subject->choose, ['class'=>'form-check-input selectedSubject']) }}
                                            <span class="{{ modelTrash($subject) }}">{{ $subject->name }}</span>
                                        </label>
                                    </div>
                                </td>
                                <td style="width: 150px">
                                    {{ $subject->credit }}
                                    {{ Form::text('basic', $subject->type, ['hidden' => true]) }}
                                </td>
                                <td style="width: 150px">
                                    {{ $subject->type ? 'Chuyên Ngành' : 'Đại Cương' }}
                                </td>
                                <td style="width: 180px">
                                    {{ Form::select('semester', $subject->type  == config('subject.type.basic') ? $basicSemesters : $specializationSemesters, $subject->semester, ['class'=> 'form-control  semester', 'placeholder' => 'Tự Do']) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 float-right">
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
    jQuery(document).on('click', '#submit', function(event) {
        event.preventDefault();
        let subjects = {};
        jQuery('#subjects').find('tbody tr')
            .each(function(index, tr) {
                let subject_id = jQuery(tr).find('' + 'td:first-child').find('input').val();
                let isBasic = jQuery(tr).find('' + 'td:eq(1)').find('input').val();
                let semester = jQuery(tr).find('' + 'td:eq(3)').find('.semester option:selected').val();
                let selected = jQuery(tr).find('' + 'td:first-child').find('input').is(':checked');
                if (selected)
                    subjects = {
                        ...subjects,
                        [subject_id]: {
                            force: !!(!isBasic || (isBasic && semester)),
                            semester: semester ? Number(semester) : null,
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
            success: function({
                status,
                message
            }) {
                if (status)
                    window.location.href = "{{ route('admin.redirect_route', 'admin.specializations.index') }}";
                else
                    alert(message);
            },
            error: function({
                responseJSON,
                status
            }) {
                if (status == 422) {
                    alert(Object.values(responseJSON.errors)[0][0])
                } else {
                    alert('Xử lý thất bại');
                }
            }
        });
    });
</script>
@endsection