<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class DiaDiem extends Model
{
    protected $table = 'diadiem';
    public $timestamps = false;

    // Lấy tất cả địa điểm trong hệ thống.
    public static function getAllDiaDiem($namhoc)
    {
    	$ddiem_list = \DB::select('SELECT * FROM `diadiem` RIGHT JOIN `tuyensinh` ON `diadiem`.`id` = `tuyensinh`.`id` WHERE `tuyensinh`.`namhoc` = ? ORDER BY tuyensinh.namhoc DESC, tuyensinh.chiso1 DESC, tuyensinh.chiso2 DESC',[
            $namhoc
        ]);
    	return $ddiem_list;
    }

    // Lấy tất cả dữ liệu của 
    public function getDDiemByID($id)
    {
        # code...
    }

    // Thêm địa điểm mới.
    public static function AddDiaDiem(Request $R)
    {
        try {
            \DB::statement(
            'INSERT INTO `diadiem`(`id`, `ten_diadiem`, `diachi`, `lat`, `lng`) VALUES (?, ?, ?, ?, ?)',
            [
                $R->id_ddiem,
                $R->ten_diadiem,
                $R->diachi,
                $R->lat,
                $R->lng          
            ]);

            \DB::statement(
            'INSERT INTO `tuyensinh`(`id`, `chiso1`, `chiso2`, `namhoc`, `ghichu`) VALUES (?, ?, ?, ?, ?)',
            [
                $R->id_ddiem,
                $R->chiso1,
                $R->chiso2,
                $R->_namhoc,
                $R->ghichu
            ]);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    // Update thông tin địa điểm.
    public static function UpdateDiaDiem(Request $R)
    {
        try {
            \DB::statement(
            'UPDATE `diadiem` SET `ten_diadiem`= ?, `diachi`= ? WHERE `id` = ?',
            [
                $R->ten_diadiem,
                $R->diachi,
                $R->id_ddiem
            ]);

            \DB::statement(
            'UPDATE `tuyensinh` SET `chiso1`= ?, `chiso2`= ?, `ghichu`= ? 
            WHERE `id` = ? AND `namhoc` = ?',
            [
                $R->chiso1,
                $R->chiso2,
                $R->ghichu,
                $R->id_ddiem,
                $R->_namhoc
            ]);

            return true;
        } catch (Exception $e) {
            return false;
        }        
    }

    // Xóa thông tin địa điểm.
    public static function RemoveDiaDiem(Request $R)
    {
        try {
            \DB::statement(
            'DELETE FROM `tuyensinh` WHERE tuyensinh.id = ? AND tuyensinh.namhoc = ?',
            [
                $R->id_ddiem,
                $R->_namhoc
            ]);

            \DB::statement(
            'DELETE FROM `diadiem` WHERE diadiem.id = ?',
            [
                $R->id_ddiem
            ]);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
