<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NguoiDung extends Model
{
    protected $table = 'nguoidung';
    public $timestamps = false;

    public static function getUser($username)
    {
    	$user_info = \DB::select('select * from nguoidung where uname = ?', [$username]);
    	return $user_info;
    }
}
