@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Sửa Đổi Chuyên Ngành</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item"><a href="#">Danh Sách Chuyên Ngành</a></li>
        <li class="breadcrumb-item active">Sửa Đổi Chuyên Ngành</li>
    </ol>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.specializations.choose_subject_show', $specialization->id) }}" class="btn btn-outline-secondary">
                        Danh Sách Môn Giảng Dạy
                    </a>
                </div>
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
                    <label for="max_semester">Số Kỳ Học</label>
                    {{ Form::input('number', 'max_semester', $specialization->max_semester, ['class' => 'form-control', 'id' => 'max_semester', 'placeholder' => 'Số Kỳ Học', 'min' => 0]) }}
                </div>
                <div class="mt-3">
                    {{Form::submit('Xác Nhận', ['class'=> 'btn btn-outline-success mr-2']) }}
                    <a href="{{ route('admin.specializations.index') }}" class="btn btn-outline-dark">Huỷ Bỏ</a>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script') @endsection