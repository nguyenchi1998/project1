<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class admin extends Model
{
    public $maadmin;
    public $tenadmin;
    public $gioitinh;
    public $ngaysinh;
    public $email;
    public $diachi;
    public $lienhe;
    public $taikhoan;
    public $matkhau;
    public $trangthai;

    public function __construct($maadmin,$tenadmin,$gioitinh,$ngaysinh,$diachi,$email,$lienhe,$taikhoan,$matkhau,$trangthai)
    {
    	$this->maadmin = $maadmin;
    	$this->tenadmin = $tenadmin;
        $this->gioitinh = $gioitinh;
    	$this->ngaysinh = $ngaysinh;
    	$this->email = $email;
    	$this->diachi = $diachi;
    	$this->lienhe = $lienhe;
    	$this->taikhoan = $taikhoan;
    	$this->matkhau = $matkhau;
    	$this->trangthai = $trangthai;
    }
}
