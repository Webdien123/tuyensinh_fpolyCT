<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class NguoiDung extends Model
{
    protected $table = 'nguoidung';
    public $timestamps = false;

    // Lấy thông tin tài khoản theo usernname.
    public static function getUser($username)
    {
    	$user_info = \DB::select('SELECT * FROM nguoidung LEFT JOIN level on nguoidung.level = level.level WHERE nguoidung.uname = ?', [$username]);
    	return $user_info;
    }

    public static function LevelForValue($value)
    {
        $value = ($value == "1") ? "quản trị viên" : "Nv tuyển sinh";
        return $value;
    }

    // Lấy tất cả tài khoản trong hệ thống.
    public static function getAllUser()
    {
    	$acc_list = \DB::select('SELECT * FROM nguoidung LEFT JOIN level on nguoidung.level = level.level', [1]);
    	return $acc_list;
    }

    // Update thông tin người dùng.
    public static function UpdateUser(Request $R)
    {
        $result = \DB::statement(
        'UPDATE `nguoidung` SET  `hoten`= ?, `level` = ?
        WHERE `uname` = ?',
        [
            $R->hoten,
            $R->level,
            $R->_uname
        ]);

        return $result;
    }

    // Đổi mật khẩu.
    public static function UpdatePass($uname, $pass)
    {
        try {
            $result = \DB::statement(
            'UPDATE `nguoidung` SET  `pass`= ?
            WHERE `uname` = ?',
            [
                bcrypt($pass),
                $uname
            ]);

            return $result;
        } catch (Exception $e) {
            WriteLogController::Write_Debug(\Session::get("uhoten")." đổi pass cho".$uname." thất bại.<br>Mã lỗi: <br>".$e->getMessage(), "danger");
        }
        
    }
}
