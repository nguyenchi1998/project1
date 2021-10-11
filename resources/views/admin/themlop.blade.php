@extends('master')
@section('title')
    <p>Thông tin cơ bản</p>
@endsection
@section('main')
<div class="row">
    <div class="col-lg-12">
        <div class="card card-outline-primary">
            <div class="card-body">
                <div class="form-validation">
                   <form class="form-horizontal" action="{{route('themlopprocess')}}" method="post" id="formthemlop">
                   	<input type="hidden" name="_token" value="{{csrf_token()}}">
                     	<div class="form-group row">
                          <div class="col-md-2">
                              <label class="control-label">Tên Lớp</label>
                          </div>
                          <div class="col-md-10">
                              <input type="text"  name="txtTenLop" class="form-control" placeholder="Nhập tên" 
                              value="{{old('txtTenLop')}}">
                          </div>
                      </div>
                      <div class="form-group row">
                          <div class="col-md-2">
                              <label class="control-label">Chuyên ngành</label>
                          </div>
                          <div class="col-md-10">
                             <select class="form-control" required name="txtChuyenNganh">
          	            		<option hidden value="">Chọn chuyên ngành</option>
          	            		@foreach($arrChuyenNganh as $objChuyennganh)
          	            		<option value="{{$objChuyennganh->machuyennganh}}">{{$objChuyennganh->tenchuyennganh}}</option>
          	            		@endforeach
          	            	</select>
                          </div>
                      </div>                                       
                       <div class="text-center">
                           <button type="submit" class="btn btn-info btn-fill btn-wd">Thực thi</button>
                           <a href="{{route('danhsachlop')}}" class="btn btn-danger btn-fill btn-wd">Hủy</a>
                       </div>
                      <div class="clearfix"></div>
                   </form>
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
        //Khi bàn phím được nhấn và thả ra thì sẽ chạy phương thức này
        $("#formthemlop").validate({
            rules: {
                "txtTenLop": {
                    required: true,
                },
                "txtChuyenNganh": {
                    required: true,
                },
            },
            messages: {
                "txtTenLop": {
                    required: "Nhập tên lớp",
                },
                "txtChuyenNganh": {
                    required: "Chọn chuyên ngành",
                },
            }
        });
    });
</script>
@endsection