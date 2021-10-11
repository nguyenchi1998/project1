<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;

class lopmodel extends Model
{
    public function danhsachlop()
    {
        $arrLop = DB::table('lop')->join('chuyennganh','lop.machuyennganh','chuyennganh.machuyennganh')->join('sinhvien','lop.malop','sinhvien.malop')->select(DB::raw('lop.malop,lop.tenlop,chuyennganh.tenchuyennganh,count(sinhvien.masinhvien) as so'))->where('lop.trangthai','=',1)->groupBy('lop.malop','lop.tenlop','chuyennganh.tenchuyennganh')->get();
    	return $arrLop;
    }
    public function danhsachloptronglich()
    {
        $arr = DB::table('lop')->join('lichhoc','lop.malop','lichhoc.malop')->select(DB::raw('lop.malop, lop.tenlop'))->groupBy('lop.malop','lop.tenlop')->get();
        return $arr;
    }
    public function danhsachloptheochuyennganh($machuyennganh)
    {
        $arrLop =DB::table('lop')->join('chuyennganh','lop.machuyennganh','chuyennganh.machuyennganh')->join('sinhvien','lop.malop','sinhvien.malop')->select(DB::raw('lop.malop,lop.tenlop,chuyennganh.tenchuyennganh,count(sinhvien.masinhvien) as so'))->where([
                'lop.trangthai'=>1,
                'lop.machuyennganh'=>$machuyennganh,
            ])->groupBy('lop.malop','lop.tenlop','chuyennganh.tenchuyennganh')->get();
        return $arrLop;
    }
    public function danhsachloptheogiaovien($magiaovien)
    {
        $arrLop = DB::select("select lop.malop, lop.tenlop from giaovien INNER join lichhoc on giaovien.magiaovien = lichhoc.malop left join lop on lichhoc.malop = lop.malop where lichhoc.magiaovien = '$magiaovien' group by lop.malop, lop.tenlop");
        return $arrLop;
    }
    public function getlop($malop)
    {
        $obj = DB::table('lop')->join('chuyennganh','lop.machuyennganh','chuyennganh.machuyennganh')->where([
            'lop.malop'=>$malop,
        ])->first();
        return $obj;
    }
    public function themlop($objLop)
    {
    	DB::table('lop')->insert([
            'tenlop'=>$objLop->tenlop,
            'machuyennganh'=>$objLop->machuyennganh,
        ]);
    }
    public   function xoalop($malop)
    {
    	DB::table('lop')->where([
            'malop'=>$malop,
        ])->update([
            'trangthai'=>1
        ]);
    }
    public  function sualop($objLop)
    {
    	DB::table('lop')->where([
            'malop'=>$objLop->malop,
        ])->update([
            'tenlop'=>$objLop->tenlop,
            'machuyennganh'=>$objLop->machuyennganh,
        ]);
    }
}
