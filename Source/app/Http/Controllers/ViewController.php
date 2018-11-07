<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\NguoiDung;

// Class điều hướng các trang web.
class ViewController extends Controller
{
    // Lấy trang web theo page tương ứng.
    public function getView($page = null)
    {
        if (\Session::has('uname')) {        
        	switch ($page) {
        		case 'map':
        			return $this->viewMap();
        			break;

        		case 'account':
        			return $this->viewAccount();
        			break;

                case 'logout':
                    return LoginController::Logout();
                    break;

                case null:
                    return $this->viewMap();
                    break;
            }
        }
        else {
            return $this->viewLogin();
        }
    }

    // Lấy trang login.
    public static function viewLogin()
    {
    	return View::make('login')->with('login_status', null);
    }

    // Lấy trang bản đồ gmap.
    public static function viewMap()
    {
    	return view('home');
    }

    // Lấy trang quản lý account.
    public static function viewAccount()
    {
    	$acc_list = NguoiDung::getAllUser();
    	return View::make('account')->with('acc_list', $acc_list);
    }
}
