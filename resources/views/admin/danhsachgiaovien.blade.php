@extends('master')
@section('title')
	<p>Danh sách giáo viên </p>	
@endsection
@section('main')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="col-lg-6">
                	<a href="{{route('viewthemgiaovien')}}" class="btn btn-secondary">Thêm giáo viên</a>
                </div>           
                <div class="col-lg-6">
                </div>
                    <div class="table-responsive m-t-40">
                        <table class="table table-striped table-bordered" id="danhsachgiaovien">
					<thead>
							<tr>
									<th>Mã</th>
									<th>Họ và tên</th>
									<th>Giới tính</th>
									<th>Ngày sinh</th>
									<th>Địa chỉ</th>
									<th>Email</th>
									<th>Số điện thoại</th>
									<th>Tài khoản</th>
									{{-- <th>Mật khẩu</th> --}}
									<th></th>
									<th></th>
							</tr>
					</thead>	
						<tbody>
						@foreach($arrGiaoVien as $objGiaoVien)
						<tr>
								<td>{{$objGiaoVien->magiaovien}}</td>
								<td>{{$objGiaoVien->tengiaovien}}</td>
								<td>
									@if($objGiaoVien->gioitinh==0)
										{{'Nam'}}
									@else
										{{'Nữ'}}
									@endif
								</td>
								<td>{{date("d/m/Y", strtotime($objGiaoVien->ngaysinh))}}</td>
								<td>{{$objGiaoVien->diachi}}</td>
								<td>{{$objGiaoVien->email}}</td>
								<td>{{$objGiaoVien->lienhe}}</td>
								<td>{{$objGiaoVien->taikhoan}}</td>
								{{-- <td>{{$objGiaoVien->matkhau}}</td> --}}
								<td align="center">
									<form action="{{route('viewsuagiaovien')}}" method="get">
											{{-- <input type="hidden" name="_token" value="{{csrf_token()}}"> --}}
											<input type="hidden" name="txtMagiaovien" value="{{$objGiaoVien->magiaovien}}">
											<button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i></button>
									</form>
								</td>
								<td align="center">
									<form action="{{route('xoagiaovien')}}" method="post">
											<input type="hidden" name="_token" value="{{csrf_token()}}">
											<input type="hidden" name="txtMagiaovien" value="{{$objGiaoVien->magiaovien}}">
											<button type="submit" onclick="return confirm('Bạn có chắc chắn xóa giáo viên này ?')" class="btn btn-danger"><i class="fa fa-trash"></i></button>
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
		$('#danhsachgiaovien').DataTable();
	});
</script>
@endsection



