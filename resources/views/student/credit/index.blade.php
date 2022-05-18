@extends('layouts.student')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Đăng Ký Tín Chỉ</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item active">Đăng Ký Tín Chỉ</li>
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
                        <form action="" class="form-inline">
                            {{ Form::select('semester', $semester, $semesterFilter, ['placeholder' => 'Tất Cả Kỳ Học', 'class' =>'form-control ']) }}
                            <button class="ml-2 btn btn-outline-info" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    </div>
                    @if(auth()->user()->can_register_credit && $semesterFilter == $class->semester)
                    <a class="btn d-flex align-items-center btn-outline-success" href="{{ route('scheduleDetails.credits.create') }}">Đăng Ký</a>
                    @endif
                </div>
                <div class="text-center">
                    <h4>{{ ($semesterFilter == $class->semester ? 'Kỳ Hiện Tại - ' : ''). ' Kỳ '. $semesterFilter   }}</h4>
                </div>
                <div class="table-responsive table-scroll">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Class</th>
                                <th>Thời Gian Bắt Đầu</th>
                                <th>Subject</th>
                                <th>Tín Chỉ</th>
                                <th>Trạng Thái</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($scheduleDetails as $scheduleDetail)
                            <tr>
                                <td>
                                    {{ $scheduleDetail->schedule->code ?? 'Chưa có thông tin' }}
                                </td>
                                <td>
                                    {{ $scheduleDetail->schedule->start_time ?? 'Chưa có thông tin' }}
                                </td>
                                <td>
                                    {{ $scheduleDetail->subject->name }}
                                </td>
                                <td>
                                    {{ $scheduleDetail->subject->credit }}
                                </td>
                                <td style="width: 200px">
                                    @if($scheduleDetail->register_status == config('schedule.detail.status.register.pending'))
                                    Đăng Ký Thành Công
                                    @else
                                    Xếp Lớp Thành Công
                                    @endif
                                </td>
                                </td>
                                <td style="width: 100px">
                                    @if(!$scheduleDetail->schedule_id)
                                    <div class="d-flex justify-content-between">
                                        {{ Form::open(['url' => route('scheduleDetails.credits.destroy', $scheduleDetail->id), 'method' => 'post']) }}
                                        @method('delete')
                                        @csrf
                                        {{ Form::submit('Xóa', ['class' => 'btn btn-outline-danger']) }}
                                        {{ Form::close() }}
                                    </div>
                                    @endif
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