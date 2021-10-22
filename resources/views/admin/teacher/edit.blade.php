@extends('layouts.manager')
@section('title') Manager Teachers @endsection
@section('breadcrumb')
    <div class="page-header">
        <h3 class="page-title">Update</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.subjects.index') }}">Teachers</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Update</li>
            </ol>
        </nav>
    </div>
@endsection
@section('main')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['url' => route('admin.teachers.update', $teacher->id) , 'method' => 'POST']) }}
                    @method('PUT')
                    {{ Form::text('id',$teacher->id, ['hidden'=>true]) }}
                    <div class="form-group">
                        <label for="name">Name</label>
                        {{ Form::input('text', 'name', $teacher->name, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Enter name']) }}
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        {{ Form::input('email', 'email', $teacher->email, ['class' => 'form-control', 'id' => 'name', 'disabled' => true, 'placeholder' => 'Enter Email']) }}
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        {{ Form::input('text', 'phone', $teacher->phone, ['class' => 'form-control', 'id' => 'name',  'placeholder' => 'Enter Phone']) }}
                    </div>
                    <div class="form-group">
                        <label for="birthday">Birthday</label>
                        {{ Form::input('date', 'birthday', $teacher->birthday, ['class' => 'form-control', 'id' => 'credit', 'placeholder' => 'Enter Credit']) }}
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        {{ Form::input('text', 'address', $teacher->address, ['class' => 'form-control', 'id' => 'credit', 'placeholder' => 'Enter Address']) }}
                    </div>
                    <div class="form-group ">
                        {{ Form::label('gender', 'Specialization')}}
                        <div class="form-inline">
                            <div class="form-check form-check-info">
                                <label class="form-check-label">
                                    {{ Form::radio('gender', 1, $teacher->gender == 1 ,  ['class'=>'form-check-input']) }}
                                    {{ 'Male' }}
                                    <i class="input-helper"></i>
                                </label>
                            </div>
                            <div class="ml-3 form-check form-check-info">
                                <label class="form-check-label">
                                    {{ Form::radio('gender', 0, $teacher->gender == 0 ,  ['class'=>'form-check-input']) }}
                                    {{ 'Female' }}
                                    <i class="input-helper"></i>
                                </label>
                            </div>
                        </div>
                    </div>
                    {{Form::submit('Submit', ['class'=> 'btn btn-gradient-primary mr-2'])}}
                    <a href="{{ route('admin.teachers.index') }}" class="btn btn-light">Cancel</a>
                    {{ Form::close()}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script') @endsection