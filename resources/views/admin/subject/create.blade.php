@extends('layouts.manager')
@section('title') Manager Subjects @endsection
@section('main')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Create Subject</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.subjects.index') }}">Manager Subjects</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        {{ Form::open(['url' =>route('admin.subjects.store') , 'method' => 'POST', 'class' => "forms-sample" ]) }}
                        <div class="form-group">
                            {{ Form::label('name', 'Name')}}
                            {{ Form::input('text', 'name', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Enter name']) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('credit', 'Credit')}}
                            {{ Form::input('number', 'credit', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Enter Credit', 'min' => 1]) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('semester', 'Semester')}}
                            {{ Form::select('number', $semesters , null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Choose semester', 'min' => 1, 'max' => config('common.semester.max')]) }}
                        </div>
                        <div class="form-group">
                            <label for="specializations">Specializations</label>
                            @foreach($specializations as $key => $specialization)
                                <div class="form-check form-check-info">
                                    <label class="form-check-label">
                                        {{ Form::checkbox('specializations[]', $specialization->id, false ,  ['class'=>'form-check-input']) }}
                                        {{ $specialization->name }}
                                        <i class="input-helper"></i>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <div class="form-group">
                            <div class="form-check form-check-primary">
                                <label class="form-check-label">
                                    {{ Form::checkbox('basic', config('common.subject.type.basic'), false, ['class'=>'form-check-input']) }}
                                    Basic Subject
                                    <i class="input-helper"></i>
                                </label>
                            </div>
                        </div>
                        {{Form::submit('Submit', ['class'=> 'btn btn-gradient-primary mr-2'])}}
                        <a href="{{ route('admin.subjects.index') }}" class="btn btn-light">Cancel</a>
                        {{ Form::close()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script') @endsection