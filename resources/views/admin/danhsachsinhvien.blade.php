@extends('master')
@section('title')
	<p>Danh sách sinh viên </p>	
@endsection
@section('main')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
            	<div class="row">
                <div class="col-lg-2">
                	<a href="{{route('viewthemsinhvien')}}" class="btn btn-secondary">Thêm sinh viên</a>
                </div>           
                <div class="col-lg-2">
                	{{-- <form action="{{route('danhsachsinhvientheolop')}}"> --}}
		            	<select class="form-control"{{--  onchange="submit()" --}} id="malop" name="malop">
		            		<option hidden value="">Chọn lớp</option>
		            		@foreach($arrLop as $obj)
		            			<option @if(isset($malop) && $malop == $obj->malop) selected @endif value="{{$obj->malop}}">{{$obj->tenlop}}</option>
		            		@endforeach
		            	</select>
		            {{-- </form> --}}
                </div>
            </div>
                    <div class="table-responsive m-t-40">
                        <table class="table table-striped table-bordered" id="danhsachsinhvien">
					<thead>
							<tr>
									<th>Mã</th>
									<th>Họ và tên</th>
									<th>Lớp</th>
									<th>Giới tính</th>
									<th>Ngày sinh</th>
									<th>Địa chỉ</th>
									<th>Email</th>
									<th>Số điện thoại</th>
									<th>Tài khoản</th>
									<th></th>
									<th></th>
							</tr>
					</thead>	
						<tbody>
						@foreach($arrSinhVien as $objSV)
						<tr>
								<td>{{$objSV->masinhvien}}</td>
								<td>{{$objSV->tensinhvien}}</td>
								<td>{{$objSV->tenlop}}</td>
								<td>
									@if($objSV->gioitinh==0)
										{{'Nam'}}
									@else
										{{'Nữ'}}
									@endif
								</td>
								<td>{{date("d/m/Y", strtotime($objSV->ngaysinh))}}</td>
								<td>{{$objSV->diachi}}</td>
								<td>{{$objSV->email}}</td>
								<td>{{$objSV->lienhe}}</td>
								<td>{{$objSV->taikhoan}}</td>
								<td align="center">
									<form action="{{route('viewsuasinhvien')}}" method="get">
											{{-- <input type="hidden" name="_token" value="{{csrf_token()}}"> --}}
											<input type="hidden" name="txtMasinhvien" value="{{$objSV->masinhvien}}">
											<button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i></button>
									</form>
								</td>
								<td align="center">
									<form action="{{route('xoasinhvien')}}" method="post">
											<input type="hidden" name="_token" value="{{csrf_token()}}">
											<input type="hidden" name="txtMasinhvien" value="{{$objSV->masinhvien}}">
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
		$('#danhsachsinhvien').DataTable();
	});
</script>
<script type="text/javascript">
	$("#malop").change(function(){
	      	var malop = $(this).val();
	      	var token = $('input[name=_token]').val();
	      	var url = "{{route('danhsachsinhvientheolop')}}";
	      	var table = $("#danhsachsinhvien tbody");
	      	$.ajax({
	      		url: url,
		       	headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
		        method: 'GET',
		       	dataType : 'json',
		        data: {'malop': malop, '_token': token},
			    success: function(data) {
			    	table.empty();
			    	$.each(data, function (a, b) {
				    	var gioitinh;
			            if(b.gioitinh == 0) {gioitinh = 'Nam';} else{gioitinh = 'Nữ';}
			            var d = new Date(b.ngaysinh);
				        var message = "Bạn có muốn xóa?";
		                table.append("<tr><td>"+
		                		b.masinhvien+"</td>" +
			                    "<td>"+b.tensinhvien+"</td>"+
			                    "<td>" + b.tenlop + "</td>" +
			                    "<td>" + gioitinh + "</td>" +
			                    "<td>" + d.getDate()+ "-" + d.getMonth() + "-" + d.getFullYear() +"</td>"+
			                    "<td>" + b.diachi + "</td>" +
			                    "<td>" + b.email + "</td>" +
			                    "<td>" + b.lienhe + "</td>"+
			                    "<td>" + b.taikhoan + "</td>" +
			                    "<td class='text-center'>" + '<form action="{{route('viewsuasinhvien')}}" method="get">'+
											'<input type="hidden" name="txtMasinhvien" value="' + b.masinhvien + '">' +
											'<button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i></button>' +
											'</form>' + "</td>" +
			                    "<td class='text-center'>" + '<form action="{{route('xoasinhvien')}}" method="get">'+
											'<input type="hidden" name="txtMasinhvien" value="' + b.masinhvien + '">' +
											'<button type="submit" onclick="return confirm("'+message+'")"  class="btn btn-danger"><i class="fa fa-trash"></i></button>' +
											'</form>' + "</td></tr>");
			         });
		            $("#danhsachdiem").DataTable();
			    }
	      	});
	  	});
</script>
@endsection