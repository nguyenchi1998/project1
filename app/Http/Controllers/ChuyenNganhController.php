<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\chuyennganhmodel;

use App\chuyennganh;

use DB;

class ChuyenNganhController extends Controller
{
    public function danhsachchuyennganh()
    {
    	$model = new chuyennganhmodel();
    	$arrChuyennganh = $model->danhsachchuyennganh();
    	return view('admin.danhsachchuyennganh',['arrChuyennganh'=>$arrChuyennganh]);
    }

    public function danhsachchuyennganhtheotukhoa(Request $request)
    {
        $machuyennganh = $request->tukhoa;
        $model = new chuyennganhmodel();
        if($machuyennganh !='')
        {
           $arrChuyennganh = $model->danhsachchuyennganhtheotukhoa($request->tukhoa);
            return view('admin.danhsachchuyennganh',['arrChuyennganh'=>$arrChuyennganh]);
        }
        else
        {
            return redirect()->route('danhsachchuyennganh');
        }
       
    }

    public function xoachuyennganh(Request $request)
    {
        $model = new chuyennganhmodel();
        $machuyennganh = $request->txtMaChuyenNganh;
        $model->xoachuyennganh($machuyennganh);
        return redirect('danhsach');
    }
    public function viewthem()
    {
        return view('admin.themchuyennganh');
    }
    public function them(Request $request)
    {
        $model = new chuyennganhmodel();
        $objChuyenNganh = new chuyennganh('',$request->txtTenchuyennganh,'');
        $model->themchuyennganh($objChuyenNganh);
        return redirect()->route('danhsachchuyennganh');
    }
    public function viewsua(Request $request)
    {
        $model = new chuyennganhmodel();
        $machuyennganh = $request->txtMachuyennganh;
        $objChuyenNganh = $model->getchuyennganh($machuyennganh);
        return view('admin.suachuyennganh',['objChuyenNganh'=>$objChuyenNganh]);
    }
    public function sua(Request $request)
    {
        $model = new chuyennganhmodel();
        $objChuyenNganh = new chuyennganh($request->txtMachuyennganh,$request->txtTenchuyennganh,1);
        $model->suachuyennganh($objChuyenNganh);
        return redirect()->route('danhsachchuyennganh');
    }
    public function xoa(Request $request)
    {
        $model = new chuyennganhmodel();
        $objChuyenNganh = new chuyennganh($request->txtMachuyennganh,'',1);
        $model->xoachuyennganh($objChuyenNganh);
        return redirect()->route('danhsachchuyennganh');
    }
}
