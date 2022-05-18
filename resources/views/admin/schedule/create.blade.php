@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Schedule Create</h1>
</div>
@endsection
@section('main')
<div class="row">
    <div class="col-lg-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive mb-3">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>
                                    <div class="d-flex justify-content-between">
                                        Week Day
                                        <div style="width: 120px;" class="text-center">
                                            <button class="btn btn-outline-primary" type="button" data-toggle="collapse" data-target=".multi-collapse">
                                                Toggle All
                                            </button>
                                        </div>
                                    </div>
                                </th>

                            </tr>
                        </thead>
                        @foreach(range(0, 5) as $dayWeek)
                        <thead>
                            <tr>
                                <th colspan="4" align="center" class="text-capitalize">
                                    <div class="d-flex justify-content-between">
                                        {{array_search($dayWeek, config('constant.day_weeks')) }}
                                        <div style="width: 160px;" class="d-flex justify-content-between">
                                            <button class="btn btn-outline-primary" type="button" data-toggle="collapse" data-target="{{ '.multiCollapse' . $dayWeek }}">
                                                Toggle
                                            </button>
                                            <div class="collapse multi-collapse {{ 'multiCollapse' . $dayWeek }}">
                                                <button class="btn btn-outline-success" type="button">
                                                    Update
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="4" class="p-0">
                                    <div class="collapse multi-collapse {{ 'multiCollapse' . $dayWeek }}">
                                        <table class="table table-bordered table-hover mb-0">
                                            @foreach(range(0,4) as $lesson)
                                            <tr>
                                                <td class="text-capitalize">
                                                    Lesson {{ $lesson + 1 }}
                                                </td>
                                                <td>
                                                    {{ Form::select('subject_id', $subjects, null, ['class' => 'form-control', 'placeholder'=> 'Choose Subject']) }}
                                                </td>
                                                <td>
                                                    {{ Form::select('subject_id', $teachers, null, ['class' => 'form-control', 'placeholder'=> 'Choose Teacher']) }}
                                                </td>
                                                <td>
                                                    {{ Form::number('number_of_lesson', null, ['class' => 'form-control', 'placeholder'=> 'Set Number Of Lesson']) }}
                                                </td>

                                            </tr>
                                            @endforeach
                                        </table>

                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection