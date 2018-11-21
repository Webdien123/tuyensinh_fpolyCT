<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiaDiem extends Model
{
    protected $table = 'diadiem';
    public $timestamps = false;

    // Lấy tất cả địa điểm trong hệ thống.
    public static function getAllDiaDiem()
    {
    	$ddiem_list = \DB::select('SELECT * FROM diadiem');
    	return $ddiem_list;
    }
}
