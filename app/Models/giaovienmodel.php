<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;


class giaovienmodel extends Model
{
    public function danhsachgiaovien()
    {
    	$arrGiaoVien = DB::table('giaovien')->where([
            'trangthai' =>1
        ])->get();
    	return $arrGiaoVien;
    }
    public function danhsachgiaovienAll()
    {
        $arrGiaoVien = DB::table('giaovien')->where([
            'trangthai' =>1
        ])->get();
        return $arrGiaoVien;
    }
    public function danhsachgiaovientheotukhoa($tukhoa)
    {
        $arrGiaoVien = DB::table('giaovien')->where([
            'trangthai' =>1,
            'magiaovien'=>$tukhoa
        ])->get();
        return $arrGiaoVien;
    }
    public function getgiaovien($magiaovien)
    {
    	$objGv =DB::table('giaovien')->where([
            'trangthai' =>1,
            'magiaovien'=>$magiaovien
        ])->first();
    	return $objGv;
    }
    public function getgiaovientheotaikhoan($taikhoan)
    {
       $objGv =DB::table('giaovien')->where([
            'trangthai' =>1,
            'taikhoan'=>$taikhoan
        ])->first();
        return $objGv;
    }
    public function themgiaovien($objGv)
    {
    	 DB::table('giaovien')->insert([
            'tengiaovien'  => $objGv->tengiaovien,
            'gioitinh'  => $objGv->gioitinh,
            'ngaysinh'  => $objGv->ngaysinh,
            'diachi'    => $objGv->diachi,
            'lienhe'    => $objGv->lienhe,
            'taikhoan'  => $objGv->taikhoan,
            'matkhau'   => $objGv->matkhau,
            'email'     => $objGv->email,
            ]);
    }
    public function suagiaovien($objGv)
    {
    	DB::table('giaovien')->where([
             'magiaovien'=>$objGv->magiaovien
        ])->update([
            'tengiaovien'  => $objGv->tengiaovien,
            'gioitinh'  => $objGv->gioitinh,
            'ngaysinh'  => $objGv->ngaysinh,
            'diachi'    => $objGv->diachi,
            'lienhe'    => $objGv->lienhe,
            'taikhoan'  => $objGv->taikhoan,
            'matkhau'   => $objGv->matkhau,
            'email'     => $objGv->email,
        ]);
    }
    public function xoagiaovien($magiaovien)
    {
    	DB::table('giaovien')->where([
             'magiaovien'=>$magiaovien,
        ])->update([
            'trangthai' =>0,
        ]);
    }
}
