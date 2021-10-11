@extends('master')
@section('title')
	<p>Danh sách điểm </p>	
@endsection
@section('main')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">      
                <div class="row">
                	<div class="col-lg-2">
		                <select class="form-control" required name="machuyennganh" id="chuyennganh" >
			            	<option hidden value="">Chọn Chuyên Ngành</option>
			            	@foreach($arrChuyennganh as $objChuyennganh)
			            		<option @if(isset($machuyennganh)&&$machuyennganh==$objChuyennganh->machuyennganh) selected @endif value="{{$objChuyennganh->machuyennganh}}">{{$objChuyennganh->tenchuyennganh}}</option>
			            	@endforeach
			            </select>
		            </div>
		            <div class="col-lg-10">
			            	<div class="row">
				            	<div class="col-lg-3">
							        <select class="form-control" required id="malop" name="malop">
								        <option hidden value="">Chọn lớp</option>
								    </select>
								</div>
								<div class="col-lg-3">
								    <select class="form-control" required id="mamonhoc" name="mamonhoc">
								        <option  hidden value="">Chọn môn học</option>
								    </select>
								</div>
		            		</div>
	            		
		        	</div>
	            </div>
                <div class="table-responsive m-t-40">
					<table class="table table-striped table-bordered" id="danhsachdiem" >
						<thead>
							<tr>
								<th>Mã sinh viên</th>
								<th>Tên sinh viên</th>
								<th>Final 1</th>
								<th>Skill 1</th>
								<th>Final 2</th>
								<th>Skill 2</th>
								<th>Kết quả</th>
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
		$("#chuyennganh").change(function(){
	      	var machuyennganh = $(this).val();
	      	var token = $('input[name=_token]').val();
	      	var url="{{route("admin.danhsachdiem.danhsachlop")}}";
	      	$.ajax({
		       	url: url,
		       	headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
		        method: 'GET',
		       	dataType : 'json',
		        data: {'machuyennganh': machuyennganh, '_token': token},
			    success: function(data) {
			    	$("select[name='malop']").empty();
			    	$("select[name='malop']").append("<option hidden value=''>Chọn lớp</option>");
	                $.each(data, function(key, value){
	                    $("select[name='malop']").append(
	                        "<option value=" + value.malop + ">" + value.tenlop + "</option>"
	                    );
	                });
			    },
			    error: function(data){
		        	alert('sai')
		    	}
	      	});
	  	});	
</script>
<script type="text/javascript">
		$("#chuyennganh").change(function(){
	      	var machuyennganh = $(this).val();
	      	var token = $('input[name=_token]').val();
	      	var url="{{route("admin.danhsachdiem.danhsachmonhoc")}}";
	      	$.ajax({
		       	url: url,
		       	headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
		        method: 'GET',
		       	dataType : 'json',
		        data: {'machuyennganh': machuyennganh, '_token': token},
			    success: function(data) {
			    	$("select[name='mamonhoc']").empty();
			    	$("select[name='mamonhoc']").append("<option hidden value=''>Chọn môn học</option>");
	                $.each(data, function(key, value){
	                    $("select[name='mamonhoc']").append(
	                        "<option value=" + value.mamonhoc + ">" + value.tenmonhoc + "</option>"
	                    );
	                });
			    },
			    error: function(data){
		        	alert('sai')
		    	}
	      	});
	  	});	
</script>
<script type="text/javascript">
		$("#malop").change(function(){
	      	var malop = $("#malop").val();
	      	var mamonhoc = $("#mamonhoc").val();
	      	var token = $('input[name=_token]').val();
	      	var url = "{{route('admin.danhsachdiem')}}";
	      	var table = $("#danhsachdiem tbody");
	      	$.ajax({
	      		url: url,
		       	headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
		        method: 'GET',
		       	dataType : 'json',
		        data: {'mamonhoc': mamonhoc, 'malop': malop, '_token': token},
			    success: function(data) {
			        table.empty();
		            $.each(data, function (a, b) {
		            	var finalhai;
		            	var skillhai;
		            	var kq;
		            	if(b.finalhai == null){finalhai = '';}else{finalhai = b.finalhai;}
		            	if(b.skillhai == null){skillhai = '';}else{skillhai = b.finalhai;}
		            	switch(b.ketqua){
		            		case 0: kq = 'Qua môn';break;
		            		case 1: kq = 'Trượt Final ';break;
		            		case 2: kq = 'Trượt Skill';break;
		            		case 3: kq = 'Trượt Final + Skill';break;
		            		case 4: kq = 'Học Lại';break;
		            	}
		                table.append("<tr><td>"+
		                		b.masinhvien+"</td>" +
		                    "<td>"+b.tensinhvien+"</td>"+
		                    "<td>" + b.finalmot + "</td>" +
		                    "<td>" + b.skillmot + "</td>" +
		                    "<td>" + finalhai + "</td>" +
		                    "<td>" + skillhai + "</td>" +
		                    "<td style='font-weight: bold'>" + kq + "</td></tr>");
		            });
	            	$("#danhsachdiem").DataTable();
			    }
	      	});
	  	});
	  	$("#mamonhoc").change(function(){
	      	var malop = $("#malop").val();
	      	var mamonhoc = $("#mamonhoc").val();
	      	var token = $('input[name=_token]').val();
	      	var url = "{{route('admin.danhsachdiem')}}";
	      	var table = $("#danhsachdiem tbody");
	      	$.ajax({
	      		url: url,
		       	headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
		        method: 'GET',
		       	dataType : 'json',
		        data: {'mamonhoc': mamonhoc, 'malop': malop, '_token': token},
			    success: function(data) {
			        table.empty();
		            $.each(data, function (a, b) {
		            	var finalhai;
		            	var skillhai;
		            	var kq;
		            	if(b.finalhai == null){finalhai = '';}else{finalhai = b.finalhai;}
		            	if(b.skillhai == null){skillhai = '';}else{skillhai = b.finalhai;}
		            	switch(b.ketqua){
		            		case 0: kq = 'Qua môn';break;
		            		case 1: kq = 'Trượt Final ';break;
		            		case 2: kq = 'Trượt Skill';break;
		            		case 3: kq = 'Trượt Final + Skill';break;
		            		case 4: kq = 'Học Lại';break;
		            	}
		                table.append("<tr><td>"+
		                		b.masinhvien+"</td>" +
		                    "<td>"+b.tensinhvien+"</td>"+
		                    "<td>" + b.finalmot + "</td>" +
		                    "<td>" + b.skillmot + "</td>" +
		                    "<td>" + finalhai + "</td>" +
		                    "<td>" + skillhai + "</td>" +
		                    "<td style='font-weight: bold'>" + kq + "</td></tr>");
		            });
	            	$("#danhsachdiem").DataTable();
			    }
	      	});
	  	});
</script>
@endsection



