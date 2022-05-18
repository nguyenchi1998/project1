@extends('layouts.manager')
@section('breadcrumb')
    <div class="col-sm-6">
        <h1 class="m-0">Subject Edit</h1>
    </div>
@endsection
@section('main')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {{ Form::open([
                        'url' => route('admin.subjects.update', $subject->id),
                        'method' => 'POST',
                    ]) }}
                    @method('PUT')
                    @csrf
                   <div class="row">
                       <div class="form-group col-lg-12">
                           <label for="name">Subject</label>
                           {{ Form::input('text', 'name', $subject->name, [
                               'class' => 'form-control',
                               'id' => 'name',
                               'placeholder' => 'Subject',
                           ]) }}
                       </div>
                   </div>
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <label for="number_lessons">Number Lessons</label>
                            {{ Form::input('number', 'number_lessons', $subject->number_lessons, [
                                'class' => 'form-control',
                                'id' => 'number_lessons',
                                'placeholder' => 'Set number of lessons',
                            ]) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <label for="type">Subject Type</label>
                            <select name="type" class="form-control" id="type">
                                <option value="{{ config('constant.subject_type.natural') }}"
                                        @if ($subject->type == config('constant.subject_type.natural')) selected @endif>Natural Subject</option>
                                <option value="{{ config('constant.subject_type.social') }}"
                                        @if ($subject->type == config('constant.subject_type.social')) selected @endif>Social Subject</option>
                                <option value="{{ config('constant.subject_type.another') }}"
                                        @if ($subject->type == config('constant.subject_type.another')) selected @endif>Another Subject</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-3">
                        {{ Form::submit('Submit', [
                            'class' => 'btn btn-outline-success mr-2',
                        ]) }}
                        <a href="{{ route('admin.subjects.index') }}" class="btn btn-outline-dark">Cancel</a>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
