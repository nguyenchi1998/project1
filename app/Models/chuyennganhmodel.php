<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;

class chuyennganhmodel extends Model
{
	function danhsachchuyennganh(){
		$arrChuyennganh = DB::table('chuyennganh')->where([
			'chuyennganh.trangthai' =>1,
		])->get();
	    return $arrChuyennganh;
	}
	function danhsachchuyennganhtheotukhoa($tukhoa){
		$arrChuyennganh = DB::table('chuyennganh_monhoc')->join('chuyennganh','chuyennganh_monhoc.machuyennganh','=','chuyennganh.machuyennganh')->join('monhoc','chuyennganh_monhoc.mamonhoc','monhoc.mamonhoc')->select(DB::raw('chuyennganh_monhoc.machuyennganh,tenchuyennganh,count(chuyennganh_monhoc.mamonhoc) as TongSoMon'))->where([
			'chuyennganh.trangthai' =>1,
			'monhoc.trangthai' 		=>1,
			'chuyennganh_monhoc.trangthai' 	=>1,
			'chuyennganh_monhoc.machuyennganh'=>$tukhoa,
		])->groupBy('chuyennganh_monhoc.machuyennganh','tenchuyennganh')->get();
	    return $arrChuyennganh;
	}
	public function danhsachchuyennganhtronglich()
	{
		$arrChuyennganh = DB::table('chuyennganh_monhoc')->join('chuyennganh','chuyennganh_monhoc.machuyennganh','=','chuyennganh.machuyennganh')->join('monhoc','chuyennganh_monhoc.mamonhoc','monhoc.mamonhoc')->select(DB::raw('chuyennganh.machuyennganh,chuyennganh.tenchuyennganh'))->groupBy('chuyennganh.tenchuyennganh','chuyennganh.machuyennganh')->get();
	    return $arrChuyennganh;
	}
	function getchuyennganh($machuyennganh){
		$obj = DB::table('chuyennganh')->where([
			'chuyennganh.machuyennganh'=>$machuyennganh,
		])->first();
	    return $obj;
	}
	function suachuyennganh($objChuyenNganh)
	{
		DB::table('chuyennganh')->where([
			'chuyennganh.machuyennganh'=>$objChuyenNganh->machuyennganh
		])->update([
			'tenchuyennganh'=>$objChuyenNganh->tenchuyennganh,
		]);
			
	}
	function themchuyennganh($objChuyenNganh)
	{
		DB::table('chuyennganh')->insert([
			'tenchuyennganh'=>$objChuyenNganh->tenchuyennganh
		]);
		
	}
	function xoachuyennganh($objChuyenNganh)
	{
		DB::table('chuyennganh')->where([
			'chuyennganh.machuyennganh'=>$objChuyenNganh->machuyennganh,
		])->update([
			'trangthai'=>0,
		]);
		
	}
}
