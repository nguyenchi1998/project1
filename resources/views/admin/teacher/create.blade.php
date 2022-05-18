@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Teacher Management</h1>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                {{ Form::open([
                        'url' => route('admin.teachers.store'),
                        'method' => 'POST',
                        'files' => true,
                    ]) }}
                <div class="form-group">
                    <label for="email">Email</label>
                    {{ Form::input('email', 'email', null, [
                            'class' => 'form-control',
                            'id' => 'name',
                            'placeholder' => 'Email',
                        ]) }}
                </div>
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label for="name">Name</label>
                        {{ Form::input('text', 'name', null, [
                                'class' => 'form-control',
                                'id' => 'name',
                                'placeholder' => 'Name',
                            ]) }}
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="name">Avatar</label>
                        {{ Form::file('avatar', ['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label for="phone">Phone</label>
                        {{ Form::input('text', 'phone', null, [
                                'class' => 'form-control',
                                'id' => 'name',
                                'placeholder' => 'Phone',
                            ]) }}
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="birthday">Birthday</label>
                        {{ Form::input('date', 'birthday', null, [
                                'class' => 'form-control',
                                'id' => 'credit',
                                'placeholder' => 'Birthday',
                            ]) }}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6">
                        {{ Form::label('gender', 'Gender') }}
                        <div class="form-inline">
                            <div class="form-check form-check-info">
                                <label class="form-check-label">
                                    {{ Form::radio('gender', 1, false, [
                                            'class' => 'form-check-input',
                                        ]) }}
                                    {{ 'Nam' }}
                                    <i class="input-helper"></i>
                                </label>
                            </div>
                            <div class="ml-3 form-check form-check-info">
                                <label class="form-check-label">
                                    {{ Form::radio('gender', 0, false, [
                                            'class' => 'form-check-input',
                                        ]) }}
                                    {{ 'Nữ' }}
                                    <i class="input-helper"></i>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="address">Address</label>
                        {{ Form::input('text', 'address', null, [
                                'class' => 'form-control',
                                'id' => 'credit',
                                'placeholder' => 'Address',
                            ]) }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="experience">Kinh Nghiệm</label>
                    {{ Form::textarea('experience', null, [
                            'class' => 'form-control',
                            'id' => 'credit',
                            'placeholder' => 'Kinh Nghiệm Cá Nhân',
                            'rows' => 3,
                        ]) }}
                </div>
                <div class="form-group">
                    {{ Form::label('department', 'Viện') }}
                    @foreach ($departments as $key => $department)
                    <div class="form-check form-check-info">
                        <label class="form-check-label">
                            {{ Form::radio('department_id', $department->id, false, [
                                        'class' => 'form-check-input',
                                    ]) }}
                            {{ $department->name }}
                            <i class="input-helper"></i>
                        </label>
                    </div>
                    @endforeach
                </div>
                <div class="mt-3">
                    {{ Form::submit('Submit', [
                            'class' => 'btn btn-outline-success mr-2',
                        ]) }}
                    <a href="{{ route('admin.teachers.index') }}" class="btn btn-outline-dark">Cancel</a>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection