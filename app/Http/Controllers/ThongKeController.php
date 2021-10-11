<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use App\chuyennganhmodel;

use App\monhocmodel;

use App\diemmodel;

use App\lopmodel;

use App\sinhvienmodel;

use Excel;

class ThongKeController extends Controller
{
    //Thống kê chuyên ngành
    public function chonchuyennganhvamonhoc()
    {
        $modelChuyenNganh = new chuyennganhmodel();
        $arrChuyennganh = $modelChuyenNganh->danhsachchuyennganhtronglich();
        return view('admin.thongketheochuyennganh',['arrChuyennganh'=>$arrChuyennganh]);
    }
    public function danhsachmonhoctheochuyennganh(Request $request)
    {
        $machuyennganh = $request->machuyennganh;
    	$modelmonhoc = new monhocmodel();
    	$arrMonHoc = $modelmonhoc->danhsachmonhoctronglichhoctheochuyennganh($machuyennganh);
        return json_encode($arrMonHoc);
    }

    public function thongketheochuyennganh(Request $request)
    {
    	$machuyennganh = $request->machuyennganh;
        $ketqua = $request->ketqua;
    	$mamonhoc = $request->mamonhoc;
    	$modelDiem = new diemmodel();
    	$arrDiem = $modelDiem->thongketheochuyennganh($machuyennganh,$mamonhoc,$ketqua);
        return json_encode($arrDiem);
    }
    public function thongketheochuyennganh_xuatExcel(Request $request)
    {
        $ketqua = $request->ketqua;
        $machuyennganh = $request->machuyennganh;
        $mamonhoc = $request->mamonhoc;

        $chuyennganhmodel = new chuyennganhmodel();
        $obj = $chuyennganhmodel->getchuyennganh($machuyennganh);
        $tenchuyennganh = $obj->tenchuyennganh;

        $monhocmodel = new monhocmodel();
        $obj1 = $monhocmodel->getmonhoc($mamonhoc);
        $tenmonhoc = $obj1->tenmonhoc;

        $modelDiem = new diemmodel();
        $arrDiem = $modelDiem->thongketheochuyennganh($machuyennganh,$mamonhoc,$ketqua);

        $data = [];
        foreach ($arrDiem as $key) {
        $data[] = [
            'Mã sinh viên'  =>  $key->masinhvien,
            'Tên sinh viên' =>  $key->tensinhvien ,
            'Lớp'           =>  $key->tenlop ,
            'Điểm Final'    => isset($key->finalhai) ? $key->finalhai : $key->finalmot,
            'Điểm Skill'    => isset($key->skillhai) ? $key->skillhai : $key->skillmot,
            'Kết quả'       =>  ($key->ketqua == 0) ? 'Qua môn' : (($key->ketqua == 1) ? 'Trượt Final'  : (($key->ketqua == 2) ? 'Trượt skill' : (($key->ketqua == 3) ? 'Trượt skill + final' : (($key->ketqua == 4  ) ? 'Học lại' : '')))) 
            ];
        };

        Excel::create('Thống kê chuyên ngành' , function($excel) use($data,$tenchuyennganh,$tenmonhoc){
            $excel->sheet('Sheet 1', function($sheet) use($data,$tenchuyennganh,$tenmonhoc){
                $sheet->mergeCells('A1:E1');
                $sheet->cell('A1', function ($cell) use($tenchuyennganh,$tenmonhoc) {
                    $cell->setValue('Chuyên ngành: '.$tenchuyennganh.'- Môn: '.$tenmonhoc );
                    $cell->setFontWeight('bold');
                });
                $sheet->fromArray($data, null, 'A3', false, true);
            });
        })->export('xlsx');
    }
    
    
    //Thống kê lớp
    public function chonlop()
    {
        $modelLop = new lopmodel();
        $arrLop = $modelLop->danhsachloptronglich();
        return view('admin.thongketheolop',['arrLop'=>$arrLop]);
    }
    public function danhsachmonhoccualop(Request $request)
    {
        $malop = $request->malop;
        $modelMonhoc = new monhocmodel();
        $arrMonHoc = $modelMonhoc->danhsachmonhoccualop($malop);
        return json_encode($arrMonHoc);
    }

