<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;

class adminmodel extends Model
{
    public function danhsachadmin()
    {
    	$arrAdmin = DB::table('admin')->where('trangthai','=',1)->get();
    	return $arrAdmin;
    }
    public function getadmin($maadmin)
    {
    	$arrAdmin = DB::table('admin')->where([
            'trangthai' =>1,
            'maadmin'   =>$maadmin
        ])->first();
    	return $arrAdmin;
    }
    public function danhsachadmintheotukhoa($tukhoa)
    {
        $arrAdmin = DB::table('admin')->where([
            'trangthai' => 1,
            'maadmin'   => $tukhoa,
        ])->get();
        return $arrAdmin;
    }
     public function getadminbytaikhoan_index($taikhoan)
    {
        $arrAdmin = DB::select("select * from admin where trangthai = 1 and taikhoan = '$taikhoan' ");
        return $arrAdmin[0];
    }
    public function getadminbytaikhoan($taikhoan)
    {
        $arrAdmin = DB::select("select * from admin where trangthai = 1 and taikhoan = '$taikhoan->taikhoan' and matkhau = '$taikhoan->matkhau' ");
        return $arrAdmin;
    }
    public function themadmin($objAd)
    {
        DB::table('admin')->insert([
            'tenadmin'  => $objAd->tenadmin,
            'gioitinh'  => $objAd->gioitinh,
            'ngaysinh'  => $objAd->ngaysinh,
            'diachi'    => $objAd->diachi,
            'lienhe'    => $objAd->lienhe,
            'taikhoan'  => $objAd->taikhoan,
            'matkhau'   => $objAd->matkhau,
            'email'     => $objAd->email,
            ]);
    	
    }
    public function suaadmin($objAd)
    {
        DB::table('admin')->where([
            'maadmin'   => $objAd->maadmin,
        ])->update([
            'tenadmin'  => $objAd->tenadmin,
            'gioitinh'  => $objAd->gioitinh,
            'ngaysinh'  => $objAd->ngaysinh,
            'diachi'    => $objAd->diachi,
            'lienhe'    => $objAd->lienhe,
            'taikhoan'  => $objAd->taikhoan,
            'matkhau'   => $objAd->matkhau,
            'email'     => $objAd->email,
        ]);
    }
    public function xoaadmin($maadmin)
    {
    	 DB::table('admin')->where([
            'maadmin'   => $maadmin,
        ])->update([
            'trangthai'=> 0,
        ]);
    	
    }
}
