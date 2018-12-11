<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use \App\Http\Controllers\WriteLogController;

class DiaDiem extends Model
{
    protected $table = 'diadiem';
    public $timestamps = false;

    // Lấy tất cả địa điểm trong hệ thống.
    public static function getAllDiaDiem($namhoc = null)
    {
        if ($namhoc != null) {
            $ddiem_list = \DB::select('
                SELECT T1.id, T1.ten_diadiem, T1.diachi, T1.lat, T1.lng, chiso1_1, chiso2_1, chiso1_2, chiso2_2, chiso1_3, chiso2_3, ghichu_1, ghichu_2, ghichu_3 FROM (SELECT diadiem.id, diadiem.ten_diadiem, diadiem.diachi, diadiem.lat, diadiem.lng, chiso1 AS chiso1_1, chiso2 AS chiso2_1, ghichu AS ghichu_1 FROM diadiem LEFT JOIN ( SELECT * FROM tuyensinh WHERE tuyensinh.namhoc = ?) A on diadiem.id = A.id) T1 LEFT JOIN (SELECT diadiem.id, chiso1 AS chiso1_2, chiso2 AS chiso2_2, ghichu AS ghichu_2 FROM diadiem LEFT JOIN ( SELECT * FROM tuyensinh WHERE tuyensinh.namhoc = ?) B on diadiem.id = B.id) T2 ON T1.id = T2.id LEFT JOIN (SELECT diadiem.id, chiso1 AS chiso1_3, chiso2 AS chiso2_3, ghichu AS ghichu_3 FROM diadiem LEFT JOIN ( SELECT * FROM tuyensinh WHERE tuyensinh.namhoc = ?) C on diadiem.id = C.id) T3 ON T2.id = T3.id',[
                $namhoc - 2,
                $namhoc - 1,
                $namhoc
            ]);
        } else {
            $ddiem_list = \DB::select('SELECT * FROM `diadiem` LEFT JOIN `tuyensinh` ON diadiem.id = tuyensinh.id ORDER BY diadiem.id, tuyensinh.namhoc DESC');
        }

    	return $ddiem_list;
    }

    // Lấy toàn bộ thông tin của một địa điểm.
    public static function getDDiemByID($id_truong)
    {
        $ddiem = \DB::select('SELECT diadiem.id, ten_diadiem, diachi, lat, lng, stt, chiso1, chiso2, namhoc, ghichu FROM `diadiem` LEFT JOIN `tuyensinh` ON diadiem.id = tuyensinh.id WHERE diadiem.id = ? ORDER BY namhoc DESC',[
            $id_truong
        ]);
        return $ddiem;
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

            WriteLogController::Write_Debug(\Session::get("uhoten")." thêm cờ ".$R->ten_diadiem."' thành công.", "success");

            return true;
        } catch (Exception $e) {

            WriteLogController::Write_Debug(\Session::get("uhoten")." thêm cờ ".$R->ten_diadiem."' thất bại.<br>Mã lỗi: <br>".$e->getMessage(), "danger");

            return false;
        }
    }

    // Update thông tin địa điểm.
    public static function UpdateDiaDiem(Request $R)
    {
        try {
            WriteLogController::Write_Debug(\Session::get("uhoten")." chọn update cờ '".$R->ten_diadiem."' theo thông tin:<b><br>id - ".$R->id_ddiem."<br>Tên địa điểm - ".$R->ten_diadiem."<br>Địa chỉ - ".$R->diachi."<br>Năm tuyển sinh - ".$R->_namhoc."<br>Chỉ số 1 - ".$R->chiso1."<br>Chỉ số 2 - ".$R->chiso2."<br>Ghi chú - ".$R->ghichu."</b>");

            $ddiem = \DB::select('SELECT diadiem.id, ten_diadiem, diachi, lat, lng, stt, chiso1, chiso2, namhoc, ghichu FROM `diadiem` LEFT JOIN `tuyensinh` ON diadiem.id = tuyensinh.id WHERE diadiem.id = ? AND namhoc = ? ORDER BY namhoc DESC',[
                $R->id_ddiem,
                $R->_namhoc
            ]);
            if ($ddiem == null) {
                WriteLogController::Write_Debug("Thông tin năm học ".$R->_namhoc." tại '".$R->ten_diadiem."' chưa có.");

                \DB::statement(
                'INSERT INTO `tuyensinh`(`id`, `chiso1`, `chiso2`, `namhoc`, `ghichu`) VALUES (?, ?, ?, ?, ?)',
                [
                    $R->id_ddiem,
                    $R->chiso1,
                    $R->chiso2,
                    $R->_namhoc,
                    $R->ghichu
                ]);

                WriteLogController::Write_Debug("Thêm thông tin để update tại '".$R->ten_diadiem."' thành công",'success');
            }

            \DB::statement(
            'UPDATE `diadiem` SET `ten_diadiem`= ?, `diachi`= ? WHERE `id` = ?',
            [
                $R->ten_diadiem,
                $R->diachi,
                $R->id_ddiem
            ]);

            WriteLogController::Write_Debug("Update địa điểm '".$R->ten_diadiem."' thành công",'success');

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

            WriteLogController::Write_Debug("Update thông tin tuyển sinh năm ".$R->_namhoc." cho '".$R->ten_diadiem."' thành công",'success');

            return true;
        } catch (Exception $e) {

            WriteLogController::Write_Debug("Có lỗi khi cập nhật cờ '".$R->ten_diadiem."' thất bại.<br>Mã lỗi: <br>".$e->getMessage(), "danger");

            return false;
        }        
    }

    // Xóa thông tin địa điểm.
    public static function RemoveDiaDiem(Request $R)
    {
        try {

            \DB::statement(
            'DELETE FROM `tuyensinh` WHERE tuyensinh.id = ?',
            [
                $R->id_ddiem
            ]);

            \DB::statement(
            'DELETE FROM `diadiem` WHERE diadiem.id = ?',
            [
                $R->id_ddiem
            ]);

            WriteLogController::Write_Debug("Xóa cờ '".$R->ten_diadiem."' thành công",'success');

            return true;
        } catch (Exception $e) {

            WriteLogController::Write_Debug("Xóa cờ '".$R->ten_diadiem."' thất bại.<br>Mã lỗi: <br>".$e->getMessage(), "danger");
            return false;
        }
    }
}
