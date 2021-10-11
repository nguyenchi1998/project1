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
                    <form action="{{route('suasinhvienprocess')}}" method="post" class="form-valide">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-body">
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_ten">Tên sinh viên</label>
                                         <input type="text" required name="txtTenSv" class="form-control" placeholder="Nhập tên" value="{{old('txtTenSv')}}">
                                    </div>
                                </div>                           
                             </div>
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_gioitinh">Giới tính</label>
                                        <div class="form-check">
                                            <label class="custom-control custom-radio">
                                                <input type="radio" @if(old('txtTaiKhoan')==0) checked @endif  name="rdoGioiTinh" value="0" class="form-check-input">
                                                 <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Nam</span>
                                            </label>
                                            <label class="custom-control custom-radio">
                                                <input type="radio" @if(old('txtTaiKhoan')==1) checked @endif  name="rdoGioiTinh" value="1" class="form-check-input">
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
                                         <input type="date" required name="txtNgaySinh" value="{{old('txtTaiKhoan')}}" class="form-control"  value="">
                                    </div>
                                </div>                           
                             </div>
                              <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_lienhe">Liên hệ</label>
                                           <input type="text" required name="txtLienHe" class="form-control" placeholder="Nhập số điện thoại" value="{{old('txtLienHe')}}">
                                    </div>
                                </div>                           
                             </div>
                              <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_ten">Địa chỉ</label>
                                        <input type="text" required name="txtDiaChi" class="form-control" placeholder="Nhập địa chỉ" value="{{old('txtDiaChi')}}">
                                    </div>
                                </div>                           
                             </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_email">Email</label>
                                        <input type="email" required name="txtEmail" class="form-control" placeholder="Nhập email" value="{{old('txtEmail')}}">
                                    </div>
                                </div>                           
                             </div>
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_email">Lớp</label>
                                        <select class="form-control" required name="sltLop">
                                            <option hidden value="">Chọn lớp</option>
                                        @foreach($arrLop as $objLop)
                                            <option @if(old('sltLop')==$objLop->malop) selected @endif value="{{$objLop->malop}}">{{$objLop->tenlop}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>                           
                             </div>
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label"  for="val_taikhoan">Tài khoản</label>
                                        <input type="text" name="txtTaiKhoan" placeholder="Nhập tài khoản" class="form-control" value="{{old('txtTaiKhoan')}}">
                                    </div>
                                </div>                           
                             </div>
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_matkhau">Mật khẩu</label>
                                        <input type="text" required name="txtMatKhau" class="form-control" placeholder="Nhập mật khẩu" value="{{old('txtMatKhau')}}">
                                    </div>
                                </div>                           
                             </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Lưu</button>
                            <a href="{{route('danhsachsinhvien')}}" class="btn btn-danger btn-fill btn-wd">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
{{-- <script type="text/javascript">
    var form_validation = function() {
        var e = function() {
                jQuery(".form-valide").validate({
                    ignore: [],
                    errorClass: "invalid-feedback animated fadeInDown",
                    errorElement: "div",
                    errorPlacement: function(e, a) {
                        jQuery(a).parents(".form-group").append(e)
                    },
                    highlight: function(e) {
                        jQuery(e).closest(".form-group").removeClass("is-invalid").addClass("is-invalid")
                    },
                    success: function(e) {
                        jQuery(e).closest(".form-group").removeClass("is-invalid"), jQuery(e).remove()
                    },
                    rules: {
                        "val_ten": {
                            required: !0,
                            minlength: 3
                        }, 
                    },
                    messages: {
                        "val_ten": {
                            required: "Hãy nhập tên quản trị viên",
                            minlength: "Tên phải chứa ít nhất 3 kí tự"
                        },
                        
                    }
                })
            }
        return {
            init: function() {
                e(), a(), jQuery(".js-select2").on("change", function() {
                    jQuery(this).valid()
                })
            }
        }
    }();
    jQuery(function() {
        form_validation.init()
    });
</script> --}}
@endsection


