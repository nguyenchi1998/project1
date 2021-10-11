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
                    <form action="{{route('themadminprocess')}}" method="post" class="form-valide" id="formthemadmin">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-body">
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_ten">Họ tên</label>
                                        <input type="text" id="val_ten" name="txtTenAdmin" class="form-control" placeholder="Nhập tên" value="{{old('txtTenAdmin')}}">
                                    </div>
                                </div>                           
                             </div>
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_gioitinh">Giới tính</label>
                                        <div class="form-check">
                                            <label class="custom-control custom-radio">
                                                <input type="radio" @if(old('rdoGioiTinh')==0) checked @endif  name="rdoGioiTinh" value="0" class="form-check-input">
                                                 <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Nam</span>
                                            </label>
                                            <label class="custom-control custom-radio">
                                                <input type="radio" @if(old('txtEmail')==1) checked @endif  name="rdoGioiTinh" value="1" class="form-check-input">
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
                                        <input type="date" class="form-control" id="val_ngaysinh"  name="txtNgaySinh" placeholder="dd/mm/yyyy" value="{{old('txtNgaySinh')}}">
                                    </div>
                                </div>                           
                             </div>
                              <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_lienhe">Liên hệ</label>
                                         <input type="text" id="val_lienhe"  name="txtLienHe" class="form-control" placeholder="Nhập số điện thoại" value="{{old('txtLienHe')}}">
                                    </div>
                                </div>                           
                             </div>
                              <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_diachi">Địa chỉ</label>
                                        <input type="text" id="val_diachi" name="txtDiaChi" class="form-control" placeholder="Nhập địa chỉ" value="{{old('txtDiaChi')}}">
                                    </div>
                                </div>                           
                             </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_email">Email</label>
                                        <input type="email" id="val_email"  name="txtEmail" class="form-control" placeholder="Nhập email" value="{{old('txtEmail')}}">
                                    </div>
                                </div>                           
                             </div>
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"  for="val_taikhoan">Tài khoản</label>
                                        <input type="text"  id="val_taikhoan" name="txtTaiKhoan" class="form-control" placeholder="Nhập tài khoản"  value="{{old('txtTaiKhoan')}}">
                                    </div>
                                </div>                           
                             </div>
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_matkhau">Mật khẩu</label>
                                        <input type="text"  id="val_matkhau" name="txtMatKhau" class="form-control" placeholder="Nhập mật khẩu" value="{{old('txtMatKhau')}}">
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
        $("#formthemadmin").validate({
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

