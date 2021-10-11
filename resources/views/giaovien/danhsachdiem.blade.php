@extends('master')
@section('title')
	@if(!isset($malop)&&!isset($mamonhoc))
		<p >Danh sách điểm</p>
	@else
		<p>Điểm môn {{$objMonhoc->tenmonhoc}}</p>
		<p>Lớp {{$objLopHoc->tenlop}}</p>
	@endif
@endsection
@section('main')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">  
                <div class="row">      
	                <div class="col-lg-2">
	                	<select class="form-control" id="malop" name="malop">
	            			<option hidden value="">Chọn lớp</option>
	            			@foreach($arrLop as $objLop)
	            				<option @if(isset($malop)&&$malop==$objLop->malop) selected @endif value="{{$objLop->malop}}">{{$objLop->tenlop}}</option>
	            			@endforeach
	            		</select>
		            </div>
		            <div class="col-lg-2">
		            	<select class="form-control" required id="mamonhoc" name="mamonhoc">
	            			<option hidden value="">Chọn môn học</option>
	            		</select>
		            </div>
		            <div class="col-lg-1"  >
		            	<button class="btn btn-primary" style="display: none;" id="btnXem" type="submit">Xem</button>			            	
	                </div>
	                <input type="hidden" id="magiaovien" name="magiaovien" value="{{$objGv->magiaovien}}">
	        		<div class="col-lg-2">
		        		<button class="btn btn-primary" id="btnThem"  style="display: none;" >Thêm điểm</button>
		        	</div>
	            </div>
                
                <div class="table-responsive m-t-40">
                 
					<table class="table table-striped table-bordered" id="danhsachdiem_giaovien" >
						<thead>
							<tr>
								<th>Mã sinh viên</th>
								<th>Tên sinh viên</th>
								{{-- <th>Môn học</th> --}}
								<th>Final 1</th>
								<th>Skill 1</th>
								<th>Final 2</th>
								<th>Skill 2</th>
								<th>Kết quả</th>
								<th></th>
								<th></th>
							</tr>
						</thead>	
						<tbody>
						{{-- @foreach($arrDiem as $objDiem)
							<tr>
								<td>{{$objDiem->masinhvien}}</td>
								<td>{{$objDiem->tensinhvien}}</td>
								<td>{{$objDiem->tenmonhoc}}</td>
								<td>{{$objDiem->finalmot}}</td>
								<td>{{$objDiem->skillmot}}</td>
								<td>{{$objDiem->finalhai}}</td>
								<td>{{$objDiem->skillhai}}</td>
								<td>
									@switch($objDiem->ketqua)
										@case (0)
											<p class="text-success text" style="font-weight: bold;">{{'Qua môn'}}</p>
											@break
										@case (1)
											<p class="text-warning" style="font-weight: bold;">{{'Trượt Final'}}</p>
											@break
										@case (2)
											<p class="text-warning" style="font-weight: bold;">{{'Trượt Skill'}}</p>
											@break
										@case (3)
											<p class="text-danger" style="font-weight: bold;">{{'Trượt Final + Skill'}}</p>
											@break
										@case (4)
											<p class="text-danger" style="font-weight: bold;">{{'Học lại'}}</p>
											@break
									@endswitch
								</td>
									<td align="center">
										<form action="{{route('giaovien.suadiem')}}" method="get">
												<input type="hidden" name="masinhvien" value="{{$objDiem->masinhvien}}">
												<input type="hidden" name="malich" value="{{$objDiem->malich}}">
												<input type="hidden" name="malop" value="{{$objLopHoc->malop}}">
												<input type="hidden" name="mamonhoc" value="{{$objMonhoc->mamonhoc}}">
												<button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i></button>
										</form>
									</td>
									<td align="center">
										<form action="{{route('giaovien.xoadiem')}}" method="post">
											<input type="hidden" name="_token" value="{{csrf_token()}}">
											<input type="hidden" name="masinhvien" value="{{$objDiem->masinhvien}}">
											<input type="hidden" name="mamonhoc" value="{{$objMonhoc->mamonhoc}}">
											<input type="hidden" name="malop" value="{{$objLopHoc->malop}}">
											<button type="submit" onclick="return confirm('Bạn có chắc chắn hủy điểm ?')" class="btn btn-danger"><i class="fa fa-trash"></i></button>
										</form>
									</td>
							</tr>
						@endforeach --}}
						</tbody>
					</table>
				{{-- @endif --}}
            	</div>
            </div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script type="text/javascript">
	$(document).ready( function () {
		$('#danhsachdiem').DataTable();
	});
