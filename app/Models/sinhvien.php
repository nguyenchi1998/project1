<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sinhvien extends Model
{
    public $masinhvien;
    public $tensinhvien;
    public $gioitinh;
    public $ngaysinh;
    public $diachi;
    public $email;
    public $lienhe;
    public $malop;
    public $tenlop;
    public $taikhoan;
    public $matkhau;
    public $trangthai;

    public function __construct($masinhvien,$tensinhvien,$gioitinh,$ngaysinh,$diachi,$email,$lienhe,$malop,$tenlop,$taikhoan,$matkhau,$trangthai)
    {
        $this->masinhvien   = $masinhvien;
        $this->tensinhvien  = $tensinhvien;
        $this->gioitinh     = $gioitinh;
        $this->ngaysinh     = $ngaysinh;
        $this->diachi       = $diachi;
        $this->email        = $email;
        $this->lienhe       = $lienhe;
        $this->malop        = $malop;
        $this->tenlop       = $tenlop;
        $this->taikhoan     = $taikhoan;
        $this->matkhau      = $matkhau;
        $this->trangthai    = $trangthai;
    } 
}
