@extends('master')
@section('title')
    <p>Sửa lịch học</p>
@endsection
@section('main')
<div class="row">
    <div class="col-lg-12">
        <div class="card card-outline-primary">
            <div class="card-body">
                <div class="form-validation">
                    <form action="{{route('sualichprocess')}}" method="post" class="form-valide" id="formsualich">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="malich" value="{{$objLich->malich}}">
                        <input type="hidden" name="malop" value="{{$objLop->malop}}">
                        <input type="hidden" name="mamonhoc" value="{{$objLich->mamonhoc}}">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h4 class="modal-title text-primary">Lớp {{$objLop->tenlop}}</h4>
                                    </div>
                                </div>        
                             </div> 
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h4 class="modal-title text-primary">Môn {{$objMonhoc->tenmonhoc}}</h4>
                                    </div>
                                </div>
                             </div>                            
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_matkhau">Giáo viên</label>
                                        <select class="form-control"  name="txtMaGiaoVien">
                                            <option hidden value="">Chọn giáo viên</option>
                                            @foreach($arrGiaoVien as $objGiaoVien)
                                            <option value="{{$objGiaoVien->magiaovien}}" @if($objLich->magiaovien==$objGiaoVien->magiaovien) selected  @endif >{{$objGiaoVien->tengiaovien}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>                           
                             </div>
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_matkhau">Thời gian bắt đầu</label>
                                        <input type="date" name="thoigianbatdau" value="{{$objLich->thoigianbatdau}}" class="form-control">
                                    </div>
                                </div>                           
                             </div>
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_matkhau">Thời gian kết thúc</label>
                                        <input type="date" name="thoigianketthuc" value="{{$objLich->thoigianketthuc}}" class="form-control">
                                    </div>
                                </div>                           
                             </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Thực thi</button>
                            <a href="{{route('admin.danhsachlich',['sltLop'=>$objLop->malop])}}" class="btn btn-danger btn-fill btn-wd">Hủy</a>
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
        $("#formsualich").validate({
            rules: {
                "txtMaGiaoVien": {
                    required: true,
                },
                "thoigianbatdau":{
                    required: true,
                },
                "thoigianketthuc":{
                    required: true,
                }
                
            },
            messages: {
                "txtMaGiaoVien": {
                    required: "Nhập tên quản trị viên",
                },
                "thoigianbatdau":{
                    required: "Chọn thời gian bắt đầu",
                },
                "thoigianketthuc":{
                    required: "Chọn thời gian kết thúc",
                }
            }
        });
    });
</script>
@endsection