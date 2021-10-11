<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class diem extends Model
{
    public $masinhvien;
    public $malich; 
    public $skill1;
    public $final1;
    public $skill2;
    public $final2;
    public $ketqua;
    public $trangthai;
    public function __construct($malich,$masinhvien,$diemskill1,$diemfinal1,$diemskill2,$diemfinal2,$ketqua)
    {
    	$this->masinhvien = $masinhvien;
    	$this->malich = $malich;
    	$this->diemskill1 = $diemskill1;
    	$this->diemfinal1 = $diemfinal1;
    	$this->diemskill2 = $diemskill2;
    	$this->diemfinal2 = $diemfinal2;
        $this->ketqua = $ketqua;
    }
}
