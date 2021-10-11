@extends('master')
@section('title_page')
Thống kê theo sinh viên
@endsection
@section('title')
	<p>Thống kê theo sinh viên</p>
@endsection
@section('main')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
            	@if(!isset($mamonhoc)||isset($tukhoa))
                <form action="{{route('danhsachsinhvienthongke')}}" method="get"> 
                <div class="row">
                	<div class="col-lg-2">
                        <h3 class="text-info" for="val_ma" class="col-form-label" >Thông tin sinh viên</h3>
		            </div>
	                <div class="col-lg-4">                      	
                    	<input type="text" name="tukhoa" class="form-control" placeholder="Nhập mã sinh viên hoặc tên sinh viên" required value="<?php if(isset($tukhoa)) echo $tukhoa;?>" >
		            </div>
		            
		            <div class="col-lg-2">
		            	<button class="btn btn-success" type="submit">Xem</button>	
	                </div>   
	            </div>
	            </form>
	            @endif
                <div class="table-responsive m-t-40">
	    		@if(isset($arrSv))
	                <table class="table table-striped table-bordered"  >
		    			<thead>
							<tr>
								<th>Mã sinh viên</th>
								<th>Tên sinh viên</th>
								<th>Lớp</th>
								<th ></th>
							</tr>
						</thead>
						<tbody>
							@foreach($arrSv as $objSv)
							<tr>
								<td>{{$objSv->masinhvien}}</td>
								<td>{{$objSv->tensinhvien}}</td>
								<td>{{$objSv->tenlop}}</td>
								<td class="text-center">
									<form action="{{route('danhsachthongketheosinhvien')}}" method="get">
									<input type="hidden" name="masinhvien" value="{{$objSv->masinhvien}}">
									<input type="hidden" name="tukhoa" value="{{$tukhoa}}">
									<input type="hidden" name="mamonhoc" value="{{-1}}">
									<button class="btn btn-success">Chọn</button>
									</form>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				@endif
					@if(isset($arrDiem))
					<div class="row">
						<div class="col-lg-2">
							{{-- <form action="{{route('danhsachthongketheosinhvien')}}" method="get" > --}}
								<input type="hidden" name="masinhvien" value="{{$masinhvien}}" id="masinhvien">
								<input type="hidden" name="tukhoa" value="{{$tukhoa}}">
				            	<select class="form-control" required name="mamonhoc"{{--  onchange="submit()" --}} id="mamonhoc">
			            			<option hidden value="">Chọn môn học</option>
			            			<option @if(isset($mamonhoc)&&$mamonhoc==-1) selected @endif value="-1">Tất cả</option>
			            			@foreach($arrMonHoc as $objMonHoc)
			            				<option @if(isset($mamonhoc)&&$mamonhoc==$objMonHoc->mamonhoc) selected @endif value="{{$objMonHoc->mamonhoc}}">{{$objMonHoc->tenmonhoc}}</option>
			            			@endforeach
			            		</select>
		            		{{-- </form> --}}
			            </div>
			            <div class="col-lg-2">
			            	<a  id="btnXuatExcel" href="{{route('danhsachthongketheosinhvien_xuatexcel',['masinhvien'=>$masinhvien,'mamonhoc'=>$mamonhoc,'arrDiem'=>$arrDiem])}}" class="btn btn-secondary">Xuất Excel</a>
			            	<a  id="btnPrint" class="btn btn-secondary">In File</a>
			            </div>
		        	</div>
					<table class="table table-striped table-bordered" id="thongketheosinhvien">
						<thead>
							<tr>
								<th>Mã sinh viên</th>
								<th>Tên sinh viên</th>
								<th>Lớp</th>
								<th>Môn học</th>
								<th>Final 1</th>
								<th>Skill 1</th>
								<th>Final 2</th>
								<th>Skill 2</th>
								<th>Kết quả</th>
							</tr>
						</thead>	
							<tbody>
							@foreach($arrDiem as $objDiem)
							<tr>
								<td>{{$objDiem->masinhvien}}</td>
								<td>{{$objDiem->tensinhvien}}</td>
								<td>{{$objDiem->tenlop}}</td>
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
							</tr>
							@endforeach
						</tbody>
					</table>
				@endif	
             </div>
            </div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script type="text/javascript">
	$(document).ready(function() {
	    $('#thongketheosinhvien').DataTable();
	});
</script>
<script type="text/javascript">
	$("#mamonhoc").change(function(){
	    var mamonhoc = $("#mamonhoc").val();
	    var masinhvien = $("#masinhvien").val();
	    var token = $('input[name=_token]').val();
	    var url = "{{route('danhsachthongketheosinhvien_json')}}";
	    var table = $("#thongketheosinhvien tbody");
	    var index = 0;
	    $.ajax({
	      	url: url,
		    headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
		    method: 'GET',
		    dataType : 'json',
		    data: { 'mamonhoc': mamonhoc, 'masinhvien': masinhvien, '_token': token},
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
			                 "<td>" + b.tenmonhoc + "</td>" +
			                "<td>" + b.finalmot + "</td>" +
		                    "<td>" + b.skillmot + "</td>" +
		                    "<td>" + finalhai + "</td>" +
		                    "<td>" + skillhai + "</td>" +
		                    "<td style='font-weight: bold'>" + kq + "</td></tr>");
			    });
			    if(index > 0)
				{
					$("#btnXuatExcel").show();
					$("#btnPrint").show();
			    }
			    else
			    {
			    	$("#btnXuatExcel").hide();
					$("#btnPrint").hide();
			    }
			}
	    });
	});
</script>
<script type="text/javascript">
	$("#btnPrint").click(function(){
		var content = document.getElementById("thongketheosinhvien").innerHTML;
	    var mywindow = window.open('', 'Print');
	    mywindow.document.open();

	    mywindow.document.write('<html><head><title>Helo</title>');
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






