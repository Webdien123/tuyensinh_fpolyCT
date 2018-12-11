<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DiaDiem;

class DiaDiemController extends Controller
{
	public function AddFlag(Request $R)
	{
		$result = DiaDiem::AddDiaDiem($R);
    	if ($result) {
            WriteLogController::Write_Info(\Session::get("uhoten")." thêm cờ '".$R->ten_diadiem."'", "success");
    		return "ok";
    	} else {

            WriteLogController::Write_Info(\Session::get("uhoten")." thêm cờ '".$R->ten_diadiem."' không thành công", "danger");
    		return "fail";
    	}
	}

	// Lưu thông tin cờ từ trang gmap.
    public function SaveFlag(Request $R)
    {
    	$result = DiaDiem::UpdateDiaDiem($R);
    	if ($result) {
            WriteLogController::Write_Info(\Session::get("uhoten")." cập nhật thông tin '".$R->ten_diadiem."' theo thông tin:<b><br>Tên địa điểm - ".$R->ten_diadiem."<br>Địa chỉ - ".$R->diachi."<br>Năm tuyển sinh - ".$R->_namhoc."<br>Chỉ số 1 - ".$R->chiso1."<br>Chỉ số 2 - ".$R->chiso2."<br>Ghi chú - ".$R->ghichu."</b>", "success");
    		return "ok";
    	} else {
            WriteLogController::Write_Info(\Session::get("uhoten")." cập nhật thông tin '".$R->ten_diadiem."' không thành công", "danger");
    		return "fail";
    	}
    }

    // Xóa cờ.
    public function RemoveFlag(Request $R)
    {
        $result = DiaDiem::RemoveDiaDiem($R);
        if ($result) {
            WriteLogController::Write_Info(\Session::get("uhoten")." xóa cờ '".$R->ten_diadiem."'", "success");
            return "ok";
        } else {
            WriteLogController::Write_Info(\Session::get("uhoten")." xóa cờ '".$R->ten_diadiem."' không thành công", "danger");
            return "fail";
        }
    }
}