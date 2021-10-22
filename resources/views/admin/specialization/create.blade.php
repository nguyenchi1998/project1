@extends('layouts.manager')
@section('title') Manager Specializations @endsection
@section('breadcrumb')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Create</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.specializations.index') }}">Specializations</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                </ol>
            </nav>
        </div>
        @endsection
        @section('main')
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            {{ Form::open(['url' =>route('admin.specializations.store') , 'method' => 'POST']) }}
                            <div class="form-group">
                                <label for="name">Name</label>
                                {{ Form::input('text', 'min_credit', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Enter Name']) }}
                            </div>
                            <div class="form-group">
                                <label for="min_creddit">Min Credit</label>
                                {{ Form::input('number', 'min_credit', null, ['class' => 'form-control', 'id' => 'min_creddit', 'placeholder' => 'Enter Min Credit', 'min' => 0]) }}
                            </div>
                            <div class="form-group">
                                <label for="min_creddit">Total Semester</label>
                                {{ Form::input('number', 'max_semester', null, ['class' => 'form-control', 'id' => 'min_creddit', 'placeholder' => 'Enter Total Semester', 'min' => 0]) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('subject', 'Subject')}}
                                @foreach($subjects as $key => $subject)
                                    <div class="form-check form-check-info">
                                        <label class="form-check-label">
                                            {{ Form::checkbox('subjects[]', $subject->id, false,  ['class'=>'form-check-input']) }}
                                            {{ $subject->name }}
                                            <i class="input-helper"></i>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            {{ Form::submit('Submit', ['class'=> 'btn btn-gradient-primary mr-2']) }}
                            <a href="{{ route('admin.subjects.index') }}" class="btn btn-light">Cancel</a>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection
@section('script') @endsection