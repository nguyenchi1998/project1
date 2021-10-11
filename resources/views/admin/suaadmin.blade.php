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
                    <form action="{{route('suaadminprocess')}}" method="post" class="form-valide" id="formsuaadmin">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_ma">Mã số</label>
                                        <input type="text" id="val_ma" readonly name="txtMaAdmin" class="form-control" value="{{$objAd->maadmin}}"> 
                                    </div>
                                </div>
                             </div>
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_ten">Họ tên</label>
                                        <input type="text" required id="val_ten" name="txtTenAdmin" class="form-control" placeholder="Nhập tên" 
                        value="{{$objAd->tenadmin}}">
                                    </div>
                                </div>                           
                             </div>
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_gioitinh">Giới tính</label>
                                        <div class="form-check">
                                            <label class="custom-control custom-radio">
                                                <input type="radio" @if($objAd->gioitinh==0) checked @endif  name="rdoGioiTinh" value="0" class="form-check-input">
                                                 <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Nam</span>
                                            </label>
                                            <label class="custom-control custom-radio">
                                                <input type="radio" @if($objAd->gioitinh==1) checked @endif  name="rdoGioiTinh" value="1" class="form-check-input">
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
                                        <input type="date" class="form-control"  name="txtNgaySinh" placeholder="dd/mm/yyyy" value="{{$objAd->ngaysinh}}">
                                    </div>
                                </div>                           
                             </div>
                              <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_lienhe">Liên hệ</label>
                                         <input type="text" id="val_lienhe" required name="txtLienHe" class="form-control" placeholder="Nhập số điện thoại" value="{{$objAd->lienhe}}">
                                    </div>
                                </div>                           
                             </div>
                              <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_ten">Địa chỉ</label>
                                        <input type="text" required for="val_ten" name="txtDiaChi" class="form-control" placeholder="Nhập địa chỉ" value="{{$objAd->diachi}}">
                                    </div>
                                </div>                           
                             </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_email">Email</label>
                                        <input type="email" id="val_email" required name="txtEmail" class="form-control" placeholder="Nhập email" value="{{$objAd->email}}">
                                    </div>
                                </div>                           
                             </div>
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"  for="val_taikhoan">Tài khoản</label>
                                        <input type="text" readonly id="val_taikhoan" name="txtTaiKhoan" class="form-control"  value="{{$objAd->taikhoan}}">
                                    </div>
                                </div>                           
                             </div>
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_matkhau">Mật khẩu</label>
                                        <input type="text" required id="val_matkhau" name="txtMatKhau" class="form-control" placeholder="Nhập mật khẩu" value="{{$objAd->matkhau}}">
                                    </div>
                                </div>                           
                             </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Lưu</button>
                            <a href="{{route('danhsachadmin')}}" class="btn btn-danger btn-fill btn-wd">Hủy</a>
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
        $("#formsuaadmin").validate({
            rules: {
                "txtTenAdmin": {
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
                "txtTenAdmin": {
                    required: "Nhập tên quản trị viên",
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

