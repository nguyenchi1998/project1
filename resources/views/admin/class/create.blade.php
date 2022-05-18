@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Class Create</h1>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                {{ Form::open([
                        'url' => route('admin.classes.store'),
                        'method' => 'POST',
                    ]) }}
                <div class="form-group">
                    <label for="name">Name</label>
                    {{ Form::input('text', 'name', null, [
                            'class' => 'form-control',
                            'id' => 'name',
                            'placeholder' => 'Name',
                        ]) }}
                </div>
                <div class="form-group">
                    <label for="students">Students</label>
                    @forelse ($students as $key => $student)
                    <div class="form-check form-check-info">
                        <label class="form-check-label">
                            {{ Form::checkbox('students[]', $student->id, false, [
                                    'class' => 'form-check-input',
                                ]) }}
                            {{ $student->name }}
                            <i class="input-helper"></i>
                        </label>
                    </div>
                    @empty
                        <p>All students already in class</p>
                    @endforelse
                </div>
                <div class="form-group">
                    <label for="manager_teacher">Manager Teacher</label>
                    {{ Form::select('manager_teacher', $managerTeachers, null, ['class' => 'form-control mr-2', 'placeholder' => 'Choose Manager Teacher']) }}
                </div>
                <div class="mt-3">
                    {{ Form::submit('Submit', [
                            'class' => 'btn btn-outline-success mr-2',
                        ]) }}
                    <a href="{{ route('admin.classes.index') }}" class="btn btn-outline-dark">Cancel</a>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection