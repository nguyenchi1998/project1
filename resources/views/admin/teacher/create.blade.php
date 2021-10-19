@extends('layouts.manager')
@section('title') Manager Teachers @endsection
@section('main')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Create Teacher</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.subjects.index') }}">Manager Teachers</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                </ol>
            </nav>
        </div>
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>[Warning]</strong> {{ $errors->first() }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        {{ Form::open(['url' => route('admin.teachers.store') , 'method' => 'POST', 'class' => "forms-sample", 'files' => true]) }}
                        <div class="d-flex justify-content-between">
                            <div style="min-width: 200px" class="px-2">
                                <div class="form-group">
                                    <label for="name">Avatar</label>
                                    {{ Form::file('avatar', ['class' =>'form-control']) }}
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    {{ Form::input('text', 'name', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Enter name']) }}
                                </div>
                                <div class="form-group ">
                                    {{ Form::label('gender', 'Gender')}}
                                    <div class="form-inline">
                                        <div class="form-check form-check-info">
                                            <label class="form-check-label">
                                                {{ Form::radio('gender', 1, false ,  ['class'=>'form-check-input']) }}
                                                {{ 'Male' }}
                                                <i class="input-helper"></i>
                                            </label>
                                        </div>
                                        <div class="ml-3 form-check form-check-info">
                                            <label class="form-check-label">
                                                {{ Form::radio('gender', 0, false ,  ['class'=>'form-check-input']) }}
                                                {{ 'Female' }}
                                                <i class="input-helper"></i>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    {{ Form::input('email', 'email', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Enter Email']) }}
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    {{ Form::input('text', 'phone', null, ['class' => 'form-control', 'id' => 'name',  'placeholder' => 'Enter Phone']) }}
                                </div>
                                <div class="form-group">
                                    <label for="birthday">Birthday</label>
                                    {{ Form::input('date', 'birthday', null, ['class' => 'form-control', 'id' => 'credit', 'placeholder' => 'Enter Credit']) }}
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    {{ Form::input('text', 'address', null, ['class' => 'form-control', 'id' => 'credit', 'placeholder' => 'Enter Address']) }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="experience">Experience</label>
                            {{ Form::textarea('experience', null, ['class' => ' form-control', 'id' => 'credit', 'placeholder' => 'Enter Address']) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('department', 'Department')}}
                            @foreach($departments as $key => $department)
                                <div class="form-check form-check-info">
                                    <label class="form-check-label">
                                        {{ Form::radio('department_id', $department->id, false, ['class'=>'form-check-input']) }}
                                        {{ $department->name }}
                                        <i class="input-helper"></i>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        {{Form::submit('Submit', ['class'=> 'btn btn-gradient-primary mr-2'])}}
                        <a href="{{ route('admin.teachers.index') }}" class="btn btn-light">Cancel</a>
                        {{ Form::close()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script') @endsection