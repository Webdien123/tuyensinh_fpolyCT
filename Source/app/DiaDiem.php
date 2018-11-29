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
    	$ddiem_list = \DB::select('SELECT * FROM diadiem ORDER BY chiso1 DESC, chiso2 DESC');
    	return $ddiem_list;
    }

    // Thêm địa điểm mới.
    public static function AddDiaDiem(Request $R)
    {
        $result = \DB::statement(
        'INSERT INTO `diadiem`(`id`, `ten_diadiem`, `diachi`, `lat`, `lng`, `chiso1`, `chiso2`, `ghichu`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
        [
            $R->id_ddiem,
            $R->ten_diadiem,
            $R->diachi,
            $R->lat,
            $R->lng,
            $R->chiso1,
            $R->chiso2,
            $R->ghichu            
        ]);

        return $result;
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

    // Xóa thông tin địa điểm.
    public static function RemoveDiaDiem(Request $R)
    {
        $result = \DB::statement(
        'DELETE FROM `diadiem` WHERE diadiem.id = ?',
        [
            $R->id_ddiem
        ]);

        return $result;
    }
}
