@extends('layouts.manager')
@section('title') Manager Subjects @endsection
@section('breadcrumb')
    <div class="page-header">
        <h3 class="page-title">Update</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.subjects.index') }}">Subjects</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Update</li>
            </ol>
        </nav>
    </div>@endsection
@section('main')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['url' => route('admin.subjects.update', $subject->id) , 'method' => 'POST']) }}
                    @method('PUT')
                    {{ Form::text('id',$subject->id, ['hidden'=>true]) }}
                    <div class="form-group">
                        <label for="name">Name</label>
                        {{ Form::input('text', 'name', $subject->name, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Enter name']) }}
                    </div>
                    <div class="form-group">
                        <label for="credit">Credit</label>
                        {{ Form::input('number', 'credit', $subject->credit, ['class' => 'form-control', 'id' => 'credit', 'placeholder' => 'Enter Credit', 'min' => 1]) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('specialization', 'Specialization')}}
                        @foreach($specializations as $key => $specialization)
                            <div class="form-check form-check-info">
                                <label class="form-check-label">
                                    {{ Form::checkbox('specializations[]', $specialization->id, in_array($specialization->id, $subject->specializations) ,  ['class'=>'form-check-input']) }}
                                    {{ $specialization->name }}
                                    <i class="input-helper"></i>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <div class="form-check form-check-primary">
                            <label class="form-check-label">
                                {{ Form::checkbox('basic', config('common.subject.type.basic'), $subject->type == config('common.subject.type.basic'), ['class'=>'form-check-input']) }}
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
@endsection
@section('script') @endsection