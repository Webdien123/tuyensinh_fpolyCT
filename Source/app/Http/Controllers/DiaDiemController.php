<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DiaDiem;

class DiaDiemController extends Controller
{
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
