<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;

// Class điều hướng các trang web.
class ViewController extends Controller
{
    // Hàm lấy trang web theo page tương ứng.
    public function getView($page = null)
    {
    	switch ($page) {
    		case 'map':
    			return $this->viewMap();
    			break;

    		case 'account':
    			return $this->viewAccount();
    			break;
    		
    		default:
    			return $this->viewLogin();
    			break;
    	}
    }

    // Hàm lấy trang login.
    public static function viewLogin()
    {
    	return View::make('login')->with('login_status', null);
    }

    // Hàm lấy trang bản đồ gmap.
    public static function viewMap()
    {
    	return view('home');
    }

    // Hàm lấy trang quản lý account.
    public static function viewAccount()
    {
    	$acc_list = \DB::select('SELECT * FROM nguoidung LEFT JOIN level on nguoidung.level = level.level', [1]);
    	return View::make('account')->with('acc_list', $acc_list);
    }
}
