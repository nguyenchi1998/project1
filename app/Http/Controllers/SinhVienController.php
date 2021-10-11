<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;

use App\Http\Requests;

use App\sinhvienmodel;

use App\lopmodel;

use App\sinhvien;


class SinhVienController extends Controller
{	
	// public function __construct()
 //  	{
 //  		$this->middleware('loginsinhvien');
 //  	}
  	public function index()
  	{
  		return view('sinhvien.index');
  	}
  	public  function danhsachsinhvientheolop(Request $request){
  		$model = new sinhvienmodel();
  		$malop = $request->malop;	
		$arrSv = $model->danhsachsinhvientheolop($malop);
		// $lop = new lopmodel();
		// $arrLop = $lop->danhsachlop();
	 //    return view('admin.danhsachsinhvien',['arrSinhVien'=>$arrSv,'arrLop'=>$arrLop,'malop'=>$malop]);
		return json_encode($arrSv);
	}
	public  function danhsachsinhvien(){
		$model = new sinhvienmodel();
		$arrSv = $model->danhsachsinhvien();
		$lop = new lopmodel();
		$arrLop = $lop->danhsachlop();
	    return view('admin.danhsachsinhvien',['arrSinhVien'=>$arrSv,'arrLop'=>$arrLop]);
	}
	// public function danhsachsinhvientheotukhoa(Request $request)
	// {
	// 	$model = new sinhvienmodel();
	// 	$arrSv = $model->danhsachsinhvientheotukhoa($request->tukhoa);
	// 	$lop = new lopmodel();
	// 	$arrLop = $lop->danhsachlop();
	//     return view('admin.danhsachsinhvien',['arrSinhVien'=>$arrSv,'arrLop'=>$arrLop]);
	// }
	public function viewsua(Request $request)
	{
		$model = new  sinhvienmodel();
		$masinhvien = $request->txtMasinhvien;
		$objSv = $model->getsinhvien($masinhvien);
		$lop = new lopmodel();
		$arrLop = $lop->danhsachlop();
		return view('admin.suasinhvien',['objSv'=>$objSv,'arrLop'=>$arrLop]);
	}
	public function sua(Request $request)
	{
		$objSv = new sinhvien($request->txtMa, $request->txtTenSv, $request->rdoGioiTinh, $request->txtNgaySinh, $request->txtDiaChi, $request->txtEmail, $request->txtLienHe, $request->sltLop,'', $request->txtTaiKhoan, $request->txtMatKhau, 1);
		$model = new  sinhvienmodel();
		$model->suasinhvien($objSv);
		return redirect()->route('danhsachsinhvien');
	}
	public function them(Request $request)
	{
		$messages = [
		    'unique'	=> 'Tài khoản đã tồn tại',
		    // 'unique'	=> ':Tài khoản đã tồn tại',
		    'regex'		=>'Liên hệ sai định dạng',
		];
		$validator = Validator::make($request->all(), [
            'txtTaiKhoan' => 'unique:sinhvien,taikhoan',
            'txtLienHe'      => ['regex:/(\\+84|0)\\d{9,10}/']
        ], $messages);

        if ($validator->fails()) {
            return redirect('admin/themsinhvien')
                    ->withErrors($validator)
                    ->withInput();
        } else {
			$objSv = new sinhvien('', $request->txtTenSv, $request->rdoGioiTinh, $request->txtNgaySinh, $request->txtDiaChi, $request->txtEmail, $request->txtLienHe, $request->sltLop,'', $request->txtTaiKhoan, $request->txtMatKhau, 1);
			$model = new  sinhvienmodel();
			$model->themsinhvien($objSv);
			return redirect()->route('danhsachsinhvien');
		}
	}
	public function viewthem()
	{
		$lop = new lopmodel();
		$arrLop = $lop->danhsachlop();
		
		return view('admin.themsinhvien',['arrLop'=>$arrLop]);
	}
	

	public function xoa(Request $request)
	{
		$masinhvien = $request->txtMasinhvien;
		$model = new sinhvienmodel();
		$model->xoasinhvien($masinhvien);
		return redirect()->route('danhsachsinhvien');
	}
}
