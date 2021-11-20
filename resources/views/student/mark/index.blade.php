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
                <div class="d-flex mb-3 justify-content-between">
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
                                <th>Kết Quả</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($subjects as $subject)
                            <tr>
                                <td>
                                    {{ $subject->specializationSubject->subject->name }}
                                </td>
                                <td>
                                    {{ $subject->activity_mark ?? 'Chưa có điểm' }}
                                </td>
                                <td>
                                    {{ $subject->middle_mark?? 'Chưa có điểm' }}
                                </td>
                                <td>
                                    {{ $subject->final_mark?? 'Chưa có điểm' }}
                                </td>
                                <td>
                                    {{ ucfirst(array_flip(config('schedule_detail.status.result'))[$subject->result_status]) }}
                                </td>
                                <td class="text-center">
                                    @if(isset($subject->result_status) && $subject->result_status == config('schedule_detail.status.result.relearn'))
                                    {{ Form::open(['url' => route('credits.destroy', $subject->id)]) }}
                                    {{ Form::submit('Relearn', ['class' => 'btn btn-sm btn-outline-danger']) }}
                                    {{ Form::close() }}
                                    @endif()
                                    @if(isset($subject->result_status) && $subject->result_status == config('schedule_detail.status.result.retest'))
                                    {{ Form::open(['url' => route('credits.destroy', $subject->id)]) }}
                                    {{ Form::submit('Retest', ['class' => 'btn btn-sm btn-outline-danger']) }}
                                    {{ Form::close() }}
                                    @endif()
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