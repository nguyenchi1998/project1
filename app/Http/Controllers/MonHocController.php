<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\monhocmodel;

use App\chuyennganhmodel;

use App\monhoc;

class MonHocController extends Controller
{
    
    public function danhsachmonhoc()
    {
    	$model = new monhocmodel(); 
    	$arrMonHoc = $model->danhsachmonhoc();
        $model1 = new chuyennganhmodel();
        $arrChuyennganh = $model1->danhsachchuyennganh();
    	return view('admin.danhsachmonhoc',['arrMonHoc'=>$arrMonHoc,'arrChuyennganh'=>$arrChuyennganh]);
    }
    public function danhsachmonhoctheochuyennganh(Request $request)
    {
        $model = new monhocmodel(); 
        $arrMonHoc = $model->danhsachmonhoctheochuyennganh($request->manganh);
        // $model1 = new chuyennganhmodel();
        // $arrChuyennganh = $model1->danhsachchuyennganh();
        // return view('admin.danhsachmonhoc',['arrMonHoc'=>$arrMonHoc,'arrChuyennganh'=>$arrChuyennganh]);
        return json_encode($arrMonHoc);
    }
    public function them(Request $request)
    {
        $objMonhoc = new monhoc('',$request->txtTenMonHoc, 1);
        $model = new monhocmodel();
        $arrChuyennganh = $request->cbChuyenNganh;
        $model->themmonhoc($objMonhoc,$arrChuyennganh);
        return redirect()->route('danhsachmonhoc');
    }
    public function viewsua(Request $request)
    {
        $model = new  monhocmodel();
        $mamonhoc = $request->txtMamonhoc;
        $objMonHoc = $model->getmonhoc($mamonhoc);
        $machuyennganh = $objMonHoc->machuyennganh;
        $model1 = new chuyennganhmodel();
        $arrChuyennganh = $model1->danhsachmonhoctheochuyennganhAll($machuyennganh);
        return view('admin.suamonhoc',['objMonHoc'=>$objMonHoc,'arrChuyennganh'=>$arrChuyennganh]);
    }
    public function sua(Request $request)
    {
        $objMonhoc = new monhoc($request->txtMaMonHoc,$request->txtTenMonHoc,$request->txtBatDau,$request->txtKetThuc,$request->txtMaChuyenNganh,'', 1);
        $model = new  monhocmodel();
        $model->suamonhoc($objMonhoc);
        return redirect()->route('danhsachmonhoc');
    }
     public function viewthem(Request $request)
    {
        $model1 = new chuyennganhmodel();
        $arrChuyennganh = $model1->danhsachchuyennganh();
        return view('admin.themmonhoc',['arrChuyennganh'=>$arrChuyennganh]);
    }

    public function xoa(Request $request)
    {
        $mamonhoc = $request->txtMamonhoc;
        $model = new monhocmodel();
        $model->xoamonhoc($mamonhoc);
        return redirect()->route('danhsachmonhoc');
    }
}
