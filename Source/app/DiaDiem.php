<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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

    // Update thông tin địa điểm.
    public static function UpdateDiaDiem(Request $R)
    {
    	$result = \DB::statement(
        'UPDATE `diadiem` SET `ten_diadiem`= ?, `diachi`= ?, `chiso1`= ?, `chiso2`= ?, `ghichu`= ? 
        WHERE `id` = ?',
        [
            $R->ten_diadiem,
            $R->diachi,
            $R->chiso1,
            $R->chiso2,
            $R->ghichu,
            $R->id_ddiem
        ]);

        return $result;
    }
}
