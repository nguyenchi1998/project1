@extends('master')
@section('title')
	<p>Danh sách lịch học </p>	
@endsection
@section('main')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
            	<form action="{{route('viewthemlich')}}" method="get">
            	<div class="row">
	                <div class="col-lg-2">
	                		<select name="malop" class="form-control" id="malop" >
	                			<option hidden value="">--Chọn lớp học--</option>
	                			@foreach($arrLop as $objLop)
	                			<option  value="{{$objLop->malop}}">{{$objLop->tenlop}}</option>
	                			@endforeach
	                		</select>
	                </div>
	                <div class="col-lg-2">
	                        <button class="btn btn-secondary" style="display: none;" id="btnThem" type="submit">Thêm lịch</button>
	                </div>
                </div>
            	</form>
                <div class="table-responsive m-t-40">
                    <table class="table table-striped table-bordered" id="danhsachlich">
						<thead>
							<tr>
								<th>Mã lịch</th>
								<th>Tên môn học</th>
								<th>Tên giáo viên</th>
								<th>Lớp</th>
								<th>Thời gian bắt đầu</th>
								<th>Thời gian kết thúc(Dự kiến)</th>
								<th></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
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
	$("#malop").change(function(){
	      	var malop = $(this).val();
	      	var token = $('input[name=_token]').val();
	     	var url = "{{route('admin.danhsachlop')}}";
	      	var table = $("#danhsachlich tbody");
	      	$('#btnThem').show();
	      	$.ajax({
	      		url: url,
		       	headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
		        method: 'GET',
		       	dataType : 'json',
		        data: { 'malop': malop, '_token': token},
			    success: function(data) {
			        table.empty();
		            $.each(data, function (a, b) {
		            	var d = new Date(b.thoigianbatdau);
		            	var e = new Date(b.thoigianketthuc);
		            	var message = "Bạn có muốn xóa?";
		                table.append("<tr><td>"+
		                		b.malich+"</td>" +
		                    "<td>"+b.tenmonhoc+"</td>"+
		                    "<td>" + b.tengiaovien + "</td>" +
		                    "<td>" + b.tenlop + "</td>" +
		                    "<td>" + d.getDate()+ "-" + d.getMonth() + "-" + d.getFullYear() + "</td>" +
		                    "<td>" + e.getDate()+ "-" + e.getMonth() + "-" + e.getFullYear() + "</td>"+ 
		                    "<td class='text-center'>" + '<form action="{{route('viewsualich')}}" method="get">'+
										'<input type="hidden" name="malop" value="' + b.malop + '">' +
										'<input type="hidden" name="malich" value="' + b.malich + '">' +
										'<button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i></button>' +
										'</form>' + "</td>" +
		                    "<td class='text-center'>" + '<form action="{{route('xoalich')}}" method="get">'+
										'<input type="hidden" name="malop" value="' + b.malop + '">' +
										'<input type="hidden" name="malich" value="' + b.malich + '">' +
										'<button type="submit" onclick="return confirm("'+message+'")"  class="btn btn-danger"><i class="fa fa-trash"></i></button>' +
										'</form>' + "</td></tr>");
		            });
	            	$("#danhsachlich").DataTable();
			    }
	      	});
	  	});
</script>
@endsection


