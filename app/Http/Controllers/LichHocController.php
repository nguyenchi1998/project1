<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\lichhocmodel;

use App\giaovienmodel;

use App\lopmodel;

use App\monhocmodel;

use App\lichhoc;

class LichHocController extends Controller
{
    public function chonlop(Request $request)
    {
        $malop = $request->malop;
        // $lopmodel = new lopmodel();
        // $arrlop = $lopmodel->danhsachlop();
        $modelLichHoc = new lichhocmodel();
        $arr = $modelLichHoc->danhsachlichtheolop($malop);
        // return view('admin.danhsachlich',['arrLich'=>$arr,'arrLop'=>$arrlop,'malop'=>$malop]);
        return json_encode($arr);
    }
    public function danhsachlich()
    {
        $lopmodel = new lopmodel();
        $arrlop = $lopmodel->danhsachlop();
        return view('admin.danhsachlich',['arrLop'=>$arrlop]);
    }
    public function viewthem(Request $request)
    {
        $malop = $request->malop;
        $lopmodel = new lopmodel();
        $objLop = $lopmodel->getlop($malop);
    	$modelGiaoVien = new giaovienmodel();
    	$arrGiaoVien = $modelGiaoVien->danhsachgiaovienAll();
        $modelLichHoc = new lichhocmodel();
    	$arrMonHoc = $modelLichHoc->getListMonHocChuaDayTheoLop($malop);
    	return view('admin.themlich',['arrMonHoc'=>$arrMonHoc,'arrGiaoVien'=>$arrGiaoVien,'objLop'=>$objLop]);
    }
    public function viewsua(Request $request)
    {      
        $malop = $request->malop;
    	$malich = $request->malich;
        $lopmodel = new lopmodel();
        $objLop = $lopmodel->getlop($malop);
    	$modelLichHoc = new lichhocmodel();
    	$modelGiaoVien = new giaovienmodel();
    	$arrGiaoVien = $modelGiaoVien->danhsachgiaovienAll();
    	$arrMonHoc = $modelLichHoc->getListMonHocChuaDayTheoLop($malop);
    	$objLich = $modelLichHoc->getLichHocTheoMaLich($malich);
        $monhocmodel = new monhocmodel();
        $objMonHoc = $monhocmodel->getmonhoc($objLich->mamonhoc);
    	return view('admin.sualich',['arrMonHoc'=>$arrMonHoc,'arrGiaoVien'=>$arrGiaoVien,'objLich'=>$objLich,'objLop'=>$objLop,'objMonhoc'=>$objMonHoc]);
    }
    public function themprocess(Request $request)
    {
    	$malop = $request->malop;
        $magiaovien = $request->txtMaGiaoVien;
        $mamonhoc = $request->txtMaMonHoc;
        $thoigianbatdau = $request->thoigianbatdau;
        $thoigianketthuc = $request->thoigianketthuc;
        $lichhoc = new lichhoc('',$magiaovien,$mamonhoc,$malop,$thoigianbatdau,$thoigianketthuc,'');
        $modelLichHoc = new lichhocmodel();
        $modelLichHoc->themlich($lichhoc);
        return redirect()->route('admin.danhsachlich',['sltLop'=>$malop]);
    }
    public function suaprocess(Request $request)
    {
        $malich = $request->malich;
    	$malop = $request->malop;
        $magiaovien = $request->txtMaGiaoVien;
        $mamonhoc = $request->mamonhoc;
        $thoigianbatdau = $request->thoigianbatdau;
        $thoigianketthuc = $request->thoigianketthuc;
        $lichhoc = new lichhoc($malich,$magiaovien,$mamonhoc,$malop,$thoigianbatdau,$thoigianketthuc,'');
        $modelLichHoc = new lichhocmodel();
        $modelLichHoc->sualich($lichhoc);
        return redirect()->route('admin.danhsachlich',['sltLop'=>$malop]);
    }
    public function xoalich(Request $request)
    {
    	$malich = $request->malich;
        $malop = $request->malop;
        $lichhoc = new lichhoc($malich,'','',$malop,'','','');
        $modelLichHoc = new lichhocmodel();
        $modelLichHoc->xoalichtheolop($lichhoc);
        return redirect()->route('admin.danhsachlich');
    }
}
