@extends('master')
@section('title')
    <p >Môn {{$objMonHoc->tenmonhoc}}</p>
    <p >Lớp {{$objLop->tenlop}}</p>
@endsection
@section('main')
<div class="row">
    <div class="col-lg-12">
        <div class="card card-outline-primary">
            <div class="card-body">
                <div class="form-validation">
                    <form action="{{route('suadiemprocess')}}" method="post" class="form-valide" id="formsuadiem">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="malich" value="{{$malich}}">
                        <input type="hidden" name="maLop" value="{{$objLop->malop}}">
                        <input type="hidden" name="mamonhoc" value="{{$objMonHoc->mamonhoc}}">
                        <input type="hidden" name="masinhvien" value="{{$objSv->masinhvien}}">
                        <div class="form-body">
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_ten">Tên sinh viên</label>
                                         <input type="text" readonly name="txtMaSinhVien" class="form-control" value="{{$objSv->tensinhvien}}">
                                    </div>
                                </div>                           
                             </div>
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_final1">Điểm Final</label>
                                        <input type="text" name="txtFinal1" id="val_final1" placeholder="Nhập điểm final lần 1" class="form-control" value="{{$objDiem->finalmot}}">
                                    </div>
                                </div>                           
                             </div>
                              <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_skill1">Điểm Skill</label>
                                          <input type="text"  name="txtSkill1" id="val_skill1" value="{{$objDiem->skillmot}}" class="form-control" placeholder="Nhập điểm skill lần 1">
                                    </div>
                                </div>                           
                             </div>
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_final2">Điểm Final lần 2</label>
                                        <input type="text" name="txtFinal2" id="val_final2" placeholder="Nhập điểm final lần 2" class="form-control" value="{{$objDiem->finalhai}}">
                                    </div>
                                </div>                           
                             </div>
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_skill2">Điểm Skill lần 2</label>
                                        <input type="text" name="txtSkill2" id="val_skill2" class="form-control" placeholder="Nhập điểm skill lần 2" value="{{$objDiem->skillhai}}"> 
                                    </div>
                                </div>                           
                             </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-info btn-fill btn-wd">Thực thi</button>
                            <a href="{{route('giaovien.viewchonlopvamonhoc',['malop'=>$objLop->malop])}}" class="btn btn-danger btn-fill btn-wd">Hủy</a>
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
        $("#formsuadiem").validate({
            rules: {
                "txtFinal1": {
                    required: true,
                    range: [0, 10]
                },
                "txtSkill1": {
                    required: true,
                    range: [0, 10]
                },
                "txtFinal2": {
                    range: [0, 10]
                 },
                "txtSkill2": {
                        range: [0, 10]
                }
             },
            messages: {
                "txtFinal1": {
                    required: "Chưa nhập điểm Final",
                    range: "Nhập điểm từ 0 đến 10"
                },
                "txtSkill1": {
                    required: "Chưa nhập điểm Skill",
                    range: "Nhập điểm từ 0 đến 10"
                },
                "txtFinal2": {
                    range: "Nhập điểm từ 0 đến 10"
                },
                "txtSkill2": {
                    range: "Nhập điểm từ 0 đến 10"
                },
            }
        });
    });
</script>
@endsection


