<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;
use Session;

class diemmodel extends Model
{
    public function danhsachdiem($malop,$mamonhoc)
    {
        $arr = DB::table('diem')->join('lichhoc','diem.malich','lichhoc.malich')->join('sinhvien','diem.masinhvien','sinhvien.masinhvien')->join('lop','sinhvien.malop','lop.malop')->where([
            'lop.malop' => $malop,
            'lichhoc.mamonhoc'=>$mamonhoc,
            'lichhoc.trangthai'=>1, 
            'diem.trangthai'=>1
        ])->get();
        return $arr;
    }
    public function danhsachsinhvienchuacodiem($malop, $mamonhoc)
    {
        // $arr = DB::table('sinhvien')->select(DB::raw('select * from sinhvien INNER join lop on sinhvien.malop = lop.malop where masinhvien not in (select masinhvien from diem INNER join lichhoc on diem.malich = lichhoc.malich where lichhoc.mamonhoc = $mamonhoc) and  sinhvien.malop = $malop'))->get();
        $sql = "select * from sinhvien INNER join lop on sinhvien.malop = lop.malop where masinhvien not in (select masinhvien from diem INNER join lichhoc on diem.malich = lichhoc.malich where lichhoc.mamonhoc = $mamonhoc) and  sinhvien.malop = $malop";
        $arr = DB::select($sql);
        return $arr;
    }
    public function themdiem($diem)
    {
        Db::table('diem')->insert([
            'malich'=>$diem->malich,
            'masinhvien'=>$diem->masinhvien,
            'skillmot'=>$diem->diemskill1,
            'finalmot'=>$diem->diemfinal1,
            'ketqua'=>$diem->ketqua,
        ]);
    }
    public function getdiem($masinhvien,$mamonhoc)
    {
        $obj = Db::table('diem')->join('lichhoc','diem.malich','lichhoc.malich')->where([
            'masinhvien'=>$masinhvien,
            'lichhoc.mamonhoc'=>$mamonhoc,
        ])->first();
        return $obj;
    }
    public function suadiem($diem)
    {
        Db::table('diem')->where([
            'malich'    =>$diem->malich,
            'masinhvien'=>$diem->masinhvien,
        ])->update([
            'skillmot'  =>$diem->diemskill1,
            'finalmot'  =>$diem->diemfinal1,
            'skillhai'  =>$diem->diemskill2,
            'finalhai'  =>$diem->diemfinal2,
            'ketqua'    =>$diem->ketqua,
        ]);
    }
    public function xoadiem($diem)
    {
        DB::table('diem')->where([
            'malich'    =>$diem->malich,
            'masinhvien'=>$diem->masinhvien,
        ])->update([
            'trangthai'=>0,
        ]);
    }

    public function thongketheochuyennganh($machuyennganh, $mamonhoc , $ketqua)
    {
        // $arr = DB::table('diem')->join('sinhvien','diem.masinhvien','sinhvien.masinhvien')->join('lichhoc','diem.malich','lichhoc.malich')->join('lop','lichhoc.malop','lop.malop')->join('chuyennganh','lop.machuyennganh','chuyennganh.machuyennganh')->select(DB::raw('sinhvien.masinhvien, sinhvien.tensinhvien,diem.finalmot, diem.skillmot, diem.finalhai, diem.skillhai, diem.ketqua'))->where([
        //         'lop.machuyennganh'=>$machuyennganh,
        //         'lichhoc.mamonhoc'=>$mamonhoc,
        //         'diem.ketqua'=>$ketqua,
        //     ])->get();
        $sql = "select sinhvien.masinhvien,lop.tenlop, sinhvien.tensinhvien,diem.finalmot, diem.skillmot, diem.finalhai, diem.skillhai, diem.ketqua from diem 
            inner join sinhvien on diem.masinhvien = sinhvien.masinhvien 
            inner join lichhoc on diem.malich = lichhoc.malich 
            inner join lop on lichhoc.malop = lop.malop 
            inner join chuyennganh on lop.machuyennganh = chuyennganh.machuyennganh 
            where lop.machuyennganh = '$machuyennganh' and lichhoc.mamonhoc = '$mamonhoc' ";
        if($ketqua != '')
        {
            $sql .= "and diem.ketqua = '$ketqua' ";
            $arr = DB::select($sql);
        }
        else
        {
            $arr = DB::select($sql);
        }
        return $arr;     
    }
    public function thongketheolop($malop, $mamonhoc , $ketqua)
    {
        // $arr = DB::table('diem')->join('sinhvien','diem.masinhvien','sinhvien.masinhvien')->join('lichhoc','diem.malich','lichhoc.malich')->join('lop','lichhoc.malop','lop.malop')->join('chuyennganh','lop.machuyennganh','chuyennganh.machuyennganh')->select(DB::raw('sinhvien.masinhvien, sinhvien.tensinhvien,diem.finalmot, diem.skillmot, diem.finalhai, diem.skillhai, diem.ketqua'))->where([
        //         'lop.machuyennganh'=>$machuyennganh,
        //         'lichhoc.mamonhoc'=>$mamonhoc,
        //         'diem.ketqua'=>$ketqua,
        //     ])->get();
        $sql = "select sinhvien.masinhvien,lop.tenlop, sinhvien.tensinhvien,diem.finalmot, diem.skillmot, diem.finalhai, diem.skillhai, diem.ketqua from diem 
            inner join sinhvien on diem.masinhvien = sinhvien.masinhvien 
            inner join lichhoc on diem.malich = lichhoc.malich 
            inner join lop on lichhoc.malop = lop.malop 
            inner join chuyennganh on lop.machuyennganh = chuyennganh.machuyennganh 
            where lop.malop = '$malop' and lichhoc.mamonhoc = '$mamonhoc' ";
        if($ketqua != '')
        {
            $sql .= "and diem.ketqua = '$ketqua' ";
            $arr = DB::select($sql);
        }
        else
        {
            $arr = DB::select($sql);
        }
        return $arr;     
    }

    public function thongketheosinhvien($masinhvien, $mamonhoc, $ketqua)
    {
        $sql = "select sinhvien.masinhvien,lop.tenlop, monhoc.tenmonhoc, sinhvien.tensinhvien,diem.finalmot, diem.skillmot, diem.finalhai, diem.skillhai, diem.ketqua from diem 
            inner join sinhvien on diem.masinhvien = sinhvien.masinhvien 
            inner join lichhoc on diem.malich = lichhoc.malich 
            inner join lop on lichhoc.malop = lop.malop 
            inner join chuyennganh on lop.machuyennganh = chuyennganh.machuyennganh 
            inner join monhoc on lichhoc.mamonhoc = monhoc.mamonhoc 
            where sinhvien.masinhvien = '$masinhvien' ";
        if($mamonhoc !=-1)
        {
            $sql .=" and lichhoc.mamonhoc = '$mamonhoc' ";
        }
        if($ketqua!='')
        {
            $sql .= "and diem.ketqua = '$ketqua' ";
            $arr = DB::select($sql);
        }
        else
        {
            $arr = DB::select($sql);
        }
        return $arr;     
    }
}
