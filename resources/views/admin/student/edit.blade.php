@extends('layouts.manager')
@section('breadcrumb')
    <div class="col-sm-6">
        <h1 class="m-0">Student Edit</h1>
    </div>
@endsection
@section('main')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {{ Form::open([
                        'url' => route('admin.students.update', $student->id),
                        'method' => 'POST',
                        'files' => true,
                    ]) }}
                    @method('PUT')
                    {{ Form::text('id', $student->id, ['hidden' => true]) }}
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="email">Email</label>
                            {{ Form::input('email', 'email', $student->email, [
                                'readonly' => true,
                                'class' => 'form-control',
                                'id' => 'name',
                                'placeholder' => 'Email',
                            ]) }}
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="name">Name</label>
                            {{ Form::input('text', 'name', $student->name, [
                                'class' => 'form-control',
                                'id' => 'name',
                                'placeholder' => 'Name',
                            ]) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="phone">Phone</label>
                            {{ Form::input('text', 'phone', $student->phone, [
                                'class' => 'form-control',
                                'id' => 'name',
                                'placeholder' => 'Phone',
                            ]) }}
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="birthday">Birthday</label>
                            {{ Form::input('date', 'birthday', $student->birthday, [
                                'class' => 'form-control',
                                'id' => 'credit',
                            ]) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            {{ Form::label('gender', 'Gender') }}
                            <div class="form-inline">
                                <div class="form-check form-check-info">
                                    <label class="form-check-label">
                                        {{ Form::radio('gender', config('config.gender.male'), $student->gender == config('config.gender.male'), [
                                            'class' => 'form-check-input',
                                        ]) }}
                                        Name
                                        <i class="input-helper"></i>
                                    </label>
                                </div>
                                <div class="ml-3 form-check form-check-info">
                                    <label class="form-check-label">
                                        {{ Form::radio('gender', config('config.gender.female'), $student->gender == config('config.gender.female'), [
                                            'class' => 'form-check-input',
                                        ]) }}
                                        Nữ
                                        <i class="input-helper"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="address">Address</label>
                            {{ Form::input('text', 'address', $student->address, [
                                'class' => 'form-control',
                                'id' => 'credit',
                                'placeholder' => 'Address',
                            ]) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label for="class_room">ClassRoom</label>
                            {{ Form::select('class_room_id', $classRooms, $student->class_room_id, ['class' => 'form-control mr-2', 'placeholder' => 'Choose ClassRoom']) }}
                        </div>
                    </div>
                    <div class="mt-3">
                        {{ Form::submit('Submit', [
                            'class' => 'btn btn-outline-success mr-2',
                        ]) }}
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
