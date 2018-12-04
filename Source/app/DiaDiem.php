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
    	$ddiem_list = \DB::select('SELECT A.id, ten_diadiem, diachi, lat, lng, chiso1_1, chiso2_2, ghichu_1, chiso1_2, chiso2_2, ghichu_2, chiso1_3, chiso2_3, ghichu_3 FROM (SELECT diadiem.id, ten_diadiem, diachi, lat, lng, chiso1 AS chiso1_1, chiso2 AS chiso2_1, ghichu AS ghichu_1 FROM diadiem LEFT JOIN tuyensinh on diadiem.id = tuyensinh.id WHERE namhoc = ?) A LEFT JOIN (SELECT diadiem.id, chiso1 AS chiso1_2, chiso2 AS chiso2_2, ghichu AS ghichu_2 FROM diadiem LEFT JOIN tuyensinh on diadiem.id = tuyensinh.id WHERE namhoc = ?) B ON A.id = B.id LEFT JOIN (SELECT diadiem.id, chiso1 AS chiso1_3, chiso2 AS chiso2_3, ghichu AS ghichu_3 FROM diadiem LEFT JOIN tuyensinh on diadiem.id = tuyensinh.id WHERE namhoc = ?) C ON B.id = C.id',[
            $namhoc - 2,
            $namhoc - 1,
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
