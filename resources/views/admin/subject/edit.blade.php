@extends('layouts.manager')
@section('breadcrumb')
    <div class="col-sm-6">
        <h1 class="m-0">Sửa Đổi Môn Học</h1>
    </div>
@endsection
@section('main')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {{ Form::open([
                        'url' => route('admin.subjects.update', $subject->id),
                        'method' => 'POST',
                    ]) }}
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="name">Môn Học</label>
                        {{ Form::input('text', 'name', $subject->name, [
                            'class' => 'form-control',
                            'id' => 'name',
                            'placeholder' => 'Môn Học',
                        ]) }}
                    </div>
                    <div class="form-group">
                        <label for="type">Loại Môn Học</label>
                        <select name="type" class="form-control" id="type">
                            <option value="{{ config('constant.subject_type.natural') }}"
                                @if ($subject->type == config('constant.subject_type.natural')) selected @endif>Môn Tự Nhiên</option>
                            <option value="{{ config('constant.subject_type.social') }}"
                                @if ($subject->type == config('constant.subject_type.social')) selected @endif>Môn Xã Hội</option>
                            <option value="{{ config('constant.subject_type.another') }}"
                                    @if ($subject->type == config('constant.subject_type.another')) selected @endif>Môn Khác</option>
                        </select>
                    </div>
                    <div class="mt-3">
                        {{ Form::submit('Xác Nhận', [
                            'class' => 'btn btn-outline-success mr-2',
                        ]) }}
                        <a href="{{ route('admin.subjects.index') }}" class="btn btn-outline-dark">Huỷ Bỏ</a>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
