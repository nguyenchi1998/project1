@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Sửa Đổi Môn Học</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.subjects.index') }}">Danh Sách Môn Học</a></li>
        <li class="breadcrumb-item active">Sửa Đổi Môn Học</li>
    </ol>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                {{ Form::open(['url' => route('admin.subjects.update', $subject->id) , 'method' => 'POST']) }}
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="name">Môn Học</label>
                    {{ Form::input('text', 'name', $subject->name, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Môn Học']) }}
                </div>
                <div class="form-group">
                    <label for="credit">Số Tín Chỉ</label>
                    {{ Form::input('number', 'credit', $subject->credit, ['class' => 'form-control', 'id' => 'credit', 'placeholder' => 'Sô Tín Chỉ', 'min' => 1]) }}
                </div>
                <div class="form-group">
                    <label for="semester">Kỳ Học</label>
                    {{ Form::select('semester', range_semester(config('config.start_semester'), config('config.max_semester')), $subject->semester, ['class' => 'form-control', 'id' => 'semester', 'placeholder' => 'Chọn Kỳ Học']) }}
                </div>
                <div class="form-group">
                    <label for="type">Loại Môn Học</label>
                    <select name="type" class="form-control" id="type">
                        <option value="{{ config('subject.type.basic') }}" @if($subject->type== config('subject.type.basic')) selected @endif>Đại Cương</option>
                        <option value="{{ config('subject.type.specialization') }}" @if($subject->type== config('subject.type.specialization'))selected @endif>Chuyên Ngành</option>
                    </select>
                </div>
                <div class="mt-3">
                    {{Form::submit('Xác Nhận', ['class'=> 'btn btn-outline-success mr-2']) }}
                    <a href="{{ route('admin.subjects.index') }}" class="btn btn-outline-dark">Huỷ Bỏ</a>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection
@section('script') @endsection