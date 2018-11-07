<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NguoiDung;

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
	    		bcrypt('???'),
	    		$R->level
	    	]);

            return redirect('/account');
    	} catch (Exception $e) {
    		
    	}
    	
    }

    // Cập nhật tài khoản.
    public function UpdateAccount(Request $R)
    {
        $result = \DB::statement(
        'UPDATE `nguoidung` SET  `hoten`= ?, `level` = ?
        WHERE `uname` = ?',
        [
            $R->hoten,
            $R->level,
            $R->_uname
        ]);

        if ($result == true) {
            if ($R->_uname == \Session::get('uname')) {
                \Session::put('uhoten', $R->hoten);
            }

            return redirect('/account');
        } else {
            
        }
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
}
