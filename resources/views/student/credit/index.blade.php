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
                            <form action="">
                                {{ Form::select('semester', $semester, $semesterFilter, ['placeholder' => 'Tất Cả Kỳ Học', 'class' =>'form-control ', 'onchange' => 'this.form.submit()']) }}
                            </form>
                        </div>
                        @if(auth()->user()->grade->can_register_credit)
                            <a class="btn btn-sm d-flex align-items-center btn-outline-success"
                               href="{{ route('credits.create') }}">Đăng Ký</a>
                        @endif
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
                            @forelse($credits as $credit)
                                <tr>
                                    <td>
                                        {{ $credit->schedule->name ?? 'Chưa có thông tin' }}
                                    </td>
                                    <td>
                                        {{ $credit->schedule->start_time ?? 'Chưa có thông tin' }}
                                    </td>
                                    <td>
                                        {{ $credit->subject->name }}
                                    </td>
                                    <td>
                                        {{ $credit->subject->credit }}
                                    </td>
                                    <td>
                                        {{ $credit->schedule->pending && isset($credit->schedule) ? 'Thành công' : 'Đang chờ xử lý' }}
                                    </td>
                                    <td style="width: 100px">
                                        <div class="d-flex justify-content-between">
                                            {{ Form::open(['url' => route('credits.destroy', $credit->id), 'method' => 'post']) }}
                                            @method('delete')
                                            @csrf
                                            {{ Form::submit('Cancel', ['class' => 'btn btn-sm btn-outline-danger']) }}
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