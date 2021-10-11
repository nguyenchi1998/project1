<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class chuyennganh extends Model
{
    public $machuyennganh;
    public $tenchuyennganh;
    public $trangthai;

    public function __construct($machuyennganh,$tenchuyennganh,$trangthai)
    {
    	$this->machuyennganh = $machuyennganh;
    	$this->tenchuyennganh = $tenchuyennganh;
    	$this->trangthai = $trangthai;
    }
}
