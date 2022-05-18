@extends('layouts.manager')
@section('breadcrumb')
    <div class="col-sm-6">
        <h1 class="m-0">Teacher Edit</h1>
    </div>
@endsection
@section('main')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {{ Form::open([
                            'url' => route('admin.teachers.update', $teacher->id),
                            'method' => 'POST',
                            'files' => true,
                        ]) }}
                    @method('PUT')
                    {{ Form::text('id', $teacher->id, ['hidden' => true]) }}
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="email">Email</label>
                            {{ Form::input('email', 'email', $teacher->email, [
                                    'readonly' => true,
                                    'class' => 'form-control',
                                    'id' => 'name',
                                    'placeholder' => 'Email',
                                ]) }}
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="name">Name</label>
                            {{ Form::input('text', 'name', $teacher->name, [
                                    'class' => 'form-control',
                                    'id' => 'name',
                                    'placeholder' => 'Name',
                                ]) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="phone">Phone</label>
                            {{ Form::input('text', 'phone', $teacher->phone, [
                                    'class' => 'form-control',
                                    'id' => 'name',
                                    'placeholder' => 'Phone',
                                ]) }}
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="birthday">Birthday</label>
                            {{ Form::input('date', 'birthday', $teacher->birthday, ['class' => 'form-control', 'id' => 'credit']) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            {{ Form::label('gender', 'Gender') }}
                            <div class="form-inline">
                                <div class="form-check form-check-info">
                                    <label class="form-check-label">
                                        {{ Form::radio('gender', config('config.gender.male'), $teacher->gender == config('config.gender.male'), [
                                                'class' => 'form-check-input',
                                            ]) }}
                                        Male
                                        <i class="input-helper"></i>
                                    </label>
                                </div>
                                <div class="ml-3 form-check form-check-info">
                                    <label class="form-check-label">
                                        {{ Form::radio('gender', config('config.gender.female'), $teacher->gender == config('config.gender.female'), [
                                                'class' => 'form-check-input',
                                            ]) }}
                                        Female
                                        <i class="input-helper"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="address">Address</label>
                            {{ Form::input('text', 'address', $teacher->address, [
                                    'class' => 'form-control',
                                    'id' => 'credit',
                                    'placeholder' => 'Address',
                                ]) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="experience">Experiment</label>
                        {{ Form::textarea('experience', null, [
                                'class' => ' form-control',
                                'id' => 'experience',
                                'placeholder' => 'Description',
                                'rows' => 3,
                            ]) }}
                    </div>
                    {{ Form::submit('Submit', [
                            'class' => 'btn btn-outline-success mr-2',
                        ]) }}
                    <a href="{{ route('admin.teachers.index') }}" class="btn btn-outline-dark">Cancel</a>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection