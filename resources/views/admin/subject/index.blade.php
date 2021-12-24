@extends('layouts.manager')
@section('breadcrumb')
<div class="col-sm-6">
    <h1 class="m-0">Danh Sách Môn Học</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Bảng Điều Khiển</a></li>
        <li class="breadcrumb-item active">Danh Sách Môn Học</li>
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
                        <form action="{{ route('admin.subjects.index') }}" class="form-inline">
                            <input type="search" name="Từ Khóa" value="{{ $keyword }}" class="form-control  mr-2" placeholder="Từ Khoá">
                            {{ Form::select('department-filter', $departments, $departmentFilter, ['class' => 'mr-2 form-control ', 'placeholder' => 'Tất Cả Viện']) }}
                            <select name="type-filter" class="form-control mr-2">
                                <option value="">Tất Cả Thể Loại</option>
                                <option value="{{ config('subject.type.basic') }}" @if($typeFilter===config('subject.type.basic')) selected @endif>Đại Cương</option>
                                <option value="{{ config('subject.type.specialization') }}" @if($typeFilter===config('subject.type.specialization')) selected @endif>Chuyên Ngành</option>
                            </select>
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    </div>
                    <a class="btn Tìm Kiếmd-flex align-items-center btn-outline-success" href="{{ route('admin.subjects.create') }}">Tạo Mới</a>
                </div>
                <div class="table-responsive table-scroll">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Môn Học</th>
                                <th>Học Kỳ</th>
                                <th>Loại</th>
                                <th>Số Tín Chỉ</th>
                                <th>Viện Phụ Trách</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($subjects as $subject)
                            <tr>
                                <td>
                                    {{ $subject->name }}
                                </td>
                                <td>
                                    @if($subject->type == config('subject.type.basic'))
                                    <form action="{{ route('admin.subjects.update', $subject->id) }}" method="post">
                                        @csrf
                                        @method('put')
                                        {{ Form::select(
                                            'semester', 
                                            range_semester(config('config.start_semester'), config('config.class_register_limit_semester')), 
                                            $subject->semester,
                                            ['class' => 'form-control', 'placeholder' => 'Chọn Kỳ Học', 'onchange' => 'this.form.submit()'],
                                        )}}
                                    </form>
                                    @endif
                                </td>
                                <td>
                                    {{ $subject->type ? 'Chuyên Ngành' : 'Đại Cương' }}
                                </td>
                                <td>
                                    {{ $subject->credit }}
                                </td>
                                <td>
                                    {{ $subject->department->name }}
                                </td>
                                <td style="width: 100px">
                                    <div class="d-flex justify-content-between">
                                        <div class="mr-2">
                                            <a href="{{ route('admin.subjects.edit', $subject->id) }}" class="btn btn-outline-warning">
                                                Sửa
                                            </a>
                                        </div>
                                        <div>
                                            <form action="{{ route('admin.subjects.destroy', $subject->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger">
                                                    Xóa
                                                </button>
                                            </form>
                                        </div>
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
                    {{ $subjects->appends(['department-filter' => $departmentFilter, 'type-filter' => $typeFilter, 'keyword' => $keyword])->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

@endsection