<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use Hash;
use App\NguoiDung;

// Lớp xử lý việc đăng nhập.
class LoginController extends Controller
{
	// Lấy thông tin tài khoản theo user.
	public static function getUserInfo($username)
	{
		$user_info = NguoiDung::getUser($username);
		return $user_info;
	}

	// Xử lý quá trình đăng nhập.
   	public function loginProcess(Request $R)
   	{
   		$user_info = $this->getUserInfo($R->user);

   		if (count($user_info) == 0) {
   			return View::make('login')->with('login_status', 0); // Tài khoản không tồn tại.
   		}
   		else {
   			// Nếu pass nhập vào khớp với pass của user.
   			if (Hash::check($R->pass, $user_info[0]->pass)) {

               \Session::put('uname', $user_info[0]->uname);
               \Session::put('uhoten', $user_info[0]->hoten);
               \Session::put('ulevel', $user_info[0]->level);

               WriteLogController::Write_InFo($user_info[0]->hoten." đăng nhập vào hệ thống");

   				return ViewController::viewMap();
   			} else {
   				return View::make('login')->with('login_status', 1); // Lỗi đăng nhập
   			}
   		}
   	}

    public static function Logout()
    {
        \Session::forget('uname');
        \Session::forget('uhoten');
        \Session::forget('ulevel');
        return redirect('/');
    }    


}
