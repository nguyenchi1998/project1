@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Quản Lý Giảng Viên</h1>
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
                                Giảng Viên: {{ $teacher->name }}
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                Viện: {{ $teacher->department->name }}
                            </div>
                        </div>
                    </div>
                </div>
                {{ Form::open([
                        'url' => route('admin.teachers.choose_subject', $teacher->id),
                        'method' => 'POST',
                    ]) }}
                <div class="table-responsive table-scroll">
                    <table class="table table-bordered" id="subjects">
                        <thead>
                            <tr>
                                <th>Môn Học</th>
                                <th>Số Tín Chỉ</th>
                                <th>Kỳ Học</th>
                                <th class="text-center">
                                    {{ Form::checkbox('all', null, false, ['id' => 'all']) }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subjects as $key => $subject)
                            <tr>
                                <td>
                                    {{ $subject->name }}
                                </td>
                                <td>
                                    {{ $subject->credit }}
                                </td>
                                <td>
                                    {{ $subject->semester }}
                                </td>
                                <td width="50">
                                    {{ Form::checkbox('subject_id[]', $subject['id'], in_array($subject['id'], $teacherSubjects), [
                                                'class' => 'subject form-control',
                                            ]) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ Form::submit('Xác Nhận', [
                            'class' => 'btn btn-outline-success mr-2',
                        ]) }}
                    <a href="{{ route('admin.teachers.index') }}" class="btn btn-outline-dark">Huỷ Bỏ</a>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    jQuery(document).on('change', '#all', function(event) {
        event.preventDefault();
        jQuery('.subject').attr('checked', this.checked);
    })
</script>
@endsection