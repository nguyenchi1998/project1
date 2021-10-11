<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;

class monhocmodel extends Model
{
    public function danhsachmonhoc()
    {
        $arrMonHoc = DB::table('monhoc')->join('chuyennganh_monhoc','monhoc.mamonhoc','chuyennganh_monhoc.mamonhoc')->join('chuyennganh','chuyennganh_monhoc.machuyennganh','chuyennganh.machuyennganh')->where([
            'monhoc.trangthai'=>1
        ])->get();
    	return $arrMonHoc;
    }
    public function danhsachmonhoccualoptheogiaovien($malop, $magiaovien)
    {
        $arr = DB::select("select monhoc.mamonhoc as mamonhoc, monhoc.tenmonhoc as tenmonhoc from lichhoc join monhoc on lichhoc.mamonhoc = monhoc.mamonhoc where lichhoc.malop = '$malop' and lichhoc.magiaovien = '$magiaovien'");
        return $arr;
    }
    public function danhsachmonhoctronglichhoc($magiaovien)
    {
        $arrMonHoc = DB::table('lichhoc')->join('monhoc','lichhoc.mamonhoc','monhoc.mamonhoc')->where([
            'monhoc.trangthai'=>1,
            'lichhoc.magiaovien'=>$magiaovien
        ])->select(DB::raw('monhoc.mamonhoc,monhoc.tenmonhoc'))->groupBy('monhoc.mamonhoc','monhoc.tenmonhoc')->get();
        return $arrMonHoc;
    }
    public function danhsachmonhoctronglichhoctheochuyennganh($machuyennganh)
    {
        $arr = DB::table('monhoc')->join('lichhoc','lichhoc.mamonhoc','monhoc.mamonhoc')->join('chuyennganh_monhoc','monhoc.mamonhoc','chuyennganh_monhoc.mamonhoc')->join('chuyennganh','chuyennganh_monhoc.machuyennganh','chuyennganh.machuyennganh')->where([
            'monhoc.trangthai'=>1,
            'chuyennganh_monhoc.machuyennganh'=>$machuyennganh,
        ])->get();
        return $arr;
    }
    public function danhsachmonhoctheochuyennganh($machuyennganh)
    {
        $arrMonHoc = DB::table('monhoc')->join('chuyennganh_monhoc','monhoc.mamonhoc','chuyennganh_monhoc.mamonhoc')->join('chuyennganh','chuyennganh_monhoc.machuyennganh','chuyennganh.machuyennganh')->where([
            'monhoc.trangthai'=>1,
            'chuyennganh_monhoc.machuyennganh'=>$machuyennganh,
        ])->get();
        return $arrMonHoc;
    }
    public function getmonhoc($mamonhoc)
    {
    	$obj = DB::table('monhoc')->join('chuyennganh_monhoc','monhoc.mamonhoc','chuyennganh_monhoc.mamonhoc')->join('chuyennganh','chuyennganh_monhoc.machuyennganh','chuyennganh.machuyennganh')->where([
            'monhoc.mamonhoc'=>$mamonhoc,
        ])->first();
        return $obj;
    }
    public function danhsachmonhoctheochuyennganhAll($machuyennganh)
    {
        $arrMonHoc = DB::table('monhoc')->join('chuyennganh_monhoc','monhoc.mamonhoc','chuyennganh_monhoc.mamonhoc')->join('chuyennganh','chuyennganh_monhoc.machuyennganh','chuyennganh.machuyennganh')->where([
            'monhoc.trangthai'=>1,
            'chuyennganh_monhoc.machuyennganh'=>$machuyennganh,
        ])->get();
        return $arrMonHoc;
    }
    public function themmonhoc($objMonhoc, $arrChuyennganh)
    {
    	DB::table('monhoc')->insert([
            'tenmonhoc'=>$objMonhoc->tenmonhoc,
        ]);
        $arr = $arrChuyennganh;
        $objMonHoc = DB::table('monhoc')->select(DB::raw('MAX(mamonhoc) as mamonhoc'))->first();
        $ma = $objMonHoc->mamonhoc;
        for($i=0;$i<count($arr);$i++)
        {
            DB::table('chuyennganh_monhoc')->insert([
                'mamonhoc'=>$ma,
                'machuyennganh'=>$arr[$i],
            ]);
        }
    	
    }
    public function suamonhoc($objMonhoc)
    {
    	DB::update("update monhoc set tenmonhoc= '$objMonhoc->tenmonhoc', thoigianbatdau = '$objMonhoc->thoigianbatdau',thoigianketthuc = '$objMonhoc->thoigianketthuc', machuyennganh = '$objMonhoc->machuyennganh' where mamonhoc = '$objMonhoc->mamonhoc' ");
   
    }
    public function xoamonhoc($mamonhoc)
    {
    	DB::update("update monhoc set trangthai = 0 where mamonhoc = '$mamonhoc'");
    	
    }
}
