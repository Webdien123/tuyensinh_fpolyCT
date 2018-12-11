<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NguoiDung;
use Hash;
use View;
use File;

class AccountController extends Controller
{
    // Lấy danh sách tất cả tài khoản.
    public function getAllAcc()
    {
    	$acc_list = \DB::select('SELECT * FROM nguoidung LEFT JOIN level on nguoidung.level = level.level', [1]);
        WriteLogController::Write_InFo(\Session::get("uname")." vào trang quản lý tài khoản.");
    	return $acc_list;
    }

    // Kiểm tra username cần thêm đã tồn tại hay chưa.
    public function checkNewAccount(Request $R)
    {
        WriteLogController::Write_Debug(\Session::get("uhoten")." thêm user ".$R->uname);
        $result = 1; // Kết quả kiểm tra: 1 - Tkhoản đã tồn tài, 0 - TKhoản chưa có.
        $user_info = NguoiDung::getUser($R->uname);
        if (count($user_info) > 0) {
            $result = 1;
            WriteLogController::Write_Debug("User ".$R->uname." đã tồn tại.", "warning");
        } else {
            $result = 0;
            WriteLogController::Write_Debug("User ".$R->uname." sẳn sàng tạo mới.", "warning");
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

            WriteLogController::Write_Debug(\Session::get("uhoten")." thêm user ".$R->uname." thành công.", "success");
            WriteLogController::Write_InFo(\Session::get("uhoten")." tạo tài khoản ".$R->uname, 'success
                ');
            return ViewController::viewAccount(true, "success", "Thêm tài khoản thành công");
    	} catch (Exception $e) {
    		WriteLogController::Write_Debug(\Session::get("uhoten")." thêm user ".$R->uname." thất bại.<br>Mã lỗi: <br>".$e->getMessage(), "danger");
            WriteLogController::Write_InFo(\Session::get("uhoten")." tạo tài khoản ".$R->uname. " thất bại", "danger");
    	}
    	
    }

    // Cập nhật tài khoản.
    public function UpdateAccount(Request $R)
    {
        $result = NguoiDung::UpdateUser($R);

        if ($result == true) {
            if ($R->_uname == \Session::get('uname')) {
                \Session::put('uhoten', $R->hoten);
                \Session::put('ulevel', $R->level);
            }

            WriteLogController::Write_Debug(\Session::get("uhoten")." update user ".$R->_uname." thành công.", "success");

            $level = NguoiDung::LevelForValue($R->level);

            WriteLogController::Write_InFo(\Session::get("uhoten")." update tài khoản ".$R->_uname." sang thông tin:<br>Họ tên: ".$R->hoten."<br>Mức quyền: ".$level, 'success');

            if ($R->page == "account") {
                return ViewController::viewAccount(true, "success", "Cập nhật tài khoản thành công");
            }

            if ($R->page == "profile") {
                return ViewController::viewProFile($R->_uname, 1);
            }
            
        } else {
            WriteLogController::Write_Debug(\Session::get("uhoten")." cập nhật user ".$R->_uname." thất bại.<br>Mã lỗi: <br>".$e->getMessage(), "danger");
            WriteLogController::Write_InFo(\Session::get("uhoten")." cập nhật tài khoản ".$R->_uname. " thất bại", "danger");

            if ($R->page == "account") {
                return ViewController::viewAccount(true, "danger", "Cập nhật thất bại, vui lòng thử lại.");
            }

            if ($R->page == "profile") {
                return ViewController::viewProFile($R->_uname, 2);
            }
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

            WriteLogController::Write_Debug(\Session::get("uhoten")." xóa user ".$R->uname." thành công.", "success");
            WriteLogController::Write_InFo(\Session::get("uhoten")." xóa tài khoản ".$R->uname, 'success');

            return "ok";
        } catch (Exception $e) {

            WriteLogController::Write_Debug(\Session::get("uhoten")." xóa user ".$R->uname." thất bại.<br>Mã lỗi: <br>".$e->getMessage(), "danger");
            WriteLogController::Write_InFo(\Session::get("uhoten")." xóa tài khoản ".$R->uname. " thất bại", "danger");

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
                File::delete(public_path('avt/'.$R->_uname_avt.'.png'));
                File::delete(public_path('avt/'.$R->_uname_avt.'.jpg'));
                File::delete(public_path('avt/'.$R->_uname_avt.'.gif'));

                $image = $R->file('img_avt');
                $name = $R->_uname_avt.'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/avt');
                $image->move($destinationPath, $name);

                WriteLogController::Write_Debug(\Session::get("uhoten")." cập nhật ảnh đại diện. ".$R->_uname." thành công.", "success");
                WriteLogController::Write_InFo(\Session::get("uhoten")." cập nhật ảnh đại diện. ".$R->_uname, 'success');
            } catch (Exception $e) {
                WriteLogController::Write_Debug(\Session::get("uhoten")." cập nhật ảnh đại diện. ".$R->_uname." thất bại.<br>Mã lỗi: <br>".$e->getMessage(), "danger");
                WriteLogController::Write_InFo(\Session::get("uhoten")." cập nhật ảnh đại diện. ".$R->_uname. " thất bại", "danger");
            }
        }
        return redirect('/profile');
    }

    // Đổi mật khẩu người dùng.
    public function ChangePass(Request $R)
    {
        $user_info = NguoiDung::getUser($R->_uname_pass);
        if (Hash::check($R->old_pass, $user_info[0]->pass)) {
            $result = NguoiDung::UpdatePass($R->_uname_pass, $R->new_pass);
            if ($result) {

                WriteLogController::Write_Debug(\Session::get("uhoten")." đổi pass user ".$R->_uname_pass." thành công.", "success");

                WriteLogController::Write_InFo(\Session::get("uhoten")." đổi pass tài khoản ".$R->_uname_pass." thành: ".$R->new_pass, 'success');

                return View::make('profile')->with([
                    'user_info' => $user_info,
                    'change_pass_error' => 3, // Cập nhật mật khẩu thành công.
                    'update_info' => 0
                ]);
            } else {

                WriteLogController::Write_InFo(\Session::get("uhoten")." đổi pass tài khoản ".$R->_uname_pass." thành: ".$R->new_pass. " thất bại");
 
                return View::make('profile')->with([
                    'user_info' => $user_info,
                    'change_pass_error' => 2, //Có lỗi trong quá trình xử lý.
                    'update_info' => 0
                ]);
            }
            
        }
        else{

            WriteLogController::Write_InFo(\Session::get("uhoten")." đổi pass tài khoản ".$R->_uname_pass." thất bại vì nhập sai mật khẩu cũ", 'warning');

            return View::make('profile')->with([
                'user_info' => $user_info,
                'change_pass_error' => 1, // Sai mật khẩu cũ.
                'update_info' => 0
            ]);
        }
    }

    public function ResetPass(Request $R)
    {

        $result = NguoiDung::UpdatePass($R->_uname_reset, $R->pass_reset);
        $acc_list = NguoiDung::getAllUser();
        if ($result) {

            WriteLogController::Write_Debug(\Session::get("uhoten")." reset pass ".$R->_uname_reset." về ".$R->pass_reset." thành công.", "success");

            WriteLogController::Write_Info(\Session::get("uhoten")." reset pass ".$R->_uname_reset." về ".$R->pass_reset." thành công.", "success");

            return View::make('account')->with([
                'acc_list' => $acc_list,
                'show_alert' => true,
                'alert_type' => 'success',
                'alert_message' => 'Reset mật khẩu tài khoản '.$R->_uname_reset.' thành công'
            ]);
        } else {

            WriteLogController::Write_Info(\Session::get("uhoten")." reset pass ".$R->_uname_reset." về ".$R->pass_reset." thất bại.", "danger");

            return View::make('account')->with([
                'acc_list' => $acc_list,
                'show_alert' => false,
                'alert_type' => 'danger',
                'alert_message' => 'Reset mật khẩu thất bại'
            ]);
        }
    }
}
