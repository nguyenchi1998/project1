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
                    <form action="{{route('suagiaovienprocess')}}" method="post" class="form-valide" id="formsualop">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_ma">Mã lớp</label>
                                        <input type="text" readonly name="txtMaLop" class="form-control" value="{{$objLop->malop}}">
                                    </div>
                                </div>
                             </div>
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_ten">Tên lớp</label>
                                         <input type="text" required name="txtTenLop" class="form-control" placeholder="Nhập tên" value="{{$objLop->tenlop}}">
                                    </div>
                                </div>                           
                             </div>
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_chuyennganh">Chuyên ngành</label>
                                        <select class="form-control" id="val_chuyennganh" name="txtChuyenNganh">
                                            <option hidden value="">Chọn chuyên ngành</option>
                                            @foreach($arrChuyenNganh as $objChuyennganh)
                                            <option @if($objLop->machuyennganh==$objChuyennganh->machuyennganh) selected @endif value="{{$objChuyennganh->machuyennganh}}">{{$objChuyennganh->tenchuyennganh}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>                           
                             </div> 
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Lưu</button>
                            <a href="{{route('danhsachlop')}}" class="btn btn-danger btn-fill btn-wd">Hủy</a>
                        </div>
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
        $("#formsualop").validate({
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