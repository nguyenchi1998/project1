@extends('master')
@section('title')
	<p>Danh sách lớp học </p>
@endsection
@section('main')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
            	<div class="row">
	                <div class="col-lg-2">
	                	<a href="{{route('viewthemlop')}}" class="btn btn-secondary">Thêm lớp</a>
	                </div>           
	                <div class="col-lg-2">
	                	{{-- <form action="{{route('lop.loctheochuyennganh')}}"> --}}
		            		<select class="form-control" {{-- onchange="submit()" --}} id="manganh" name="manganh">
		            				<option hidden value="">Chọn chuyên ngành</option>
		            			@foreach($arrChuyennganh as $objChuyennganh)
		            				<option @if(isset($manganh) && $manganh == $objChuyennganh->machuyennganh) selected @endif value="{{$objChuyennganh->machuyennganh}}">{{$objChuyennganh->tenchuyennganh}}</option>
		            			@endforeach
		            		</select>
		            	{{-- </form> --}}
	                </div>
            	</div>
                    <div class="table-responsive m-t-40">
                        <table class="table table-striped table-bordered" id="danhsachlop">
							<thead>
							<tr>
									<th>Mã lớp</th>
									<th>Tên lớp</th>
									<th>Chuyên ngành</th>
									<th>Số sinh viên</th>
									<th></th>
									<th></th>
							</tr>
							</thead>	
						<tbody>
						{{-- @foreach($arrLop as $objLop)
						<tr>
								<td>{{$objLop->malop}}</td>
								<td>
									<a href="{{route('danhsachsinhvientheolop',['malop'=>$objLop->malop])}}">{{$objLop->tenlop}}</a>
								</td>
								<td>{{$objLop->tenchuyennganh}}</td>
								<td>{{$objLop->so}}</td>
								<td align="center">
									<form action="{{route('viewsualop')}}" method="get">
										<input type="hidden" name="txtMalop" value="{{$objLop->malop}}">
										<button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i></button>
									</form>
								</td>
								<td align="center">
									<form action="{{route('xoalop')}}" method="post">
										<input type="hidden" name="txtMaLop" value="{{$objLop->malop}}">
										<button type="submit" onclick="return confirm('Bạn có chắc chắn xóa giáo viên này ?')" class="btn btn-danger"><i class="fa fa-trash"></i></button>
									</form>
								</td>
						</tr>
						@endforeach --}}
					</tbody>
				</table>
             </div>
            </div>
		</div>
	</div>
</div>
@endsection
@section('script')
{{-- <script type="text/javascript">
	$(document).ready( function () {
		$('#danhsachlop').DataTable();
	});
</script> --}}
<script type="text/javascript">
	$("#manganh").change(function(){
		var manganh = $(this).val();
		var token = $('input[name=_token]').val();
		var url = "{{route('lop.loctheochuyennganh')}}";
		var table = $("#danhsachlop tbody");
		$.ajax({
	      	url: url,
		    headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
		    method: 'GET',
		    dataType : 'json',
	        data: { 'manganh': manganh, '_token': token},
		    success: function(data) {
		        table.empty();
	            $.each(data, function (a, b) {
	            	var message = "Bạn có muốn xóa?";
	                table.append("<tr><td>"+
	                		b.malop+"</td>" +
		                    "<td>"+b.tenlop+"</td>"+
		                    "<td>" + b.tenchuyennganh + "</td>" +
		                    "<td class='text-center'>" + b.so + "</td>" +
		                    "<td class='text-center'>" + '<form action="{{route('viewsualop')}}" method="get">'+
										'<input type="hidden" name="malop" value="' + b.malop + '">' +
										'<button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i></button>' +
										'</form>' + "</td>" +
		                    "<td class='text-center'>" + '<form action="{{route('xoalop')}}" method="get">'+
										'<input type="hidden" name="malop" value="' + b.malop + '">' +
										'<button type="submit" onclick="return confirm("'+message+'")"  class="btn btn-danger"><i class="fa fa-trash"></i></button>' +
										'</form>' + "</td></tr>");
		        });
	            $("#danhsachlop").DataTable();
			}
		});
	});
</script>
@endsection





