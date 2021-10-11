<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;

use App\adminmodel;

use App\admin;

use App\taikhoan;

use Session;

use App\giaovienmodel;

use App\monhocmodel;

use App\lopmodel;

use App\sinhvienmodel;

use App\lichhocmodel;

use App\diemmodel;

class AdminController extends Controller
{
	public function __construct()
  	{
  		$this->middleware('loginadmin');
  	}
  	public function index()
  	{
  		$modelAdmin = new adminmodel();
  		$objAd = $modelAdmin->getadminbytaikhoan_index(Session::get('tk_ad'));

  		//Thống kê
  		$modelgiaovien = new giaovienmodel();
  		$arrGiaoVien = $modelgiaovien->danhsachgiaovien();
  		$countGiaoVien = count($arrGiaoVien);

  		$modelMonHoc = new monhocmodel();
  		$arrMonHoc = $modelMonHoc->danhsachmonhoc();
  		$countMonHoc = count($arrMonHoc);

  		$modelLop = new lopmodel();
  		$arrLop = $modelLop->danhsachlop();
  		$countLop = count($arrLop);

  		$modelSinhVien = new sinhvienmodel();
  		$arrSinhVien = $modelSinhVien->danhsachsinhvien();
  		$countSinhVien = count($arrSinhVien);

		$arrLopTrongLich = $modelLop->danhsachloptronglich();

  		return view('admin.index',['objAd'=>$objAd,'sogiaovien'=>$countGiaoVien,'solop'=>$countLop,'somonhoc'=>$countMonHoc,'sosinhvien'=>$countSinhVien,'arrLopTrongLich'=>$arrLopTrongLich]);
  	}
  	public function danhsachthongbao(Request $request)
  	{
  		$malop = $request->malop;
  		$modelLich = new lichhocmodel();
  		$arrMonHoc = $modelLich->danhsachlichtheolop($malop);
  		$modelDiem = new diemmodel();
  		$arr = [];
  		foreach ($arrMonHoc as $obj) {
  			$arrSinhVien = $modelDiem->danhsachsinhvienchuacodiem($malop,$obj->mamonhoc);
  			$arr[] = [
  				'tenlop'  =>  $obj->tenlop,
	            'tenmonhoc'  =>  $obj->tenmonhoc,
	            'tengiaovien'  =>  $obj->tengiaovien,
	            'sosinhvien'=>count($arrSinhVien)
            ];
  		};
  		echo json_encode($arr, JSON_UNESCAPED_UNICODE);
  	}
    public function danhsachadmin(){
		$model = new adminmodel();
		$arrAd = $model->danhsachadmin();
	    return view('admin.danhsachadmin',['arrAd'=>$arrAd]);
	}
	public function danhsachadmintheotukhoa(Request $request)
	{
		$model = new adminmodel();
		$arrAd = $model->danhsachadmintheotukhoa($request->tukhoa);
	    return view('admin.danhsachadmin',['arrAd'=>$arrAd]);
	}

	public function viewsua(Request $request)
	{
		$model = new  adminmodel();
		$maadmin = $request->txtMaAdmin;
		$objAd = $model->getadmin($maadmin);
		return view('admin.suaadmin',['objAd'=>$objAd]);
	}
	public function sua(Request $request)
	{
		$objAd = new admin($request->txtMaAdmin, $request->txtTenAdmin, $request->rdoGioiTinh, $request->txtNgaySinh, $request->txtDiaChi, $request->txtEmail, $request->txtLienHe, $request->txtTaiKhoan, $request->txtMatKhau, 1);
		$model = new  adminmodel();
		$model->suaadmin($objAd);
		return redirect()->route('danhsachadmin');
	}
	public function them(Request $request)
	{
		$messages = [
		    'unique'	=> 'Tài khoản đã tồn tại',
		    'regex' 	=> 'Liên hệ sai định dạng',
		];
		$validator = Validator::make($request->all(), [
            'txtTaiKhoan' => 'unique:admin,taikhoan',
            'txtLienHe'   => ['regex:/(\\+84|0)\\d{9,10}/']

        ], $messages);

        if ($validator->fails()) {
            return redirect('admin/themadmin')
                    ->withErrors($validator)
                    ->withInput();
        } else {
			$objAd = new admin('', $request->txtTenAdmin, $request->rdoGioiTinh, $request->txtNgaySinh, $request->txtDiaChi, $request->txtEmail, $request->txtLienHe, $request->txtTaiKhoan, $request->txtMatKhau, 1);
			$model = new  adminmodel();
			$model->themadmin($objAd);
			return redirect()->route('danhsachadmin');
		}
	}
	public function viewthem()
	{
		return view('admin.themadmin');
	}
	

	public function xoa(Request $request)
	{
		$maadmin = $request->txtMaAdmin;
		$model = new adminmodel();
		$model->xoaadmin($maadmin);
		return redirect()->route('danhsachadmin');
	}
}
