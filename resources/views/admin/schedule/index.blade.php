@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Quản Lý Tín Chỉ</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item avtive">Danh Sách Lớp Tín Chỉ</li>
    </ol>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-lg-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex mb-4 justify-content-between">
                    <div class="w-25">
                        <form action="">
                            {{ Form::select('status', $states, $status , ['class' => 'form-control form-control-sm', 'placeholder' => 'Chọn Trạng Thái', 'onchange' => 'this.form.submit()']) }}
                        </form>
                    </div>
                    @if($hasScheduleDetails)
                    <a class="btn d-flex align-items-center btn-sm btn-outline-success" href="{{ route('admin.schedules.create') }}">Tạo Mới</a>
                    @endif
                </div>
                <div class="table-responsive table-scroll">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Lớp Tín Chỉ</th>
                                <th>Thời Gian Bắt Đầu</th>
                                <th>Thời Gian Kết Thúc</th>
                                <th>Giảng Viên</th>
                                <th>Số Sinh Viên</th>
                                <th>Trạng Thái</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($schedules as $schedule)
                            <tr>
                                <td>
                                    {{ $schedule->name }}
                                </td>
                                <td>
                                    {{ $schedule->start_time }}
                                </td>
                                <td>
                                    {{ $schedule->end_time }}
                                </td>
                                <td>
                                    {{ $schedule->teacher->name ?? ''}}
                                </td>
                                <td>
                                    {{ count($schedule->scheduleDetails) }}
                                </td>
                                <td>
                                    {{ $states[$schedule->status] }}
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="mr-1 btn btn-sm btn-outline-danger" href="#" data-toggle="tooltip" data-placement="top" title="Xóa lớp tín chỉ">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
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
@endsection @section('script') @endsection