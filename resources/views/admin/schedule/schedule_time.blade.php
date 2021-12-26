@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Quản Lý Tín Chỉ</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.home') }}">Bảng Điều Khiển</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.schedules.index') }}">Danh Sách Lớp Tín Chỉ</a>
        </li>
        <li class="breadcrumb-item active">Chọn Lịch Học</li>
    </ol>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-lg-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive ">
                    <table class="table table-bordered table-hover" id="schedule-time">
                        <thead>
                            <tr>
                                <th>Thứ</th>
                                <th>Buổi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (config('scheduletime.schedule') as $key => $weekday)
                            {{ Form::open(['url' => route('admin.schedules.store')]) }}
                            <tr>
                                <td>
                                    <div class="form-check form-check-info">
                                        <label class="form-check-label">
                                            {{ Form::checkbox('weekday', $key, false, ['class' => 'form-check-input']) }}
                                            <span class="text text-capitalize">{{ $key }}</span>
                                            <i class="input-helper"></i>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    @foreach ($weekday as $weekKey => $time)
                                    <div class="form-check form-check-info">
                                        <label class="form-check-label">
                                            {{ Form::checkbox('time', $weekKey, false, [
                                                            'class' => 'form-check-input',
                                                        ]) }}
                                            <span class="text text-capitalize">{{ $time }}</span>
                                            <i class="input-helper">
                                                {{ '(' . config('scheduletime')[$weekKey]['start'] . ' - ' . config('scheduletime')[$weekKey]['end'] . ')' }}
                                            </i>
                                        </label>
                                    </div>
                                    @endforeach
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="2" class="text-right">
                                    <button class="btn btn-outline-success" id="submit">Xác Nhận</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    jQuery(document).on('click', '#submit', function(event) {
        event.preventDefault();
        let timeschedules = [];
        jQuery('#schedule-time').find('tbody tr:not(:last-child)').each(function(index, tr) {
            let weekday = jQuery(tr).find('' + 'td:eq(0)').find('input').val();
            let selected = jQuery(tr).find('' + 'td:eq(0)').find('input').is(':checked');
            let weektimes = jQuery(tr).find('' + 'td:eq(1)').find('input').filter(function(index,
                item) {
                return item.checked;
            }).map(function(index, item) {
                return jQuery(item).val();
            }).toArray();
            if (selected && weektimes.length)
                timeschedules = [
                    ...timeschedules,
                    {
                        weekday,
                        weektimes,
                    }
                ];
        });

        $.ajax({
            url: "{{ route('admin.schedules.scheduleTime', $schedule->id) }}",
            method: 'post',
            data: {
                _token: "{{ csrf_token() }}",
                timeschedules,
            },
            success: function() {
                window.location.href = "{{ route('admin.schedules.index') }}"
            },
            error: function() {
                alert('Error');
            }
        });
    })
</script>
@endsection