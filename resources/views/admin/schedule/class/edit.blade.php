@extends('layouts.manager')
@section('title') Manager Classes @endsection
@section('breadcrumb')
    <div class="page-header">
        <h3 class="page-title">Update</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.specializations.index') }}">Classes</a>
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
                    {{ Form::open(['url' => route('admin.classes.update', $class->id) , 'method' => 'POST']) }}
                    @method('PUT')
                    {{ Form::text('id',$class->id, ['hidden'=>true]) }}
                    <div class="form-group">
                        <label for="name">Name</label>
                        {{ Form::input('text', 'name', $class->name, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Enter name']) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('subject', 'Subject')}}
                        @foreach($students as $key => $student)
                            <div class="form-check form-check-info">
                                <label class="form-check-label">
                                    {{ Form::checkbox('students[]', $student->id, in_array($student->id, $class->students->pluck('id')->toArray()),  ['class'=>'form-check-input']) }}
                                    {{ $student->name }}
                                    <i class="input-helper"></i>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    {{Form::submit('Submit', ['class'=> 'btn btn-gradient-primary mr-2'])}}
                    <a href="{{ route('admin.classes.index') }}" class="btn btn-light">Cancel</a>
                    {{ Form::close()}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script') @endsection