@extends('layouts.student')

@section('breadcrumb')
    <div class="page-header">
        <h3 class="page-title">Đăng Ký Tín Chỉ</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
                <li class="breadcrumb-item active" aria-current="page">Đăng Ký Tín Chỉ</li>
            </ol>
        </nav>
    </div>
@endsection
@section('main')
    <div class="row">
        <div class="col-lg-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-4 justify-content-between">
                        <div class="">
                            <form action="">
                                {{ Form::select('semester', $semester, $semesterFilter, ['class' =>'form-control form-control-sm', 'onchange' => 'this.form.submit()']) }}
                            </form>
                        </div>
                        <a class="btn btn-sm d-flex align-items-center btn-outline-success" href="{{ route('credits.create') }}">Đăng Ký</a>
                    </div>
                    <div class="table-responsive table-scroll">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Lớp Học</th>
                                <th>Thời Gian Bắt Đầu</th>
                                <th>Môn Học</th>
                                <th>Tín Chỉ</th>
                                <th>Trạng Thái</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($credits as $credit)
                                <tr>
                                    <td>
                                        {{ $credit->schedule ?? '' }}
                                    </td>
                                    <td>
                                        {{ $credit->schedule->start_time ?? '' }}
                                    </td>
                                    <td>
                                        {{ $credit->subject->name }}
                                    </td>
                                    <td>
                                        {{ $credit->subject->credit }}
                                    </td>
                                    <td>
                                        {{ !isset($credit->schedule) ? 'Progress' : 'Success'  }}
                                    </td>
                                    <td style="width: 100px">
                                        <div class="d-flex justify-content-between">
                                            {{ Form::open(['url' => route('credits.destroy', $credit->id)]) }}
                                            {{ Form::submit('Cancel', ['class' => 'btn btn-sm btn-outline-danger']) }}
                                            {{ Form::close() }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection