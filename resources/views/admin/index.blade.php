@extends('master')
@if(Session::has('alertSuccessDoiMatKhau'))
<script type="text/javascript">
	alert("{{Session::get('alertSuccessDoiMatKhau')}}");
</script>
@endif
@if(Session::has('alertErrorDoiMatKhau'))
<script type="text/javascript">
	alert("{{Session::get('alertErrorDoiMatKhau')}}");
</script>
@endif
@section('title_page')
Trang Chủ
@endsection
@section('center')
<h3 class="text text-capitalize text-info">Quản lí điểm BKACAD</h3>
@endsection
@section('main')
	<div class="alert alert-info alert-dismissible fade show">
	    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	    <strong class="text-danger">Xin chào,</strong> Quản trị viên {{$objAd->tenadmin}} !
	</div>
	<div class="row">
		<div class="col-md-3">
			<a href="{{route('danhsachgiaovien')}}" >
            <div class="card bg-danger p-20">
                <div class="media widget-ten">
                    <div class="media-left meida media-middle">
                        <span><i class="fa fa-users f-s-40"></i></span>
                    </div>
	                <div class="media-body media-text-right">
	                     <h2 class="color-white">{{$sogiaovien}}</h2>
	                     <p class="m-b-0">Giáo viên</p>
	                </div>
                </div>
            </div>
        	</a>
        </div>
        <div class="col-md-3">
        	<a href="{{route('danhsachmonhoc')}}">
            <div class="card bg-warning p-20">
                <div class="media widget-ten">
                    <div class="media-left meida media-middle">
                        <span><i class="fa fa-book f-s-40"></i></span>
                    </div>
	                <div class="media-body media-text-right">
	                     <h2 class="color-white">{{$somonhoc}}</h2>
	                     <p class="m-b-0">Môn hoc</p>
	                </div>
                </div>
            </div>
         	</a>
        </div>
        <div class="col-md-3">
        	<a href="{{route('danhsachlop')}}">
            <div class="card bg-primary p-20">
                <div class="media widget-ten">
                    <div class="media-left meida media-middle">
                        <span><i class="fa fa-university f-s-40"></i></span>
                    </div>
	                <div class="media-body media-text-right">
	                     <h2 class="color-white">{{$solop}}</h2>
	                     <p class="m-b-0">Lớp</p>
	                </div>
                </div>
            </div>
        	</a>
        </div>
        <div class="col-md-3">
        	<a href="{{route('danhsachsinhvien')}}">
            <div class="card bg-info p-20">
                <div class="media widget-ten">
                    <div class="media-left meida media-middle">
                        <span><i class="fa fa-graduation-cap f-s-40"></i></span>
                    </div>
	                <div class="media-body media-text-right">
	                     <h2 class="color-white">{{$sosinhvien}}</h2>
	                     <p class="m-b-0">Sinh viên</p>
	                </div>
                </div>
            </div>
        	</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-title">
                    <h4>Biểu đồ</h4>
                </div>
                <div class="sales-chart">
                    <canvas id="bar-chart" width="800" height="450"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6" >
            <div class="card" >
                <div class="row">
                	<div class="col-lg-3">
                    	<h3 class="card-title" >Thông báo</h3>
                	</div>
                	<div class="col-lg-6">
                    	<select id="malop" name="malop">
                    		<option>--Chọn Lớp--</option>
                    		@foreach($arrLopTrongLich as $obj)
                    		<option value="{{$obj->malop}}">{{$obj->tenlop}}</option>
                    		@endforeach
                    	</select>
                	</div>
                </div>
                <div class="recent-comment" style="min-height: 340px;max-height: 340px" id="thongbao">
                	
					{{-- <div class="media">
						<div class="media-left">
							<a href="#"><img alt="..." src="{{asset('img/user.png')}}" class="media-object"></a>
						</div>
						<div class="media-body">
							<h4 class="media-heading">Giáo viên</h4>
							<p>Đã hoàn thành điểm môn </p>
							<p class="comment-date">{{date("d/m/Y")}}</p>
						</div>
					</div> chứa tối da 4 thông báo --}}
				</div>
            </div>
        </div>
    </div>
    <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body"> This is some text within a card block. </div>
                        </div>
                    </div>
                </div>

@endsection
@section('script')
<script type="text/javascript">
	new Chart(document.getElementById("bar-chart"), {
	    type: 'bar',
	    data: {
	      labels: ['BKC01','BKC02','BKC03','BKC04','BKC05','BKC06','BKC07','BKC08','BKC09'],
	      datasets: [
	        {
	          label: "Tỉ lệ",
	          backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#c45850",,"#c45c50","#c15850",,"#c43840"],
	          data: [99,23,14,56,45,43,10,4,98]
	        }
	      ]
	    },
	    options: {
	      legend: { display: false },
	      title: {
	        display: true,
	        text: 'Tỉ lệ sinh viên qua môn của các lớp (%)'
	      }
	    }
	});
</script>
<script type="text/javascript">
	$("#malop").change(function(){
		var malop = $(this).val();
		var token = $('input[name=_token]').val();
	    var url="{{route("admin.thongbao")}}";
	    $.ajax({
	    	url: url,
		    headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
		    method: 'GET',
		    dataType : 'json',
		    data: {'malop': malop, '_token': token},
		    success: function(data) {
				$("#thongbao").empty();
		        $.each(data, function (a, b) {
		            $("#thongbao").append("<div class='media'>" +
						"<div class='media-left'>" +
							"<a href=''><img alt='' src='{{asset('img/user.png')}}' class='media-object'></a>" +
						"</div>"+
						"<div class='media-body'>"+
							"<h4 class='media-heading'>G.viên:  "+ b.tengiaovien+"</h4>"+
							"<p>Đã hoàn thành điểm môn: "+ b.tenmonhoc +" </p>"+
							"<p class='comment-date'>Lớp: "+ b.tenlop +"</p>"+
						"</div>"+
					"</div>");
		        });
			}
	    });
	});
</script>
@endsection


