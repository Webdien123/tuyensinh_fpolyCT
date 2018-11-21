<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NguoiDung;
use Hash;
use View;

class AccountController extends Controller
{
    // Lấy danh sách tất cả tài khoản.
    public function getAllAcc()
    {
    	$acc_list = \DB::select('SELECT * FROM nguoidung LEFT JOIN level on nguoidung.level = level.level', [1]);
    	return $acc_list;
    }

    // Kiểm tra username cần thêm đã tồn tại hay chưa.
    public function checkNewAccount(Request $R)
    {
        $result = 1; // Kết quả kiểm tra: 1 - Tkhoản đã tồn tài, 0 - TKhoản chưa có.
        $user_info = NguoiDung::getUser($R->uname);
        if (count($user_info) > 0) {
            $result = 1;
        } else {
            $result = 0;
        }
        return $result;
    }

    // Tạo tài khoản mới.
    public function AddAcount(Request $R)
    {
    	try {
	    	\DB::insert("INSERT INTO `nguoidung`(`uname`, `hoten`, `pass`, `level`) VALUES (?, ?, ?, ?)", [
	    		$R->uname,
	    		$R->hoten,
	    		bcrypt($R->pass),
	    		$R->level
	    	]);

            return redirect('/account');
    	} catch (Exception $e) {
    		
    	}
    	
    }

    // Cập nhật tài khoản.
    public function UpdateAccount(Request $R, $page = "account", $user = "")
    {
        $result = NguoiDung::UpdateUser($R);

        if ($result == true) {
            if ($R->_uname == \Session::get('uname')) {
                \Session::put('uhoten', $R->hoten);
                \Session::put('ulevel', $R->level);
            }
            return redirect($page."/".$user);            
        } else {
            
        }
    }

    // Lấy trang thông tin của tài khoản cần xem chi tiết.
    public function GetProfile(Request $R)
    {
        $user_info = NguoiDung::getUser( $R->uname );
        $returnHTML = view('profile',[' user_info'=> $user_info])->render();
        return response()->json( array('success' => true, 'html'=>$returnHTML) );
    }

    // Xóa tài khoản.
    public function DeleteAccount(Request $R)
    {
        try {
            \DB::delete('DELETE FROM `nguoidung` WHERE nguoidung.uname = ?', [$R->uname]);
            return "ok";
        } catch (Exception $e) {
            return "fail";
        }
    }

    // Cập nhật ảnh đại diện.
    public function Upload_Avt(Request $R)
    {
        $this->validate($R, [
            'img_avt' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($R->hasFile('img_avt')) {
            try {
                $image = $R->file('img_avt');
                $name = $R->_uname_avt.'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/avt');
                $image->move($destinationPath, $name);

                return redirect('/profile');
            } catch (Exception $e) {
                return $e->getMessage();
            }
            
        }

        return "LỖI";
    }

    // Đổi mật khẩu người dùng.
    public function ChangePass(Request $R)
    {
        $user_info = NguoiDung::getUser($R->_uname_pass);
        if (Hash::check($R->old_pass, $user_info[0]->pass)) {
            $result = NguoiDung::UpdatePass($R->_uname_pass, $R->new_pass);
            if ($result) {
                return View::make('profile')->with([
                    'user_info' => $user_info,
                    'change_pass_error' => 3
                ]);
            } else {
                return View::make('profile')->with([
                    'user_info' => $user_info,
                    'change_pass_error' => 2
                ]);
            }
            
        }
        else{
            return View::make('profile')->with([
                'user_info' => $user_info,
                'change_pass_error' => 1
            ]);
        }
    }

    public function ResetPass(Request $R)
    {

        $result = NguoiDung::UpdatePass($R->_uname_reset, $R->pass_reset);
        $acc_list = NguoiDung::getAllUser();
        if ($result) {
            return View::make('account')->with([
                'acc_list' => $acc_list,
                'show_alert' => true,
                'alert_type' => 'success',
                'alert_message' => 'Reset mật khẩu tài khoản '.$R->_uname_reset.' thành công'
            ]);
        } else {
            return View::make('account')->with([
                'acc_list' => $acc_list,
                'show_alert' => false,
                'alert_type' => 'danger',
                'alert_message' => 'Reset mật khẩu thất bại'
            ]);
        }
    }
}
