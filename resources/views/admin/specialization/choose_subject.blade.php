@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Chọn Môn Học</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="#">Bảng Điều Khiển</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">Danh Sách Chuyên Ngành</a>
        </li>
        <li class="breadcrumb-item active">Chọn Môn Học</li>
    </ol>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <div class="form-row">
                        <div class="col-6">
                            <div class="form-group">
                                Chuyên Ngành: {{ $specialization->name }}
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                Viện: {{ $specialization->department->name }}
                            </div>
                        </div>
                    </div>
                </div>
                {{ Form::open([
                        'url' => route('admin.specializations.choose_subject', $specialization->id),
                        'method' => 'POST',
                    ]) }}
                @csrf
                <div class="table-responsive table-scroll">
                    <table class="table table-bordered" id="subjects">
                        <thead>
                            <tr>
                                <th>Môn Học</th>
                                <th>Số Tín Chỉ</th>
                                <th>Loại</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subjects as $subject)
                            <tr>
                                <td>
                                    <div class="form-check form-check-info m-0" style="min-width: 400px">
                                        <label class="form-check-label">
                                            {{ Form::checkbox('subjectIds[]', $subject->id, in_array($subject->id, $specializationSubjects), [
                                                        'class' => 'form-check-input selectedSubject',
                                                    ]) }}
                                            <span class="{{ modelTrash($subject) }}">{{ $subject->name }}</span>
                                        </label>
                                    </div>
                                </td>
                                <td style="width: 150px">
                                    {{ $subject->credit }}
                                </td>
                                <td style="width: 150px">
                                    {{ $subject->type ? 'Chuyên Ngành' : 'Đại Cương' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 float-right">
                    {{ Form::submit('Xác Nhận', [
                            'id' => 'submit',
                            'class' => 'btn btn-outline-success mr-2',
                        ]) }}
                    <a href="{{ route('admin.specializations.index') }}" class="btn btn-outline-dark">Huỷ Bỏ</a>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection