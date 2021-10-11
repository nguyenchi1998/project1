@extends('master')
@section('title')
    <p>Thêm lịch học</p>
@endsection
@section('main')
<div class="row">
    <div class="col-lg-12">
        <div class="card card-outline-primary">
            <div class="card-body">
                <div class="form-validation">
                    <form action="{{route('themlichprocess')}}" method="post" class="form-valide" id="formthemlich">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="malop" value="{{$objLop->malop}}">
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
                                        <label class="control-label" for="val_ma">Môn học</label>
                                        <select class="form-control"  name="txtMaMonHoc">
                                            <option hidden value="">Chọn môn học</option>
                                            @foreach($arrMonHoc as $objMonHoc)
                                            <option value="{{$objMonHoc->mamonhoc}}" >{{$objMonHoc->tenmonhoc}}</option>
                                            @endforeach
                                        </select>
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
                                            <option value="{{$objGiaoVien->magiaovien}}" >{{$objGiaoVien->tengiaovien}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>                           
                             </div>
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_matkhau">Thời gian bắt đầu</label>
                                        <input type="date" name="thoigianbatdau" class="form-control">
                                    </div>
                                </div>                           
                             </div>
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_matkhau">Thời gian kết thúc</label>
                                        <input type="date" name="thoigianketthuc" class="form-control">
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
        $("#formthemlich").validate({
            rules: {
                "txtMaMonHoc": {
                    required: true,
                },
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
                "txtMaMonHoc": {
                    required: "Chọn môn học",
                },
                "txtMaGiaoVien": {
                    required: "Chọn giáo viên",
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


