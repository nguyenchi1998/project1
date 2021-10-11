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
                    <form action="{{route('themchuyennganhprocess')}}" method="post" class="form-valide" id="formthemchuyennganh">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-body">
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_ten" >Tên chuyên ngành</label>
                                        <input type="text" id="val_ten" name="txtTenchuyennganh" class="form-control" placeholder="Nhập tên chuyên ngành" value="{{old('txtTenchuyennganh')}}">
                                    </div>
                                </div>                           
                             </div> 
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Lưu</button>
                            <a href="{{route('danhsachchuyennganh')}}" class="btn btn-danger btn-fill btn-wd">Hủy</a>
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
        $("#formsuachuyennganh").validate({
            rules: {
                "txtTenchuyennganh": {
                    required: true,
                },
            },
            messages: {
                "txtTenchuyennganh": {
                    required: "Nhập tên chuyên ngành",
                }
            }
        });
    });
</script>
@endsection