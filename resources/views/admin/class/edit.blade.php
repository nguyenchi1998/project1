@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">ClassRoom Edit</h1>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.classes.students', $class->id) }}" class="btn btn-outline-secondary">
                        Danh Sách Student
                    </a>
                </div>
                {{ Form::open([
                        'url' => route('admin.classes.update', $class->id),
                        'method' => 'POST',
                    ]) }}
                @method('PUT')
                {{ Form::text('id', $class->id, ['hidden' => true]) }}
               <div class="row">
                   <div class="form-group col-lg-12">
                       <label for="name">Class</label>
                       {{ Form::input('text', 'name', $class->name, [
                               'class' => 'form-control',
                               'id' => 'name',
                               'placeholder' => 'Class',
                           ]) }}
                   </div>
               </div>
                <div class="row">
                    <div class="form-group col-lg-12">
                        <label for="manager_teacher">Manager Teacher</label>
                        {{ Form::select('manager_teacher', $managerTeachers, $class->teacher_id, ['class' => 'form-control mr-2', 'placeholder' => 'Choose Manager Teacher']) }}
                    </div>
                </div>
                <div class="mt-3">
                    {{ Form::submit('Submit', ['class' => 'btn btn-outline-success mr-2']) }}
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