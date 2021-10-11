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
                    <form action="{{route('themmonhocprocess')}}" method="post" class="form-valide" id="formthemmonhoc">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="val_ten">Tên môn học</label>
                                        <input type="text" id="val_ten" name="txtTenMonHoc" class="form-control" placeholder="Nhập tên môn học">
                                    </div>
                                </div>
                             </div>
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" >Chuyên ngành</label>
                                        <div class="checkbox form-check">
                                        @foreach($arrChuyennganh as $objChuyennganh)
                                            <input type="checkbox" id="{{$objChuyennganh->machuyennganh}}" name="cbChuyenNganh[]" value="{{$objChuyennganh->machuyennganh}}">
                                            <label for="{{$objChuyennganh->machuyennganh}}" >{{$objChuyennganh->tenchuyennganh}}</label>
                                        @endforeach
                                        </div>
                                    </div>
                                </div>                           
                             </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Lưu</button>
                            <a href="{{route('danhsachmonhoc')}}" class="btn btn-danger btn-fill btn-wd">Hủy</a>
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
        $("#formthemmonhoc").validate({
            rules: {
                "txtTenMonHoc": {
                    required: true,
                },
            },
            messages: {
                "txtTenMonHoc": {
                    required: "Nhập tên môn học",
                },
            }
        });
    });
</script>
@endsection