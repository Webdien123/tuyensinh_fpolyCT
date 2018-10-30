<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use Hash;
use App\NguoiDung;

// Lớp xử lý việc đăng nhập.
class LoginController extends Controller
{
	// Hàm thấy thông tin tài khoản theo user.
	public static function getUserInfo($username)
	{
		$user_info = NguoiDung::getUser($username);
		return $user_info;
	}

	// Hàm xử lý quá trình đăng nhập.
   	public function loginProcess(Request $R)
   	{
   		$user_info = $this->getUserInfo($R->user);
   		// echo $user_info;
   		// var_dump($user_info);
   		// return view('home');

   		if (count($user_info) == 0) {
   			return View::make('login')->with('login_status', 0); // Tài khoản không tồn tại.
   		}
   		else {
   			// Nếu pass nhập vào khớp với pass của user.
   			if (Hash::check($R->pass, $user_info[0]->pass)) {
   				return view('home');
   			} else {
   				return View::make('login')->with('login_status', 1); // Lỗi đăng nhập
   			}

   		}
   	}

   	// Load login view.
   	public function loginView()
   	{
   		return view('login', ['login_status', NULL]);
   	}
}
