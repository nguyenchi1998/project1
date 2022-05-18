@extends('layouts.manager')
@section('breadcrumb')
    <div class="col-sm-6">
        <h1 class="m-0">Subject Create</h1>
    </div>
@endsection
@section('main')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {{ Form::open([
                        'url' => route('admin.subjects.store'),
                        'method' => 'POST',
                    ]) }}
                    <div class="row">
                        <div class="form-group col-lg-12">
                            {{ Form::label('name', 'Subject') }}
                            {{ Form::input('text', 'name', null, [
                                'class' => 'form-control',
                                'id' => 'name',
                                'placeholder' => 'Subject',
                            ]) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <label for="number_lessons">Number Lessons</label>
                            {{ Form::input('number', 'number_lessons', null, [
                                'class' => 'form-control',
                                'id' => 'number_lessons',
                                'placeholder' => 'Set number of lessons',
                            ]) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="type">Subject Subject</label>
                        <select name="type" class="form-control" id="type">
                            <option value="">Choose subject type</option>
                            <option value="{{ config('constant.subject_type.natural') }}">Natural Subject</option>
                            <option value="{{ config('constant.subject_type.social') }}">Social Subject</option>
                            <option value="{{ config('constant.subject_type.another') }}">Another Subject</option>
                        </select>
                    </div>
                    <div class="mt-3">
                        {{ Form::submit('Submit', [
                            'class' => 'btn btn-outline-success mr-2',
                        ]) }}
                        <a href="{{ route('admin.subjects.index') }}" class="btn btn-outline-dark">Cancel</a>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
