@extends('master')
@section('title_page')
Thống kê theo lớp
@endsection
@section('title')
	<p >Thống kê theo lớp</p>
@endsection
@section('main')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">  
                <div class="row">      
	                <div class="col-lg-2">
	                	<select class="form-control" required name="malop" id="malop" >
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
			        <div class="col-lg-2" id="ketqua" style="display: none;">
				        <select class="form-control" id="kq"  name="ketqua">
				        	<option value="" hidden>Kết quả</option>
				        	<option value="">Tất cả</option>
				        	<option value="0">Qua môn</option>
				        	<option value="1">Trượt final</option>
				        	<option value="2">Trượt skill</option>
				        	<option value="3">Trượt final + skill</option>
				        	<option value="4">Học lại</option>
				        </select>
				    </div>
				    <div class="col-lg-2">
				        <a style="display: none;" id="btnXuatExcel" class="btn btn-secondary">Xuất Excel</a>

				        <a style="display: none;" id="btnPrint" class="btn btn-secondary">In File</a>
			        </div>
	            </div>
                <div class="table-responsive m-t-40">
					<table class="table table-striped table-bordered" id="thongketheolop">
						<thead>
							<tr>
								<th>Mã sinh viên</th>
								<th>Tên sinh viên</th>
								<th>Lớp</th>
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
</div>
@endsection
@section('script')
<script type="text/javascript">
	$(document).ready(function() {
	    $('#thongketheolop').DataTable();
	});
</script>
<script type="text/javascript">
	$("#malop").change(function(){
	      	var malop = $(this).val();
	      	var token = $('input[name=_token]').val();
	      	var url="{{route("danhsachmonhoccualop")}}";
	      	$.ajax({
		       	url: url,
		       	headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
		        method: 'GET',
		       	dataType : 'json',
		        data: {'malop': malop, '_token': token},
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
		        	alert(data)
		    	}
	      	});
	  	});	
</script>
<script type="text/javascript">
	$("#mamonhoc").change(function(){
	    var mamonhoc = $("#mamonhoc").val();
	    var malop = $("#malop").val();
	    var ketqua = $("#kq").val();
	    var token = $('input[name=_token]').val();
	    var url = "{{route('danhsachthongketheolop')}}";
	    var table = $("#thongketheolop tbody");
	    var index = 0;
	    $.ajax({
	      	url: url,
		    headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
		    method: 'GET',
		    dataType : 'json',
		    data: { 'mamonhoc': mamonhoc, 'malop': malop , 'ketqua': ketqua, '_token': token},
			success: function(data) {
			   	table.empty();
			   	index = data.length;
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
			                "<td>" + b.tenlop + "</td>" +
			                "<td>" + b.finalmot + "</td>" +
		                    "<td>" + b.skillmot + "</td>" +
		                    "<td>" + finalhai + "</td>" +
		                    "<td>" + skillhai + "</td>" +
		                    "<td style='font-weight: bold'>" + kq + "</td></tr>");
			    });
			    if(index > 0)
				{
					$("#btnXuatExcel").show();
					$("#ketqua").show();
					$("#btnPrint").show();
			    }
			    else
			    {
			    	$("#btnXuatExcel").hide();
					$("#ketqua").hide();
					$("#btnPrint").hide();
			    }
			}
	    });
	});

	$("#kq").change(function(){
	    var mamonhoc = $("#mamonhoc").val();
	    var malop = $("#malop").val();
	    var ketqua = $("#kq").val();
	    var token = $('input[name=_token]').val();
	    var url = "{{route('danhsachthongketheolop')}}";
	    var table = $("#thongketheolop tbody");
	    var index = 0;
	    $.ajax({
	      	url: url,
		    headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
		    method: 'GET',
		    dataType : 'json',
		   	data: { 'mamonhoc': mamonhoc, 'malop': malop , 'ketqua': ketqua, '_token': token},
			success: function(data) {
			   	table.empty();
			   	index = data.length;
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
			                "<td>" + b.tenlop + "</td>" +
			                "<td>" + b.finalmot + "</td>" +
		                    "<td>" + b.skillmot + "</td>" +
		                    "<td>" + finalhai + "</td>" +
		                    "<td>" + skillhai + "</td>" +
		                    "<td style='font-weight: bold'>" + kq + "</td></tr>");
			    });
			    if(index > 0)
				{
					$("#btnXuatExcel").show();
					$("#ketqua").show();
					$("#btnPrint").show();
			    }
			    else
			    {
			    	$("#btnXuatExcel").hide();
					$("#ketqua").show();
					$("#btnPrint").hide();
			    }
			}
	    });
	});
</script>
<script type="text/javascript">
	$("#btnXuatExcel").click(function(){
		var ketqua = $("#kq").val();
		var malop = $("#malop").val();
		var mamonhoc = $("#mamonhoc").val();
		var url = "thongketheolop/xuatexcel?malop="+malop+"&mamonhoc="+mamonhoc+"&ketqua="+ketqua;
		window.location.href = url;
	});
</script>
<script type="text/javascript">
	$("#btnPrint").click(function(){
		var content = document.getElementById("thongketheolop").innerHTML;
	    var mywindow = window.open('', 'Print');
	    mywindow.document.open();

	    mywindow.document.write('<html><head><title>Print</title>');
	    mywindow.document.write('</head><body onload = "window.print()"><table border="1">');
	    mywindow.document.write(content);
	    mywindow.document.write('</table></body></html>');

	    mywindow.document.close();
	    mywindow.focus()
	    mywindow.print();
	    mywindow.close();

	    setTimeout(function(){mywindow.close();},10);
	})
</script>
@endsection



