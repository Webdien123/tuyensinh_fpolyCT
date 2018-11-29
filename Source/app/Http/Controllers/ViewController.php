<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\NguoiDung;
use App\DiaDiem;

// Class điều hướng các trang web.
class ViewController extends Controller
{
    // Lấy trang web theo page tương ứng.
    public function getView($page = null, $username = null)
    {
        if (\Session::has('uname')) {        
        	switch ($page) {
        		case 'map':
        			return $this->viewMap();
                case 'dstruong':
                    return $this->viewDsTruong();
        		case 'account':
                    if (\Session::get('ulevel') == "1") {
                        return $this->viewAccount();
                    }
                    else{
                        return $this->viewMap();
                    }
                    break;
                case 'profile':
                    return $this->viewProFile($username);
                    
                case 'logout':
                    return LoginController::Logout();
                default:
                    return $this->viewMap();            
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
        $ddiem_list = DiaDiem::getAllDiaDiem();
        return View::make('home')->with([
            'ddiem_list' => $ddiem_list
        ]);
    }

    // Lấy trang danh sách trường.
    public static function viewDsTruong()
    {
        $ddiem_list = DiaDiem::getAllDiaDiem();
        return View::make('dstruong')->with([
            'ddiem_list' => $ddiem_list
        ]);
    }

    // Lấy trang quản lý account.
    public static function viewAccount()
    {
    	$acc_list = NguoiDung::getAllUser();
    	return View::make('account')->with([
            'acc_list' => $acc_list,
            'show_alert' => false
        ]);
    }

    // Lấy trang thông tin tài khoản.
    public function viewProFile($username)
    {
        $user_info = "";
        if ($username == "") {
            $user_info = NguoiDung::getUser( \Session::get("uname") );
        } else {
            $user_info = NguoiDung::getUser( $username );
        }
        return View::make('profile')->with([
            'user_info' => $user_info,
            'change_pass_error' => 0
        ]);
    }
}
