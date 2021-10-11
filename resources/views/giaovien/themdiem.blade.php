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
                    <form action="{{route('themdiemprocess')}}" method="post" class="form-valide" id="formthemdiem">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="malich" value="{{$malich}}">
                        <input type="hidden" name="maLop" value="{{$objLop->malop}}">
                        <input type="hidden" name="mamonhoc" value="{{$objMonHoc->mamonhoc}}">
                        <div class="form-body">
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_ten">Tên sinh viên</label>
                                         <select class="form-control" required name="txtMaSinhVien">
                                            <option hidden value="">Chọn sinh viên</option>
                                            @foreach($arrSv as $objSv)
                                            <option @if(isset($mamonhoc)&&$mamonhoc==$objMonHoc->mamonhoc) selected @endif value="{{$objSv->masinhvien}}">{{$objSv->tensinhvien}} - Mã:  {{$objSv->masinhvien}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>                           
                             </div>
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_gioitinh">Điểm Final</label>
                                        <input type="text"  name="txtFinal" placeholder="Nhập điểm final"  class="form-control">
                                    </div>
                                </div>                           
                             </div>
                              <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_ngaysinh">Điểm Skill</label>
                                        <input type="text"  name="txtSkill" class="form-control" placeholder="Nhập điểm skill">
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
        //Khi bàn phím được nhấn và thả ra thì sẽ chạy phương thức này
        $("#formthemdiem").validate({
            rules: {
                "txtMaSinhVien":{
                    required: true,
                },
                "txtFinal": {
                    required: true,
                    range: [0, 10]
                },
                "txtSkill": {
                     required: true,
                    range: [0, 10]
                }
            },
            messages: {
                "txtMaSinhVien":{
                    required:"Chưa chọn sinh viên",
                },
                "txtFinal": {
                    required: "Chưa nhập điểm Final",
                    range: "Nhập điểm từ 0 đến 10"
                },
                "txtSkill": {
                    required: "Chưa nhập điểm Skill",
                    range: "Nhập điểm từ 0 đến 10"
                    },
            }
        });
    });
</script>
@endsection