    public function thongketheolop(Request $request)
    {
        $ketqua = $request->ketqua;
        $malop = $request->malop;
        $mamonhoc = $request->mamonhoc;
        $modelDiem = new diemmodel();
        $arrDiem = $modelDiem->thongketheolop($malop,$mamonhoc,$ketqua);
        return json_encode($arrDiem);
    }
    public function danhsachthongketheolop_xuatExcel(Request $request)
    {
        //Lấy ra dữ liệu
        $ketqua = $request->ketqua;
        $malop = $request->malop;
        $mamonhoc = $request->mamonhoc;

        //Lấy ra tên môn học
        $monhocmodel = new monhocmodel();
        $obj1 = $monhocmodel->getmonhoc($mamonhoc);
        $tenmonhoc = $obj1->tenmonhoc;

        //Lấy ra tên lớp học
        $modelLop = new lopmodel();
        $obj2 = $modelLop->getlop($malop);
        $tenlop = $obj2->tenlop;

        $modelDiem = new diemmodel();
        $arrDiem = $modelDiem->thongketheolop($malop,$mamonhoc,$ketqua);
        //Xử lí dữ liệu
        $data = [];
        foreach ($arrDiem as $key) {
        $data[] = [
            'Mã sinh viên'  =>  $key->masinhvien,
            'Tên sinh viên' =>  $key->tensinhvien ,
            'Điểm Final'    => isset($key->finalhai) ? $key->finalhai : $key->finalmot,
            'Điểm Skill'    => isset($key->skillhai) ? $key->skillhai : $key->skillmot,
            'Kết quả'       =>  ($key->ketqua == 0) ? 'Qua môn' : (($key->ketqua == 1) ? 'Trượt Final'  : (($key->ketqua == 2) ? 'Trượt skill' : (($key->ketqua == 3) ? 'Trượt skill + final' : (($key->ketqua == 4  ) ? 'Học lại' : '')))) 
            ];
        };

        //Xuất file excel
        Excel::create('Thống kê theo lớp' , function($excel) use($data,$tenlop,$tenmonhoc){
            $excel->sheet('Sheet 1', function($sheet) use($data,$tenlop,$tenmonhoc){
                $sheet->mergeCells('A1:E1');
                $sheet->cell('A1', function ($cell) use($tenmonhoc) {
                    $cell->setValue('Thống kê môn: '.$tenmonhoc );
                    $cell->setFontWeight('bold');
                });
                $sheet->mergeCells('A2:D2');
                $sheet->cell('A2', function ($cell) use($tenlop) {
                    $cell->setValue('Lớp: '.$tenlop);
                    $cell->setFontWeight('bold');
                });
                $sheet->fromArray($data, null, 'A4', false, true);
            });
        })->export('xlsx');
    }
    //Thống kê sinh viên
    public function viewthongketheosinhvien()
    {
        $modelmonhoc = new monhocmodel();
        $arrMonHoc = $modelmonhoc->danhsachmonhoctronglichhoc();
        return view('admin.thongketheosinhvien',['arrMonHoc'=>$arrMonHoc]);
    }
    public function danhsachthongketheosinhvien(Request $request)
    {
        $tukhoa = $request->tukhoa;
        $mamonhoc = $request->mamonhoc;
        $modelsinhvien = new sinhvienmodel();
        $arrSv = $modelsinhvien->danhsachsinhvientheotukhoa($tukhoa);
        $modelmonhoc = new monhocmodel();
        $arrMonHoc = $modelmonhoc->danhsachmonhoctronglichhoc();
        return view('admin.thongketheosinhvien',['arrMonHoc'=>$arrMonHoc,'arrSv'=>$arrSv,'mamonhoc'=>$mamonhoc,'tukhoa'=>$tukhoa]);
    }
    public function thongketheosinhvien(Request $request)
    {
        $masinhvien = $request->masinhvien;
        $mamonhoc = $request->mamonhoc;
        $ketqua = $request->ketqua;
        $tukhoa = $request->tukhoa;
        if($ketqua ==-1)
        {
             $kq= '';          
        }
        else
        {
            $kq = $ketqua;
        }
        $modelmonhoc = new monhocmodel();
        $arrMonHoc = $modelmonhoc->danhsachmonhoctronglichhoc();
        $modelDiem = new diemmodel();
        $arrDiem = $modelDiem->thongketheosinhvien($masinhvien,$mamonhoc,$kq);
        return view('admin.thongketheosinhvien',['arrDiem'=>$arrDiem,'arrMonHoc'=>$arrMonHoc,'tukhoa'=>$tukhoa,'mamonhoc'=>$mamonhoc,'ketqua'=>$kq,'masinhvien'=>$masinhvien]);
    }
    public function thongketheosinhvien_json(Request $request)
    {
        $masinhvien = $request->masinhvien;
        $mamonhoc = $request->mamonhoc;
        $ketqua = -1;
        if($ketqua ==-1)
        {
             $kq= '';          
        }
        else
        {
            $kq = $ketqua;
        }
        $modelDiem = new diemmodel();
        $arrDiem = $modelDiem->thongketheosinhvien($masinhvien,$mamonhoc,$kq);
        return json_encode($arrDiem);
    }
    public function danhsachthongketheosinhvien_xuatExcel(Request $request)
    {
        $masinhvien = $request->masinhvien;
        $mamonhoc = $request->mamonhoc;
        $arrDiem = $request->arrDiem;

        //lấy ra thông tin sinh viên
        $modelsinhvien = new sinhvienmodel();
        $obj =  $modelsinhvien->getsinhvien($masinhvien);
        $tensinhvien = $obj->tensinhvien;
        $tenlop = $obj->tenlop;

        //Xử lí dữ liệu
        $data = [];
        foreach ($arrDiem as $key => $value) {
        $data[] = [
            'Môn học' =>  $value['tenmonhoc'] ,
            'Điểm Final'    => isset($value['finalhai']) ? $value['finalhai'] : $value['finalmot'],
            'Điểm Skill'    => isset($value['skillhai']) ? $value['skillhai'] : $value['skillmot'],
            'Kết quả'       =>  ($value['ketqua'] == 0) ? 'Qua môn' : (($value['ketqua'] == 1) ? 'Trượt Final'  : (($value['ketqua'] == 2) ? 'Trượt skill' : (($value['ketqua'] == 3) ? 'Trượt skill + final' : (($value['ketqua'] == 4  ) ? 'Học lại' : '')))) 
            ];
        };

        Excel::create('Thống kê sinh viên' , function($excel) use($data, $masinhvien, $tenlop, $tensinhvien){
            $excel->sheet('Sheet 1', function($sheet) use($data, $masinhvien, $tenlop, $tensinhvien){
                $sheet->mergeCells('A1:E1');
                $sheet->cell('A1', function ($cell) use($masinhvien) {
                    $cell->setValue('Mã sinh viên: '.$masinhvien );
                    $cell->setFontWeight('bold');
                });
                $sheet->mergeCells('A2:E2');
                $sheet->cell('A2', function ($cell) use($tensinhvien)  {
                    $cell->setValue('Sinh viên: '.$tensinhvien );
                    $cell->setFontWeight('bold');
                });
                $sheet->mergeCells('A3:E3');
                $sheet->cell('A3', function ($cell) use($tenlop) {
                    $cell->setValue('Lớp: '.$tenlop );
                    $cell->setFontWeight('bold');
                });
                $sheet->mergeCells('A4:E4');
                $sheet->cell('A3', function ($cell)  {
                    $cell->setAlignment('center');
                    $cell->setValue('Bảng Điểm');
                    $cell->setFontWeight('bold');
                });
                $sheet->fromArray($data, null, 'A5', false, true);
            });
        })->export('xlsx');

    }

}
