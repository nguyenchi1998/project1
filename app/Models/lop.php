<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class lop extends Model
{
    public $malop;
    public $tenlop;
    public $machuyennganh;
    public $tenchuyennganh;
    public $trangthai;

    public function __construct($malop,$tenlop,$machuyennganh,$tenchuyennganh,$trangthai)
    {
    	$this->malop = $malop;
    	$this->machuyennganh = $machuyennganh;
    	$this->tenchuyennganh = $tenchuyennganh;
    	$this->tenlop = $tenlop;
    	$this->trangthai = $trangthai;
    }
}
