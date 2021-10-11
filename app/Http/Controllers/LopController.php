<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\lopmodel;

use App\chuyennganhmodel;

use App\lop;

class LopController extends Controller
{
    public function danhsachlop()
    {
    	$model = new lopmodel();
    	$arrLop = $model->danhsachlop();
        $model = new chuyennganhmodel();
        $arrChuyennganh = $model->danhsachchuyennganh();
    	return view('admin.danhsachlop',['arrLop'=>$arrLop,'arrChuyennganh'=>$arrChuyennganh]);
    }
    public function danhsachloptheochuyennganh(Request $request)
    {
        $manganh = $request->manganh;
        $model = new lopmodel();
        $arrLop = $model->danhsachloptheochuyennganh($manganh);
        return json_encode($arrLop);
    }
    public function viewthem()
    {
    	$model = new chuyennganhmodel();
    	$arrChuyennganh = $model->danhsachchuyennganh();
    	return view('admin.themlop',['arrChuyenNganh'=>$arrChuyennganh]);
    }
    public function them(Request $request)
    {
        $objLop = new  lop('',$request->txtTenLop,$request->txtChuyenNganh,'',1);
        $model = new  lopmodel();
        $model->themlop($objLop);
        return redirect()->route('danhsachlop');
    }
    public function viewsua(Request $request)
    {
        $model = new  lopmodel();
        $malop = $request->malop;
        $objLop = $model->getlop($malop);
        $model1 = new chuyennganhmodel();
        $arrChuyennganh = $model1->danhsachchuyennganh();
        return view('admin.sualop',['objLop'=>$objLop,'arrChuyenNganh'=>$arrChuyennganh]);
    }
    public function sua(Request $request)
    {
        $objLop = new  lop($request->txtMalop,$request->txtTenLop,$request->txtChuyenNganh,'',1);
        $model = new  lopmodel();
        $model->sualop($objLop);
        return redirect()->route('danhsachlop');
    }
    public function xoa(Request $request)
    {
        $malop = $request->txtMaLop;
        $model = new  lopmodel();
        $model->xoalop($malop);
        return redirect()->route('danhsachlop');
    }
    public function danhsachloptronglich()
    {
        # code...
    }
}
