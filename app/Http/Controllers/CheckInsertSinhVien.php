<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\lopmodel;



class CheckInsertSinhVien extends Controller
{
    public function viewthem()
	{
		$lop = new lopmodel();
		$arrLop = $lop->danhsachlop();
		
		return view('sinhvien.themsinhvien',['arrLop'=>$arrLop]);
	}

    public function storeUser(Request $request){
    	//dd($request->all());

    	$messages = [
		    'required' => 'Trường :attribute chưa nhập.',
		    'unique'=>' :attribute  đã tồn tại'
		];
		$validator = Validator::make($request->all(), [
            'txtTaiKhoan'     => 'required|unique:sinhvien,taikhoan'

        ], $messages);

        if ($validator->fails()) {
            return redirect('admin/themsinhvien')
                    ->withErrors($validator)
                    ->withInput();
        } else {
        	// Lưu thông tin vào database, phần này sẽ giới thiệu ở bài về database

        	return redirect('danhsachsinhvien')
        			->with('message', 'Đăng ký thành công.');
        }
    }
}
