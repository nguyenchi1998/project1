<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class giaovien extends Model
{
    public $magiaovien;
    public $tengiaovien;
    public $gioitinh;
    public $ngaysinh;
    public $email;
    public $diachi;
    public $lienhe;
    public $taikhoan;
    public $matkhau;
    public $trangthai;

    public function __construct($magiaovien,$tengiaovien,$gioitinh,$ngaysinh,$diachi,$email,$lienhe,$taikhoan,$matkhau,$trangthai)
    {
    	$this->magiaovien  = $magiaovien;
    	$this->tengiaovien = $tengiaovien;
        $this->gioitinh    = $gioitinh;
    	$this->ngaysinh    = $ngaysinh;
    	$this->email       = $email;
    	$this->diachi      = $diachi;
    	$this->lienhe      = $lienhe;
    	$this->taikhoan    = $taikhoan;
    	$this->matkhau     = $matkhau;
    	$this->trangthai   = $trangthai;
    }
}
