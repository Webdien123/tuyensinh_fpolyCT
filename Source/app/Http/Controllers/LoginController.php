<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
   	public function loginProcess(Request $R)
   	{
   		// echo "User : " . $R->user . " <br>Pass: " . $R->pass;
   		return view('home');
   	}
}
