@extends('layouts.manager')
@section('title') Quản lý chuyên ngành @endsection
@section('breadcrumb')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Tạo mới</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.specializations.index') }}">Danh sách chuyên ngành</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Tạo mới</li>
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
                                <label for="name">Chuyên Ngành</label>
                                {{ Form::input('text', 'min_credit', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Tên chuyên ngành']) }}
                            </div>
                            <div class="form-group">
                                <label for="min_creddit">Số Tín Chỉ Tối Thiểu</label>
                                {{ Form::input('number', 'min_credit', null, ['class' => 'form-control', 'id' => 'min_creddit', 'placeholder' => 'Số tín chỉ tối thiểu', 'min' => 0]) }}
                            </div>
                            <div class="form-group">
                                <label for="min_creddit">Số Kì Học</label>
                                {{ Form::input('number', 'max_semester', null, ['class' => 'form-control', 'id' => 'min_creddit', 'placeholder' => 'Số kì học', 'min' => 0]) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('subject', 'Môn Học')}}
                                <div class="row">
                                    @foreach($subjects as $key => $subject)
                                        <div class="col-sm">
                                            <div class="form-check form-check-info">
                                                <label class="form-check-label">
                                                    {{ Form::checkbox('subjects[]', $subject->id, false,  ['class'=>'form-check-input']) }}
                                                    {{ $subject->name }}
                                                    <i class="input-helper"></i>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            {{ Form::submit('Xác Nhận', ['class'=> 'btn btn-gradient-primary mr-2']) }}
                            <a href="{{ route('admin.specializations.index') }}" class="btn btn-light">Huỷ Bỏ</a>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection
@section('script') @endsection