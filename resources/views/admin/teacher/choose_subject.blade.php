@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Teacher Subject Choose</h1>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                {{ Form::open([
                        'url' => route('admin.teachers.choose_subject', $teacher->id),
                        'method' => 'POST',
                    ]) }}
                <div class="table-responsive table-scroll">
                    <table class="table table-bordered" id="subjects">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th class="text-center">
                                    {{ Form::checkbox('all', null, false, ['id' => 'all',]) }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subjects as $key => $subject)
                            <tr>
                                <td>
                                    {{ $subject->name }}
                                </td>
                                <td width="50" class="text-center">
                                    {{ Form::checkbox('subject_id[]', $subject['id'], in_array($subject['id'], $teacherSubjects), [
                                            ]) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ Form::submit('Submit', [
                            'class' => 'btn btn-outline-success mr-2',
                        ]) }}
                    <a href="{{ route('admin.teachers.index') }}" class="btn btn-outline-dark">Cancel</a>
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