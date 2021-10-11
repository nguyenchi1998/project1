@extends('master')
@section('title')
	<p>Danh sách chuyên ngành </p>	
@endsection
@section('main')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="col-lg-6">
                	<a href="{{route('viewthemchuyennganh')}}" class="btn btn-secondary">Thêm chuyên ngành</a>
                </div>           
                <div class="col-lg-6">
                </div>
                    <div class="table-responsive m-t-40">
                        <table class="table table-striped table-bordered" id="danhsachchuyennganh">
					<thead>
							<tr>
									<th>Mã chuyên ngành</th>
									<th>Tên chuyên ngành</th>
									{{-- <th>Tổng số môn học</th> --}}
									<th></th>
									<th></th>
							</tr>
					</thead>	
						<tbody>
						@foreach($arrChuyennganh as $objChuyenNganh)
						<tr>
								<td>{{$objChuyenNganh->machuyennganh}}</td>
								<td>{{$objChuyenNganh->tenchuyennganh}}</td>
								{{-- <td>{{$objChuyenNganh->TongSoMon}}</td> --}}
								<td class='text-center'>
									<form action="{{route('viewsuachuyennganh')}}" method="get">
											{{-- <input type="hidden" name="_token" value="{{csrf_token()}}"> --}}
											<input type="hidden" name="txtMachuyennganh" value="{{$objChuyenNganh->machuyennganh}}">
											<button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i></button>
									</form>
								</td>
								<td class='text-center'>
									<form action="{{route('xoachuyennganh')}}" method="post">
											<input type="hidden" name="_token" value="{{csrf_token()}}">
											<input type="hidden" name="txtMachuyennganh" value="{{$objChuyenNganh->machuyennganh}}">
											<button type="submit" onclick="return confirm('Bạn có chắc chắn xóa chuyên ngành này ?')" class="btn btn-danger"><i class="fa fa-trash"></i></button>
									</form>
								</td>
						</tr>
						@endforeach
					</tbody>
				</table>
             </div>
            </div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script type="text/javascript">
	$(document).ready( function () {
		$('#danhsachchuyennganh').DataTable();
	});
</script>
@endsection


