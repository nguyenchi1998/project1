@extends('layouts.manager')
@section('title') Quản lý chuyên ngành @endsection
@section('breadcrumb')
    <div class="page-header">
        <h3 class="page-title">Sửa Đổi</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.specializations.index') }}">Danh sách chuyên ngành</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Sửa Đổi</li>
            </ol>
        </nav>
    </div>
@endsection
@section('main')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['url' => route('admin.specializations.update', $specialization->id) , 'method' => 'POST']) }}
                    @method('PUT')
                    {{ Form::text('id',$specialization->id, ['hidden'=>true]) }}
                    <div class="form-group">
                        <label for="name">Chuyên Ngành</label>
                        {{ Form::input('text', 'name', $specialization->name, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Tên Chuyên Ngành']) }}
                    </div>
                    <div class="form-group">
                        <label for="min_creddit">Sô Tín Chỉ Tối Thiểu</label>
                        {{ Form::input('number', 'min_credit', $specialization->min_credit, ['class' => 'form-control', 'id' => 'min_creddit', 'placeholder' => 'Sô Tín Chỉ Tối Thiểu', 'min' => 0]) }}
                    </div>
                    <div class="form-group">
                        <label for="max_semester">Số Kì Học</label>
                        {{ Form::input('number', 'max_semester', $specialization->total_semester, ['class' => 'form-control', 'id' => 'max_semester', 'placeholder' => 'Số Kì Học', 'min' => 0]) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('subject', 'Subject')}}
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
                    {{Form::submit('Xác Nhận', ['class'=> 'btn btn-gradient-primary mr-2'])}}
                    <a href="{{ route('admin.specializations.index') }}" class="btn btn-light">Huỷ Bỏ</a>
                    {{ Form::close()}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script') @endsection