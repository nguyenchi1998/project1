<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\diemmodel;

use App\monhocmodel;

use App\sinhvien;

use App\sinhvienmodel;

use App\lopmodel;

use Session;

use App\giaovienmodel;

use App\taikhoan;

use App\diem;

use App\lichhocmodel;

use App\chuyennganhmodel;

class DiemController extends Controller
{
    public function chonchuyennganh()
    {
        $model = new chuyennganhmodel();
        $arrChuyennganh = $model->danhsachchuyennganh();
        return view('admin.danhsachdiem',['arrChuyennganh'=>$arrChuyennganh]);
    }
    public function danhsachlop(Request $request)
    {
        $modelLop = new lopmodel();
        $arrLop = $modelLop->danhsachloptheochuyennganh($request->machuyennganh);
        echo json_encode( $arrLop );
    }
     public function danhsachmonhoc(Request $request)
    {
        $modelMonhoc = new monhocmodel();
        $arrMonHoc = $modelMonhoc->danhsachmonhoctronglichhoctheochuyennganh($request->machuyennganh);
        echo json_encode( $arrMonHoc );
    }
    public function danhsachmonhoccualop(Request $request)
    {
        $modelMonHoc = new monhocmodel();
        $arrMonHoc = $modelMonHoc->danhsachmonhoccualoptheogiaovien($request->malop, $request->magiaovien);
        return json_encode($arrMonHoc);
    }
    public function danhsachdiem(Request $request)
    {
        $malop = $request->malop;
        $mamonhoc = $request->mamonhoc;
        $modelDiem = new diemmodel();
        $arrDiem =  $modelDiem->danhsachdiem($malop,$mamonhoc);
        return json_encode($arrDiem);
    }
    public function chonlopvamonhoc_giaovien()
    {
        $modelGiaoVien = new giaovienmodel();
        $objGv = $modelGiaoVien->getgiaovientheotaikhoan(Session::get('tk_gv'));
        $modelMonhoc = new monhocmodel();
        $arrMonHoc = $modelMonhoc->danhsachmonhoctronglichhoc($objGv->magiaovien);
        $modelLop = new lopmodel();
        $arrLop = $modelLop->danhsachloptheogiaovien($objGv->magiaovien);
        return view('giaovien.danhsachdiem',['arrLop'=>$arrLop,'arrMonHoc'=>$arrMonHoc,'objGv'=>$objGv]);
    }
    // public function danhsachdiem_giaovien(Request $request)
    // {  
    //     $modelMonhoc = new monhocmodel();
    //     $malop = $request->malop;
    //     $mamonhoc = $request->mamonhoc;
    //     $modelMonhoc = new monhocmodel();
    //     $arrMonHoc = $modelMonhoc->danhsachmonhoctronglichhoc();
    //     $modelLop = new lopmodel();
    //     $modelGiaoVien = new giaovienmodel();
    //     $objGv = $modelGiaoVien->getgiaovientheotaikhoan(Session::get('tk_gv'));
    //     $arrLop = $modelLop->danhsachloptheogiaovien($objGv->magiaovien);
    //     $modelDiem = new diemmodel();
    //     $objMonhoc = $modelMonhoc->getmonhoc($mamonhoc);
    //     $objLop = $modelLop->getlop($malop);
    //     $arrDiem =  $modelDiem->danhsachdiem($malop,$mamonhoc);
    //     $modelLichHoc = new lichhocmodel();
    //     $objLich = $modelLichHoc->getLichHocTheoMaMonHoc($mamonhoc);
    //     return view('giaovien.danhsachdiem',['arrDiem'=>$arrDiem,'arrLop'=>$arrLop,'arrMonHoc'=>$arrMonHoc,'objMonhoc'=>$objMonhoc,'objLopHoc'=>$objLop,'malop'=>$malop,'mamonhoc'=>$mamonhoc,'objLich'=>$objLich]);
    // }
     public function danhsachdiem_giaovien(Request $request)
    {  
        $malop = $request->malop;
        $mamonhoc = $request->mamonhoc;
        $modelDiem = new diemmodel();
        $arrDiem =  $modelDiem->danhsachdiem($malop,$mamonhoc);
        return json_encode($arrDiem);
    }
    public function viewthemdiem(Request $request)
    {
        $mamonhoc = $request->mamonhoc;
        $malop = $request->malop;
        $modelMonhoc = new monhocmodel();
        $modelLop = new lopmodel();
        $objMonhoc = $modelMonhoc->getmonhoc($mamonhoc);
        $objLop = $modelLop->getlop($malop);
        $modelDiem = new diemmodel();
        $modelLichHoc = new lichhocmodel();
        $objLich = $modelLichHoc->getLichHocTheoMonVaLop($mamonhoc,$malop);
        $malich = $objLich->malich;
        $arrSv = $modelDiem->danhsachsinhvienchuacodiem($malop,$mamonhoc);
        return view('giaovien.themdiem',['arrSv'=>$arrSv,'objLop'=>$objLop,'objMonHoc'=>$objMonhoc,'malich'=>$malich]);
    }
    public function themdiemprocess(Request $request)
    {
        $malop = $request->maLop;
        $mamonhoc = $request->mamonhoc;
        $modelLichHoc  = new lichhocmodel();
        $malichhoc = $request->malich;
        $masinhvien = $request->txtMaSinhVien;
        $diemfinal = $request->txtFinal;
        $diemskill = $request->txtSkill;
        $ketqua = 0;
        if($diemskill>=5&&$diemfinal<5)
        {
             $ketqua = 1;
        }
        if($diemskill<5&&$diemfinal<5)
        {
             $ketqua = 3;
        }
        if($diemskill<5&&$diemfinal>=5)
        {
             $ketqua = 2;
        }
        $diem = new diem($malichhoc,$masinhvien,$diemskill,$diemfinal,'','',$ketqua);
        $modelDiem = new diemmodel();
        $modelDiem->themdiem($diem);
        return redirect()->route('giaovien.viewchonlopvamonhoc',['malop'=>$malop]);
    }
    public function viewsuadiem(Request $request)
    {
        $masinhvien = $request->masinhvien;
        $model = new  sinhvienmodel();
        $objSv = $model->getsinhvien($masinhvien);
        $mamonhoc = $request->mamonhoc;
        $malop = $request->malop;
        $modelMonhoc = new monhocmodel();
        $modelLop = new lopmodel();
        $objMonhoc = $modelMonhoc->getmonhoc($mamonhoc);
        $objLop = $modelLop->getlop($malop);
        $modelDiem = new diemmodel();
        $objDiem = $modelDiem->getdiem($masinhvien,$mamonhoc);
        $modelLichHoc = new lichhocmodel();
        $objLich = $modelLichHoc->getLichHocTheoMonVaLop($mamonhoc,$malop);
        $malich = $objLich->malich;
        return view('giaovien.suadiem',['objSv'=>$objSv,'objDiem'=>$objDiem,'malop'=>$malop,'objLop'=>$objLop,'objMonHoc'=>$objMonhoc,'malich'=>$malich]);
    }
    public function suadiemprocess(Request $request)
    {
        $malop = $request->maLop;
        $mamonhoc = $request->mamonhoc;
        $malich = $request->malich;
        // $modelLichHoc  = new lichhocmodel();
        // // $objLH = $modelLichHoc->getLichHocTheoMon($mamonhoc);
        // // $malichhoc = $objLH->malich;
        $masinhvien = $request->masinhvien;
        $ketqua = $request->txtKetQua;
        $diemfinal1 = $request->txtFinal1;
        $diemskill1 = $request->txtSkill1;
        $diemfinal2 = $request->txtFinal2;
        $diemskill2 = $request->txtSkill2;
        if($ketqua==0)
        {
             $ketqua = 0;
        }
        if($ketqua==1)
        {
            if($diemfinal2>=5)
            {
                $ketqua = 0;
            }
            else
            {
                $ketqua==1;
            }
        }
        if($ketqua==2)
        {
            if($diemskill2>=5)
            {
                $ketqua = 0;
            }
            else
            {
                $ketqua==2;
            }
        }
        if($ketqua==3)
        {
            if($diemskill2>=5&&$diemfinal2<5)
            {
                 $ketqua = 1;
            }
            if($diemskill2<5&&$diemfinal2<5)
            {
                 $ketqua = 3;
            }
            if($diemskill2<5&&$diemfinal2>=5)
            {
                 $ketqua = 2;
            }
            if($diemskill2<5&&$diemfinal2<5)
            {
                 $ketqua = 4;
            }
        }
        $diem = new diem($malich,$masinhvien,$diemskill1,$diemfinal1,$diemskill2,$diemfinal2,$ketqua);
        $modelDiem = new diemmodel();
        $modelDiem->suadiem($diem);
        return redirect()->route('giaovien.viewchonlopvamonhoc',['malop'=>$malop]);

    }
    public function xoadiemprocess(Request $request)
    {
        $mamonhoc = $request->mamonhoc;
        $masinhvien = $request->masinhvien;
        $malop = $request->malop;
        $modelLichHoc  = new lichhocmodel();
        $objLH = $modelLichHoc->getLichHocTheoMon($mamonhoc);
        $malichhoc = $objLH->malich;
        $modelDiem = new diemmodel();
        $diem = new diem($malichhoc,$masinhvien,'','','','','');
        $modelDiem->xoadiem($diem);
        return redirect()->route('giaovien.viewchonlopvamonhoc',['malop'=>$malop]);
    }
}
