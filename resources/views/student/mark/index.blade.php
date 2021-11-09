@extends('layouts.student')
@section('breadcrumb')
    <div class="col-sm-6">
        <h1 class="m-0">Danh Sách Điểm Thi</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Bảng Điều Khiển</a></li>
            <li class="breadcrumb-item active">Danh Sách Điểm Thi</li>
        </ol>
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
                                {{ Form::select('semester', $semester, $semesterFilter, ['placeholder' => 'Tất Cả Kỳ Học','class' =>'form-control', 'onchange' => 'this.form.submit()']) }}
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive table-scroll">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Môn Học</th>
                                <th>Điểm Chuyên Cần</th>
                                <th>Điểm Giữa Kỳ</th>
                                <th>Điểm Cuối Kỳ</th>
                                <th>TrạnG Thái</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($subjects as $subject)
                                <tr>
                                    <td>
                                        {{ $subject->subject }}
                                    </td>
                                    <td>
                                        {{ $subject->activity_mark }}
                                    </td>
                                    <td>
                                        {{ $subject->middle_mark }}
                                    </td>
                                    <td>
                                        {{ $subject->final_mark }}
                                    </td>
                                    <td>
                                        {{ $subject->status }}
                                    </td>
                                    <td width="100">
                                        <div class="d-flex justify-content-between">
                                            {{ Form::open(['url' => route('credits.destroy', $credit->id)]) }}
                                            {{ Form::submit('Relearn', ['class' => 'btn btn-sm btn-outline-danger']) }}
                                            {{ Form::close() }}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <div class="pt-3 d-flex justify-content-center">
                                    <h4>Empty Data</h4>
                                </div>
                            @endforelse
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