@extends('master')
@section('title')
	<p>Danh sách quản trị viên </p>	
@endsection
@section('main')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="col-lg-6">
                </div>
                <div class="col-lg-6">
                	<a href="{{route('viewthemadmin')}}" class="btn btn-secondary">Thêm quản trị viên</a>
                </div>
                    <div class="table-responsive m-t-40">
                        <table class="table table-striped table-bordered" id="danhsachadmin">
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
						@foreach($arrAd as $objAd)
						<tr>
								<td>{{$objAd->maadmin}}</td>
								<td>{{$objAd->tenadmin}}</td>
								<td>
									@if($objAd->gioitinh==0)
										{{'Nam'}}
									@else
										{{'Nữ'}}
									@endif
								</td>
								<td>{{date("d/m/Y", strtotime($objAd->ngaysinh))}}</td>
								<td>{{$objAd->diachi}}</td>
								<td>{{$objAd->email}}</td>
								<td>{{$objAd->lienhe}}</td>
								<td>{{$objAd->taikhoan}}</td>
								{{-- <td>{{$objAd->matkhau}}</td> --}}
								<td class="text-center">
									<form action="{{route('viewsuaadmin')}}" method="get">
											{{-- <input type="hidden" name="_token" value="{{csrf_token()}}"> --}}
											<input type="hidden" name="txtMaAdmin" value="{{$objAd->maadmin}}">
											<button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i></button>
									</form>
								</td>
								<td class="text-center">
									<form action="{{route('xoaadmin')}}" method="post">
											<input type="hidden" name="_token" value="{{csrf_token()}}">
											<input type="hidden" name="txtMaAdmin" value="{{$objAd->maadmin}}">
											<button type="submit" onclick="return confirm('Bạn có chắc chắn xóa quản trị viên này ?')" class="btn btn-danger"><i class="fa fa-trash"></i></button>
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
		    $('#danhsachadmin').DataTable();
		} );
</script>
@endsection
