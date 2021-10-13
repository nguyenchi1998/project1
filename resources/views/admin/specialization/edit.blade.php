@extends('layouts.manager')
@section('title') Manager Specializations @endsection
@section('main')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Update Specialization</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.specializations.index') }}">Manager Specializations</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Update</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        {{ Form::open(['url' => route('admin.specializations.update', $specialization->id) , 'method' => 'POST', 'class' => "forms-sample" ]) }}
                        @method('PUT')
                        {{ Form::text('id',$specialization->id, ['hidden'=>true]) }}
                        <div class="form-group">
                            <label for="name">Name</label>
                            {{ Form::input('text', 'name', $specialization->name, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Enter name']) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('subject', 'Subject')}}
                            <div class="scroll-list">
                                @foreach($subjects as $key => $subject)
                                    <div class="form-check form-check-info">
                                        <label class="form-check-label">
                                            {{ Form::checkbox('subjects[]', $subject->id, in_array($subject->id, $specialization->subjects),  ['class'=>'form-check-input']) }}
                                            {{ $subject->name }}
                                            <i class="input-helper"></i>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        {{Form::submit('Submit', ['class'=> 'btn btn-gradient-primary mr-2'])}}
                        <a href="{{ route('admin.specializations.index') }}" class="btn btn-light">Cancel</a>
                        {{ Form::close()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script') @endsection