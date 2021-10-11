<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;

class sinhvienmodel extends Model
{
    public  function danhsachsinhvien()
    {
    	// $arrSV = DB::select("select * from sinhvien where trangthai = 1");
        $arrSV = DB::select("select *, sinhvien.malop from sinhvien inner join lop on sinhvien.malop = lop.malop where sinhvien.trangthai = 1 ");
         $arrSV = DB::table('sinhvien')->join('lop','sinhvien.malop','lop.malop')->where([
            'sinhvien.trangthai'=>1,
         ])->get();
    	return $arrSV;
    }
    public  function danhsachsinhvientheotukhoa($tukhoa)
    {
        $arrSV = DB::select("select * from sinhvien inner join lop on sinhvien.malop = lop.malop where sinhvien.trangthai = 1 and sinhvien.masinhvien = '$tukhoa' or sinhvien.tensinhvien like '%$tukhoa%' ");
        return $arrSV;
    }
    public function danhsachsinhvientheolop($malop)
    {
        $arrSV = DB::select("select *  from sinhvien inner join lop on sinhvien.malop = lop.malop where sinhvien.trangthai = 1 and lop.malop = '$malop' ");
        return $arrSV;
    }
    public function getsinhvien($masinhvien)
    {
    	$objSv = DB::table('sinhvien')->join('lop','sinhvien.malop','lop.malop')->where([
            'sinhvien.trangthai'=>1,
            'sinhvien.masinhvien'=>$masinhvien,
         ])->first();
    	return $objSv;
    }
     public function getsinhvientheotaikhoan($taikhoan)
    {
        $objSv = DB::select("select * from sinhvien inner join lop on sinhvien.malop = lop.malop where  sinhvien.taikhoan = '$taikhoan' and  sinhvien.trangthai = 1 ");
        return $objSv;
    }
    public function xoasinhvien($masinhvien)
    {
    	DB::update("update sinhvien set trangthai = 0 where masinhvien = '$masinhvien' ");
        
    }
    public function suasinhvien($objSv)
    {
        DB::update("Update sinhvien set tensinhvien = '$objSv->tensinhvien'  , gioitinh = '$objSv->gioitinh' , ngaysinh = '$objSv->ngaysinh', diachi = '$objSv->diachi' , email = '$objSv->email' , lienhe = '$objSv->lienhe' , malop = '$objSv->malop' , taikhoan = '$objSv->taikhoan' , matkhau = '$objSv->matkhau' where masinhvien = '$objSv->masinhvien' ");
        
    }
    public function themsinhvien($objSv)
    {
        DB::insert("insert into sinhvien(tensinhvien,ngaysinh,gioitinh,diachi,email,lienhe,malop,taikhoan,matkhau) values('$objSv->tensinhvien','$objSv->ngaysinh','$objSv->gioitinh','$objSv->diachi','$objSv->email','$objSv->lienhe','$objSv->malop','$objSv->taikhoan','$objSv->matkhau')");
    }
}
