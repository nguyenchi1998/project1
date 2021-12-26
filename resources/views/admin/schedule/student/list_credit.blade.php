@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Danh Sách Tín Chỉ</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.schedules.classes.index') }}">Đăng Ký Tín Chỉ Cho Sinh Viên</a></li>
        <li class="breadcrumb-item active">Danh Sách Tín Chỉ</li>
    </ol>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-lg-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex mb-3 justify-content-between align-items-center">
                    <div class="d-flex justify-content-between flex-column">
                        <div class="d-flex align-items-center mb-2">
                            <strong class="mr-1">Sinh Viên: </strong> {{ $student->name }}
                        </div>
                        <div class="d-flex align-items-center">
                            <strong class="mr-1">Kỳ Học: </strong>
                            <form action="">
                                {{ Form::select('semester-filter', $semesters, $semesterFilter, ['class' => 'form-control mr-2', 'onchange' => 'this.form.submit()']) }}
                            </form>
                        </div>
                    </div>
                    @if($semesterFilter == $class->semester)
                    <a class="btn h-100 btn-outline-success" href="{{ route('admin.schedules.students.create', $student->id) }}">Đăng Ký</a>
                    @endif
                </div>
                <div class="table-responsive table-scroll">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Môn Học</th>
                                <th>Số Tín Chỉ</th>
                                <th>Mã Lớp</th>
                                <th>Trạng Thái</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($scheduleDetails as $scheduleDetail)
                            <tr>
                                <td>
                                    {{ $scheduleDetail->subject->name }}
                                </td>
                                <td>
                                    {{ $scheduleDetail->credit ?? $scheduleDetail->subject->credit }}
                                </td>
                                <td>
                                    {{ $scheduleDetail->schedule->code ?? 'Chưa có lớp' }}
                                </td>
                                <td style="width: 200px">
                                    @if($scheduleDetail->register_status == config('schedule.detail.status.register.pending'))
                                    Đăng Ký Thành Công
                                    @else
                                    Xếp Lớp Thành Công
                                    @endif
                                </td>
                                <td style="width: 120px">
                                    @if($scheduleDetail->register_status == config('schedule.status.new'))
                                    <div class="d-flex justify-content-center">
                                        {{ Form::open(['url' => route('admin.schedules.students.destroy', ['student' => $student->id, 'scheduleDetail' => $scheduleDetail->id]), 'method' => 'post']) }}
                                        @csrf
                                        @method('delete')
                                        {{ Form::submit('Xóa', ['class' => 'btn btn-outline-info'])}}
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
                <div class="mt-3 d-flex justify-content-end">
                    {{ $scheduleDetails->appends(['specialization-filter' => $specializationFilter, 'semester-filter' => $semesterFilter, 'keyword' => $keyword])->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection