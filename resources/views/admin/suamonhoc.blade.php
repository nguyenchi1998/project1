@extends('master')
@section('main')

<div class="col-lg-12 ">
    <div class="card">
        <div class="header">
             <h4 class="title">Thông tin</h4>
         </div>
    <div class="content">
         <form class="form-horizontal" action="{{route('themmonhocprocess')}}" method="post">
         	<input type="hidden" name="_token" value="{{csrf_token()}}">
           	<div class="form-group row">
                <div class="col-md-2">
                    <label class="control-label">Tên môn học</label>
                </div>
                <div class="col-md-10">
                    <input type="text" required name="txtTenMonHoc" class="form-control" placeholder="Nhập tên môn học" value="">
                </div>
            </div>
        	<div class="form-group row">
                <div class="col-md-2">
                    <label class="control-label">Chuyên ngành</label>
                </div>
                <div class="col-md-10">
                	@foreach($arrChuyennganh as $objChuyennganh)
                    	<label><input type="checkbox" name="cbChuyenNganh[]" value="{{$objChuyennganh->machuyennganh}}"> {{$objChuyennganh->tenchuyennganh}}</label>
                    @endforeach
                </div>
            </div>                           
             <div class="text-center">
                 <button type="submit" class="btn btn-info btn-fill btn-wd">Thực thi</button>
                 <a href="{{route('danhsachmonhoc')}}" class="btn btn-danger btn-fill btn-wd">Hủy</a>
             </div>
            <div class="clearfix"></div>
         </form>
    </div>
</div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        //Khi bàn phím được nhấn và thả ra thì sẽ chạy phương thức này
        $("#formthemmonhoc").validate({
            rules: {
                "txtTenMonHoc": {
                    required: true,
                },
            },
            messages: {
                "txtTenMonHoc": {
                    required: "Nhập tên môn học",
                },
            }
        });
    });
</script>
@endsection