<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class lichhoc extends Model
{
    public $malich;
    public $magiaovien;
    public $mamonhoc;
    public $malop;
    public $thoigianbatdau;
    public $thoigianketthuc;
    public $trangthai;

    public function __construct($malich,$magiaovien,$mamonhoc,$malop,$thoigianbatdau,$thoigianketthuc,$trangthai)
    {
    	$this->malich 			= $malich;
    	$this->magiaovien 		= $magiaovien;
    	$this->mamonhoc 		= $mamonhoc;
    	$this->malop 			= $malop;
    	$this->thoigianbatdau 	= $thoigianbatdau;
    	$this->thoigianketthuc 	= $thoigianketthuc;
    	$this->trangthai 		= $trangthai;
    }

}
