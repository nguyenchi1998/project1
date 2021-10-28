@extends('layouts.manager')
@section('title') Quản Lý Chuyên Ngành @endsection

@section('breadcrumb')
    <div class="page-header">
        <h3 class="page-title">Chọn Môn Chuyên Ngành</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.specializations.index') }}">Danh Sách Chuyên Ngành</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Chọn Môn Chuyên Ngành</li>
            </ol>
        </nav>
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
                                    Khoa Viện: {{ $specialization->department->name }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive table-scroll">
                        {{ Form::open(['url' => route('admin.specializations.choose_subject', $specialization->id) , 'method' => 'POST']) }}
                        @method('PUT')
                        <table class="table table-bordered table-hover" id="subjects">
                            <thead>
                            <tr>
                                <th>Môn Học</th>
                                <th>Số Tín Chỉ</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($subjects as $key => $subject)
                                <tr>
                                    <td>
                                        <div class="form-check form-check-info m-0" style="min-width: 400px">
                                            <label class="form-check-label">
                                                {{ Form::checkbox('subject_id', $subject->id, in_array($subject->id, $specialization->subjects->pluck('id')->toArray()),  ['class'=>'form-check-input']) }}
                                                {{ $subject->name }}
                                                <i class="input-helper"></i>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $subject->credit }}
                                    </td>
                                    <td class="d-flex justify-content-center">
                                        <div class="form-check form-check-info m-0">
                                            <label class="form-check-label">
                                                {{ Form::checkbox('force', config('config.subject.force'), checkForceSubject($subjectForce, $subject), ['class'=>'form-check-input']) }}
                                                {{ 'Bắt Buộc' }}
                                                <i class="input-helper"></i>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{Form::submit('Xác Nhận', ['id' => 'submit', 'class'=> 'btn btn-gradient-primary mr-2']) }}
                        <a href="{{ route('admin.specializations.index') }}" class="btn btn-light">Huỷ Bỏ</a>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).on('click', '#submit', function (event) {
            event.preventDefault();
            let subjects = [];
            $('#subjects').find('tbody tr').each(function (index, tr) {
                let subject_id = $(tr).find('' + 'td:first-child').find('input').val();
                let selected = $(tr).find('' + 'td:first-child').find('input').is(':checked');
                console.log(selected)
                let force = $(tr).find('' + 'td:last-child').find('input').is(':checked');
                if (selected)
                    subjects = {
                        ...subjects,
                        [subject_id]: {
                            force: Number(force)
                        }
                    }
            });
            $.ajax({
                url: "{{ route('admin.specializations.choose_subject', $specialization->id) }}",
                method: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    subjects,
                },
                success: function () {
                    window.location.href = "{{ route('admin.specializations.index') }}"
                },
                error: function () {
                    alert('Error');
                }
            });
        })
    </script>
@endsection