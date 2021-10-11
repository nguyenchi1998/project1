@extends('master')
@section('title')
	<p>Danh sách chuyên ngành </p>
@endsection
@section('main')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
            	<div class="row">
	                <div class="col-lg-2">
	                	<a href="{{route('viewthemmonhoc')}}" class="btn btn-secondary">Thêm môn học</a>
	                </div>           
	                <div class="col-lg-2">
	                	{{-- <form action="{{route('monhoc.loctheochuyennganh')}}"> --}}
		            		<select class="form-control" {{-- onchange="submit()" --}} id="manganh" name="manganh">
		            			<option hidden value="">Chọn chuyên ngành</option>
		            			@foreach($arrChuyennganh as $objChuyennganh)
		            				<option @if(isset($manganh)&&$manganh == $objChuyennganh->machuyennganh) selected @endif value="{{$objChuyennganh->machuyennganh}}">{{$objChuyennganh->tenchuyennganh}}</option>
		            			@endforeach
		            		</select>
		            	{{-- </form> --}}
	                </div>
                </div>
                    <div class="table-responsive m-t-40">
                        <table class="table table-striped table-bordered" id="danhsachMonHoc">
					<thead>
							<tr>
									{{-- <th>Mã môn học</th> --}}
									<th>Tên môn học</th>
									<th>Chuyên ngành</th>
									{{-- <th></th> --}}
									<th></th>
							</tr>
					</thead>	
						<tbody>
						@foreach($arrMonHoc as $objMonHoc)
						<tr>
								{{-- <td>{{$objMonHoc->mamonhoc}}</td> --}}
								<td>{{$objMonHoc->tenmonhoc}}</td>
								<td>{{$objMonHoc->tenchuyennganh}}</td>
								{{-- <td align="center">
									<form action="{{route('viewsuamonhoc')}}" method="post">
										<input type="hidden" name="_token" value="{{csrf_token()}}">
										<input type="hidden" name="txtMaMonHoc" value="{{$objMonHoc->mamonhoc}}">
										<button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i></button>
									</form>
								</td> --}}
								<td class="text-center">
									<form action="{{route('xoamonhoc')}}" method="get">
											<input type="hidden" name="txtMaMonHoc" value="{{$objMonHoc->mamonhoc}}">
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
		$('#danhsachMonHoc').DataTable();
	});
</script>
<script type="text/javascript">
	$("#manganh").change(function(){
	      	var manganh = $(this).val();
	      	var token = $('input[name=_token]').val();
	      	var url = "{{route('monhoc.loctheochuyennganh')}}";
	      	var table = $("#danhsachMonHoc tbody");
	      	$.ajax({
	      		url: url,
		       	headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
		        method: 'GET',
		       	dataType : 'json',
		        data: {'manganh': manganh, '_token': token},
			    success: function(data) {
			    	table.empty();
			    	$.each(data, function (a, b) {
				        var message = "Bạn có muốn xóa?";
		                table.append("<tr><td>"+
		                		b.tenmonhoc+"</td>" +
			                    "<td>"+b.tenchuyennganh+"</td>"+
			        //             // "<td>" + b.tenlop + "</td>" +
			        //             // "<td>" + gioitinh + "</td>" +
			        //             // "<td>" + d.getDate()+ "-" + d.getMonth() + "-" + d.getFullYear() +"</td>"+
			        //             // "<td>" + b.diachi + "</td>" +
			        //             // "<td>" + b.email + "</td>" +
			        //             // "<td>" + b.lienhe + "</td>"+
			        //             // "<td>" + b.taikhoan + "</td>" +
			        //             "<td class='text-center'>" + '<form action="{{route('viewsuasinhvien')}}" method="get">'+
											// '<input type="hidden" name="txtMasinhvien" value="' + b.masinhvien + '">' +
											// '<button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i></button>' +
											// '</form>' + "</td>" +
			                    "<td class='text-center'>" + '<form action="{{route('xoamonhoc')}}" method="get">'+
											'<input type="hidden" name="txtMaMonHoc" value="' + b.mamonhoc + '">' +
											'<button type="submit" onclick="return confirm("'+ message +'")"  class="btn btn-danger"><i class="fa fa-trash"></i></button>' +
											'</form>' + "</td></tr>");
			         });
		            $("#danhsachMonHoc").DataTable();
			    }
	      	});
	  	});
</script>
@endsection