</script>
<script type="text/javascript">
	$("#malop").change(function(){
	    var malop = $(this).val();
	    var magiaovien = $("#magiaovien").val();
	    var token = $('input[name=_token]').val();
	    var url = "{{route("giaovien.danhsachmonhoc")}}";
	    $.ajax({
		   	url: url,
		    headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
		    method: 'GET',
		    dataType : 'json',
		    data: {'malop': malop ,'magiaovien': magiaovien, '_token': token},
			success: function(data) {
				var index = data.length;
			   	$("select[name='mamonhoc']").empty();
			    $("select[name='mamonhoc']").append("<option hidden value=''>Chọn môn học</option>");
	            $.each(data, function(key, value){
	                $("select[name='mamonhoc']").append(
	                    "<option value=" + value.mamonhoc + ">" + value.tenmonhoc + "</option>"
	                );
	            });

			}
	    });
	});	
	$("#mamonhoc").change(function(){
		$("#btnXem").show();
		$("#btnThem").show();
	});
	$("#btnXem").click(function(){
		var mamonhoc = $("#mamonhoc").val();
	    var malop = $("#malop").val();
	    var token = $('input[name=_token]').val();
	    var url = "{{route('giaovien.danhsachdiem')}}";
	    var table = $("#danhsachdiem_giaovien tbody");
	    $.ajax({
	      	url: url,
		    headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
		    method: 'GET',
		    dataType : 'json',
		    data: { 'mamonhoc': mamonhoc, 'malop': malop, '_token': token},
			success: function(data) {
			   	table.empty();
		        $.each(data, function (a, b) {    	
		        	var finalhai;
		            var skillhai;
		            var kq;
		            if(b.finalhai == null){finalhai = '';}else{finalhai = b.finalhai;}
		            if(b.skillhai == null){skillhai = '';}else{skillhai = b.finalhai;}
		            switch(b.ketqua)
		            {case 0: kq = 'Qua môn';break;case 1: kq = 'Trượt Final ';break;case 2: kq = 'Trượt Skill';break;case 3: kq = 'Trượt Final + Skill';break;case 4: kq = 'Học Lại';break;}
			        var message = "Bạn có muốn xóa?";
			       	table.append("<tr><td>"+
			                b.masinhvien+"</td>" +
			                "<td>"+ b.tensinhvien+"</td>"+
			                "<td>" + b.finalmot + "</td>" +
		                    "<td>" + b.skillmot + "</td>" +
		                    "<td>" + finalhai + "</td>" +
		                    "<td>" + skillhai + "</td>" +
		                    "<td style='font-weight: bold'>" + kq + "</td>" +
		                    "<td class='text-center'>" + '<form action="{{route('giaovien.suadiem')}}" method="get">' +
											'<input type="hidden" name="masinhvien" value="' + b.masinhvien + '">' +
											'<input type="hidden" name="malop" value="' + b.malop + '">' +
											'<input type="hidden" name="mamonhoc" value="' + b.mamonhoc + '">' +
											'<button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i></button>' +
											'</form>' + "</td>" +
			                "<td class='text-center'>" + '<form action="{{route('giaovien.xoadiem')}}" method="get">'+
											'<input type="hidden" name="masinhvien" value="' + b.masinhvien + '">' +
											'<input type="hidden" name="mamonhoc" value="' + b.mamonhoc + '">' +
											'<input type="hidden" name="malop" value="' + b.malop + '">' +
											'<button type="submit" onclick="return confirm("'+message+'")"  class="btn btn-danger"><i class="fa fa-trash"></i></button>' +
											'</form>' + "</td></tr>");
			    });
			}
	    });
	});
	$("#btnThem").click(function(){
		var mamonhoc = $("#mamonhoc").val();
	    var malop = $("#malop").val();
		var url = "themdiem?mamonhoc="+mamonhoc+"&malop="+malop;
		window.location.href = url;
	});
</script>
@endsection



