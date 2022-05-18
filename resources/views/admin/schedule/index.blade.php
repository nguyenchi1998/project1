@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Schedule Management</h1>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-lg-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex mb-3 justify-content-between">
                    <div class="">
                        <form action="{{ route('admin.schedules.index') }}" class="form-inline">
                            <input type="search" name="keyword" value="{{ $keyword }}" class="form-control mr-2" placeholder="Keyword">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    </div>
                    <a class="btn d-flex align-items-center btn-outline-success" href="{{ route('admin.schedules.create') }}">
                        <i class="fa fa-plus"></i>
                    </a>
                </div>
                <div class="table-responsive table-scroll">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Schedule</th>
                                <th>Class</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Status</th>
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
                                    {{ $schedule->classRoom->name }}
                                </td>
                                <td>
                                    {{ formatDateShow($schedule->start_time) }}
                                </td>
                                <td>
                                    {{ formatDateShow($schedule->end_time) }}
                                </td>
                                <td>
                                    {{ $schedule->status }}
                                </td>
                                <td width="100">
                                    <div class="d-flex justify-content-between">
                                        @if ($schedule->status == config('schedule.status.done'))
                                        <div class="mr-2">
                                            <form action="{{ route('admin.schedules.show', $schedule->id) }}">
                                                <button class="btn btn-outline-info">Xem Điểm</button>
                                            </form>
                                        </div>
                                        @endif
                                        <div class="mr-2">
                                            <form action="{{ route('admin.schedules.edit', $schedule->id) }}">
                                                <button class="btn btn-outline-primary" @if ($schedule->status == config('schedule.status.done')) disabled @endif>
                                                    <i class="fa fa-edit"></i></button>
                                            </form>
                                        </div>
                                        @if ($schedule->status != config('schedule.status.done'))
                                        <div>
                                            <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn mr-1 btn-outline-danger" @if ($schedule->status == config('schedule.status.done')) disabled
                                                    @endif type="submit">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                        @endif
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
                <div class="mt-3 d-flex justify-content-end">
                    {{ $schedules->appends(['status' => $status, 'keyword' => $keyword])->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection @section('script') @endsection