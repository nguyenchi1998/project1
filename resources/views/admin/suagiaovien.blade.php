@extends('master')
@section('title')
    <p>Thông tin cơ bản</p>
@endsection
@section('main')
@if (count($errors) > 0)
      <div class="alert alert-danger">
         Có lỗi xuất hiện trong quá trình !!
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
@endif
<div class="row">
    <div class="col-lg-12">
        <div class="card card-outline-primary">
            <div class="card-body">
                <div class="form-validation">
                    <form action="{{route('suagiaovienprocess')}}" method="post" class="form-valide" id="formsuagiaovien">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_ma">Mã giáo viên</label>
                                        <input type="text" readonly name="txtMagiaovien" class="form-control" value="{{$objGV->magiaovien}}">
                                    </div>
                                </div>
                             </div>
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_ten">Tên giáo viên</label>
                                         <input type="text" required name="txtTengiaovien" class="form-control" placeholder="Nhập tên" 
                    value="{{$objGV->tengiaovien}}">
                                    </div>
                                </div>                           
                             </div>
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_gioitinh">Giới tính</label>
                                        <div class="form-check">
                                            <label class="custom-control custom-radio">
                                                <input type="radio" @if($objGV->gioitinh==0) checked @endif  name="rdoGioiTinh" value="0" class="form-check-input">
                                                 <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Nam</span>
                                            </label>
                                            <label class="custom-control custom-radio">
                                                <input type="radio" @if($objGV->gioitinh==1) checked @endif  name="rdoGioiTinh" value="1" class="form-check-input">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Nữ</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>                           
                             </div>
                              <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_ngaysinh">Ngày sinh</label>
                                         <input type="date" required name="txtNgaySinh" value="{{$objGV->ngaysinh}}" class="form-control"  value="">
                                    </div>
                                </div>                           
                             </div>
                              <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_lienhe">Liên hệ</label>
                                           <input type="text" required name="txtLienHe" class="form-control" placeholder="Nhập số điện thoại" value="{{$objGV->lienhe}}">
                                    </div>
                                </div>                           
                             </div>
                              <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_ten">Địa chỉ</label>
                                        <input type="text" required name="txtDiaChi" class="form-control" placeholder="Nhập địa chỉ" value="{{$objGV->diachi}}">
                                    </div>
                                </div>                           
                             </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_email">Email</label>
                                        <input type="email" required name="txtEmail" class="form-control" placeholder="Nhập email" value="{{$objGV->email}}">
                                    </div>
                                </div>                           
                             </div>
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"  for="val_taikhoan">Tài khoản</label>
                                        <input type="text" readonly name="txtTaiKhoan" class="form-control"  value="{{$objGV->taikhoan}}">
                                    </div>
                                </div>                           
                             </div>
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_matkhau">Mật khẩu</label>
                                        <input type="text" required name="txtMatKhau" class="form-control" placeholder="Nhập mật khẩu" value="{{$objGV->matkhau}}">
                                    </div>
                                </div>                           
                             </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Lưu</button>
                            <a href="{{route('danhsachgiaovien')}}" class="btn btn-danger btn-fill btn-wd">Hủy</a>
                        </div>
                    </form>
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
        $("#formsuagiaovien").validate({
            rules: {
                "txtTengiaovien": {
                    required: true,
                },
                "rdoGioiTinh":{
                    required: true,
                },
                "txtNgaySinh":{
                    required: true,
                },
                "txtLienHe":{
                    required: true,
                    validatePhone:true

                },
                "txtDiaChi":{
                    required: true,
                },
                "txtEmail":{
                    required: true,
                    email:true
                },
                "txtTaiKhoan":{
                    required: true,
                },
                "txtMatKhau":{
                    required: true,
                }
            },
            messages: {
                "txtTengiaovien": {
                    required: "Nhập tên giáo viên",
                },
                "rdoGioiTinh":{
                    required: "Nhập tên giáo viên",
                },
                "txtNgaySinh":{
                    required: "Chọn ngày sinh",
                },
                "txtLienHe":{
                    required: "Nhập số điện thoại",
                    validatePhone:"Nhập đúng định dạng số điện thoại"
                },
                "txtDiaChi":{
                     required: "Nhập địa chỉ",
                },
                "txtEmail":{
                    required: "Nhập email",
                    email: "Nhập đúng định dạng email"
                },
                "txtTaiKhoan":{
                     required: "Nhập tài khoản",
                },
                "txtMatKhau":{
                    required: "Nhập mật khẩu",
                }
            }
        });
        $.validator.addMethod("validatePhone", function (value, element) {
            return this.optional(element) || /^(09|01[2|6|8|9])+([0-9]{7,8})$/i.test(value);
        });
    });
</script>
@endsection