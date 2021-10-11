<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\loginmodel;

use App\taikhoan;

use Session;

use App\sinhvienmodel;
use App\adminmodel;
use App\giaovienmodel;


class LogIn extends Controller
{
    public function __construct()
    { 
        session()->flush();
    }
    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }
	//xử lí đăng nhập của admin
    public function loginview()
    {
    	return view('login');
    }
    public function login(Request $request)
    {
        session()->flush();
    	$taikhoan = new taikhoan($request->txtTaiKhoan, $request->txtMatKhau);
        $model  = new loginmodel();
        $objAd = $model->loginAdmin($taikhoan);
        if(count($objAd) > 0 )
        {
            session()->put('tk_ad',$request->txtTaiKhoan);
            return redirect()->route('admin.index');
        }
        else
        {
            $objSv = $model->loginSinhvien($taikhoan);
            if(count($objSv) >0 )
            {
                session()->put('tk_sv',$request->txtTaiKhoan);
                return redirect()->route('sinhvien.index');
            }
            else
            {
                $objGv = $model->loginGiaoVien($taikhoan);
                if(count($objGv) >0 )
                {
                    session()->put('tk_gv',$request->txtTaiKhoan);
                    return redirect()->route('giaovien.index');
                }
                else
                {
                    return redirect()->route('login')->with('alert','Tài khoản hoặc mật khẩu ko đúng');
                }
            } 
        }
         
    }

    public function doiMatKhau(Request $request)
    {
        $matKhauCu  = $request->txtMatKhauCu;
        $matKhauMoi = $request->txtMatKhauMoi;
        if(Session::has('tk_ad'))
        {
            $taikhoan = Session::get('tk_ad');
            $tk = new taikhoan($taikhoan,$matKhauCu);
            $model = new adminmodel();
            $arrAd = $model->getadminbytaikhoan($tk);
            if(count($arrAd)>0)
            {
                $tk = new taikhoan($taikhoan,$matKhauMoi);
                $modelLogIn = new loginmodel();
                $modelLogIn->doiMatKhauAdmin($tk);
                return redirect()->route('admin.index')->with('alertSuccessDoiMatKhau','Đổi mật khẩu thành công');
            }
            else
            {
                return redirect()->route('admin.index')->with('alertErrorDoiMatKhau','Mật khẩu cũ ko đúng');
            }
        }
        else
        {
            if(Session::has('tk_gv'))
            {
                $taikhoan = Session::get('tk_gv');
                $tk = new taikhoan($taikhoan,$matKhauCu);
                $model = new giaovienmodel();
                $arrGv = $model->getgiaovientheotaikhoan($tk);
                if(count($arrGv)>0)
                {
                    $tk = new taikhoan($taikhoan,$matKhauMoi);
                    $modelLogIn = new loginmodel();
                    $modelLogIn->doiMatKhauGiaoVien($tk);
                    return redirect()->route('giaovien.index')->with('alertSuccessDoiMatKhau','Đổi mật khẩu thành công');
                }
                else
                {
                    return redirect()->route('giaovien.index')->with('alertErrorDoiMatKhau','Mật khẩu cũ ko đúng');
                }
            }
            else
            {
                $taikhoan = Session::get('tk_sv');
                $tk = new taikhoan($taikhoan,$matKhauCu);
                $model = new sinhvienmodel();
                $arrSv =  $model->getsinhvientheotaikhoan($tk);
                if(count($arrSv)>0)
                {
                    $tk = new taikhoan($taikhoan,$matKhauMoi);
                    $modelLogIn = new loginmodel();
                    $modelLogIn->doiMatKhauSinhVien($tk);
                    return redirect()->route('admin.index')->with('alertSuccessDoiMatKhau','Đổi mật khẩu thành công');
                }
                else
                {
                    return redirect()->route('admin.index')->with('alertErrorDoiMatKhau','Mật khẩu cũ ko đúng');
                }
            }
            
        }
    }
  
}
