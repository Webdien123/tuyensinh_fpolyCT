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

	// Update thông tin cờ.
    public function SaveFlag(Request $R)
    {
    	$result = DiaDiem::UpdateDiaDiem($R);
    	if ($result) {
    		return "ok";
    	} else {
    		return "fail";
    	}
    }
}
