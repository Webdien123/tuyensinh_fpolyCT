<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    // Hàm lấy danh sách tất cả tài khoản.
    public function getAllAcc()
    {
    	$acc_list = \DB::select('SELECT * FROM nguoidung LEFT JOIN level on nguoidung.level = level.level', [1]);
    	return $acc_list;
    }
}
