<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\giaovienmodel;

use Validator;

use App\giaovien;

use Session;

class GiaoVienController extends Controller
{
    public function index()
    {
        $modelGiaoVien = new giaovienmodel();
        $objGv = $modelGiaoVien->getgiaovientheotaikhoan(Session::get('tk_gv'));
        return view('giaovien.index',['objGv'=>$objGv]);
    }
    public function danhsachgiaovien()
    {
    	$model = new giaovienmodel();
    	$arrGiaoVien = $model->danhsachgiaovien();
    	return view('admin.danhsachgiaovien',['arrGiaoVien'=>$arrGiaoVien]);
    }
    public function danhsachgiaovientheotukhoa(Request $request)
    {
        $model = new giaovienmodel();
        $arrGiaoVien = $model->danhsachgiaovientheotukhoa($request->tukhoa);
        return view('admin.danhsachgiaovien',['arrGiaoVien'=>$arrGiaoVien]);
    }
    public function viewthem()
    {
    	return view('admin.themgiaovien');
    }
    public function viewsua(Request $request)
    {
        $model = new  giaovienmodel();
        $magiaovien = $request->txtMagiaovien;
        $objGv = $model->getgiaovien($magiaovien);
        return view('admin.suagiaovien',['objGV'=>$objGv]);
    }
    public function sua(Request $request)
    {
        $objSv = new giaovien($request->txtMagiaovien, $request->txtTengiaovien, $request->rdoGioiTinh, $request->txtNgaySinh, $request->txtDiaChi, $request->txtEmail, $request->txtLienHe, $request->txtTaiKhoan, $request->txtMatKhau, 1);
        $model = new  giaovienmodel();
        $model->suagiaovien($objSv);
        return redirect()->route('danhsachgiaovien');
    }
    public function them(Request $request)
    {
        $messages = [
            'unique'=>':attribute đã tồn tại',
            'regex'=>'Liên hệ sai định dạng',
        ];
        $validator = Validator::make($request->all(), [
            'txtTaiKhoan'   => 'unique:giaovien,taikhoan',
            'txtLienHe'      => ['regex:/(\\+84|0)\\d{9,10}/']

        ], $messages);

        if ($validator->fails()) 
        {
            return redirect('admin/themgiaovien')
                    ->withErrors($validator)
                    ->withInput();
        } 
        else 
        {
            $objGv = new giaovien('', $request->txtTenAdmin, $request->rdoGioiTinh, $request->txtNgaySinh, $request->txtDiaChi, $request->txtEmail, $request->txtLienHe, $request->txtTaiKhoan, $request->txtMatKhau, 1);
            $model = new  giaovienmodel();
            $model->themgiaovien($objGv);
            return redirect()->route('danhsachgiaovien');
        }
    }
    public function xoa(Request $request)
    {
        $magiaovien = $request->txtMagiaovien;
        $sinhvienmodel = new giaovienmodel();
        $sinhvienmodel->xoagiaovien($magiaovien);
        return redirect()->route('danhsachgiaovien');
    }
}
