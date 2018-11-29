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
    		return "ok";
    	} else {
    		return "fail";
    	}
	}

	// Lưu thông tin cờ từ trang gmap.
    public function SaveFlag(Request $R)
    {
    	$result = DiaDiem::UpdateDiaDiem($R);
    	if ($result) {
    		return "ok";
    	} else {
    		return "fail";
    	}
    }

    // Xóa cờ.
    public function RemoveFlag(Request $R)
    {
        $result = DiaDiem::RemoveDiaDiem($R);
        if ($result) {
            return "ok";
        } else {
            return "fail";
        }
    }
}
