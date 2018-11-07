<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NguoiDung extends Model
{
    protected $table = 'nguoidung';
    public $timestamps = false;

    // Lấy thông tin tài khoản theo usernname.
    public static function getUser($username)
    {
    	$user_info = \DB::select('select * from nguoidung where uname = ?', [$username]);
    	return $user_info;
    }

    // Lấy tất cả tài khoản trong hệ thống.
    public static function getAllUser()
    {
    	$acc_list = \DB::select('SELECT * FROM nguoidung LEFT JOIN level on nguoidung.level = level.level', [1]);
    	return $acc_list;
    }
}
