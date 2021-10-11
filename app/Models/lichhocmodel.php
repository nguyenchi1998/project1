<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class lichhocmodel extends Model
{
    public function getLichHocTheoMon($mamonhoc)
    {
    	$obj = DB::table('lichhoc')->where([
    		'mamonhoc'=>$mamonhoc,
    	])->first();
    	return $obj;
    }
    public function getLichHocTheoMonVaLop($mamonhoc, $malop)
    {
        $obj = DB::table('lichhoc')->where([
            'mamonhoc'=>$mamonhoc,
            'malop'=>$malop,
        ])->first();
        return $obj;
    }
    public function getListMonHocChuaDayTheoLop($malop)
    {
    	$arr = DB::select("select monhoc.tenmonhoc, monhoc.mamonhoc from chuyennganh_monhoc 
            inner join monhoc on chuyennganh_monhoc.mamonhoc = monhoc.mamonhoc 
            inner join chuyennganh on chuyennganh_monhoc.machuyennganh = chuyennganh.machuyennganh 
            inner join lop on chuyennganh.machuyennganh = lop.machuyennganh 
            where monhoc.mamonhoc not in(SELECT monhoc.mamonhoc FROM `lichhoc` INNER join monhoc on lichhoc.mamonhoc = monhoc.mamonhoc INNER join chuyennganh_monhoc on lichhoc.mamonhoc = chuyennganh_monhoc.mamonhoc INNER join chuyennganh on chuyennganh_monhoc.machuyennganh = chuyennganh.machuyennganh INNER join lop on chuyennganh.machuyennganh = lop.machuyennganh where lop.malop = '$malop') and lop.malop = '$malop' and monhoc.trangthai = 1");
    	return $arr;
    }
    public function danhsachlich()
    {
    	$arr = DB::table('lichhoc')->join('monhoc','lichhoc.mamonhoc','monhoc.mamonhoc')->join('giaovien','lichhoc.magiaovien','giaovien.magiaovien')->join('lop','lichhoc.malop','lop.malop')->where([
    		'lichhoc.trangthai'=>1,
    	])->get();
    	return $arr;
    }
    public function danhsachlichtheolop($malop)
    {
       $arr = DB::table('lichhoc')->join('monhoc','lichhoc.mamonhoc','monhoc.mamonhoc')->join('giaovien','lichhoc.magiaovien','giaovien.magiaovien')->join('lop','lichhoc.malop','lop.malop')->where([
            'lichhoc.trangthai'=>1,
            'lichhoc.malop'=>$malop,
        ])->get();
        return $arr;
    }
    public function getLichHocTheoMaLich($malich)
    {
    	$obj = DB::table('lichhoc')->join('monhoc','lichhoc.mamonhoc','monhoc.mamonhoc')->where([
    		'malich'=>$malich,
    	])->first();
    	return $obj;
    }
    public function getLichHocTheoMaMonHoc($mamonhoc)
    {
        $obj = DB::table('lichhoc')->join('monhoc','lichhoc.mamonhoc','monhoc.mamonhoc')->where([
            'lichhoc.mamonhoc'=>$mamonhoc,
        ])->first();
        return $obj;
    }
    public function themlich($lichhoc)
    {
        DB::table("lichhoc")->insert([
            'magiaovien'=>$lichhoc->magiaovien,
            'mamonhoc'=>$lichhoc->mamonhoc,
            'malop'=>$lichhoc->malop,
            'thoigianbatdau'=>$lichhoc->thoigianbatdau,
            'thoigianketthuc'=>$lichhoc->thoigianketthuc,
        ]);
    }
    public function sualich($lichhoc)
    {
        DB::table("lichhoc")->where([
            'malich'=>$lichhoc->malich,
        ])->update([
            'magiaovien'=>$lichhoc->magiaovien,
            'mamonhoc'=>$lichhoc->mamonhoc,
            'malop'=>$lichhoc->malop,
            'thoigianbatdau'=>$lichhoc->thoigianbatdau,
            'thoigianketthuc'=>$lichhoc->thoigianketthuc,
        ]);
    }
     public function xoalichtheolop($lichhoc)
    {
        DB::table("lichhoc")->where([
            'malich'=>$lichhoc->malich,
            'malop'=>$lichhoc->malop,
        ])->update([
            'trangthai'=>0
        ]);
    }
}
