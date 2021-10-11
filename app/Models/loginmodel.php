<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;

class loginmodel extends Model
{
    public function loginAdmin($obj)
    {
    	$obj = DB::select("select * from admin where taikhoan = '$obj->taikhoan' and matkhau = '$obj->matkhau' and trangthai = 1 ");
    	return $obj;
    }
    public function loginSinhvien($obj)
    {
    	$obj = DB::select("select * from sinhvien where taikhoan = '$obj->taikhoan' and matkhau = '$obj->matkhau' and trangthai = 1 ");
    	return $obj;
    }
    public function loginGiaoVien($obj)
    {
    	$obj = DB::select("select * from giaovien where taikhoan = '$obj->taikhoan' and matkhau = '$obj->matkhau' and trangthai = 1");
    	return $obj;
    }
    public function doiMatKhauAdmin($tk)
    {
        DB::table('admin')->where([
            'taikhoan'=>$tk->taikhoan,
        ])->update([
            'matkhau'=>$tk->matkhau,
        ]);
    }
    public function doiMatKhauGiaoVien($tk)
    {
        DB::table('giaovien')->where([
            'taikhoan'=>$tk->taikhoan,
        ])->update([
            'matkhau'=>$tk->matkhau,
        ]);
    }
    public function doiMatKhauSinhVien($tk)
    {
        DB::table('sinhvien')->where([
            'taikhoan'=>$tk->taikhoan,
        ])->update([
            'matkhau'=>$tk->matkhau,
        ]);
    }
}
