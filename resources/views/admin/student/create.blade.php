@extends('layouts.manager')
@section('breadcrumb')
    <div class="col-sm-6">
        <h1 class="m-0">Student Create</h1>
    </div>
@endsection
@section('main')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {{ Form::open([
                        'url' => route('admin.students.store'),
                        'method' => 'POST',
                        'files' => true,
                    ]) }}
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="email">Email</label>
                            {{ Form::input('email', 'email', old('email'), [
                                'class' => 'form-control',
                                'id' => 'email',
                                'placeholder' => 'Email',
                            ]) }}
                        </div>  <div class="form-group col-lg-6">
                            <label for="name">Name</label>
                            {{ Form::input('text', 'name', null, [
                                'class' => 'form-control',
                                'id' => 'name',
                                'placeholder' => 'Name',
                            ]) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="phone">Phone</label>
                            {{ Form::input('text', 'phone', old('phone'), [
                                'class' => 'form-control',
                                'id' => 'phone',
                                'placeholder' => 'Phone',
                            ]) }}
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="birthday">Birthday</label>
                            {{ Form::input('date', 'birthday', old('birthday'), [
                                'class' => 'form-control',
                                'id' => 'birthday',
                            ]) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            {{ Form::label('gender', 'Gender') }}
                            <div class="form-inline">
                                <div class="form-check form-check-info">
                                    <label class="form-check-label">
                                        {{ Form::radio('gender', config('config.gender.male'), false, [
                                            'class' => 'form-check-input',
                                        ]) }}
                                        Male
                                        <i class="input-helper"></i>
                                    </label>
                                </div>
                                <div class="ml-3 form-check form-check-info">
                                    <label class="form-check-label">
                                        {{ Form::radio('gender', config('config.gender.female'), false, [
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
                            {{ Form::input('text', 'address', old('address'), ['class' => 'form-control','id' => 'credit','placeholder' => 'Address']) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="class_room">ClassRoom</label>
                            {{ Form::select('class_room_id', $classRooms, null, ['class' => 'form-control mr-2', 'placeholder' => 'Choose ClassRoom']) }}
                        </div>
                    </div>

                    <div class="mt-3">
                        {{ Form::submit('Submit', ['class' => 'btn btn-outline-success mr-2']) }}
                        <a href="{{ route('admin.students.index') }}" class="btn btn-outline-dark">Cancel</a>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
