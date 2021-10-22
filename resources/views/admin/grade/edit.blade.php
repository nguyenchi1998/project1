@extends('layouts.manager')
@section('title') Manager Grades @endsection
@section('breadcrumb')
    <div class="page-header">
        <h3 class="page-title">Update</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.grades.index') }}">Grades</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Update</li>
            </ol>
        </nav>
    </div>
@endsection
@section('breadcrumb')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['url' =>route('admin.grades.update', $grade->id) , 'method' => 'POST']) }}
                    <div class="form-group">
                        <label for="name">Name</label>
                        {{ Form::input('text', 'name', $grade->name, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Enter name']) }}
                    </div>
                    {{Form::submit('Submit', ['class'=> 'btn btn-gradient-primary mr-2'])}}
                    <a href="{{ route('admin.grades.index') }}" class="btn btn-light">Cancel</a>
                    {{ Form::close()}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script') @endsection