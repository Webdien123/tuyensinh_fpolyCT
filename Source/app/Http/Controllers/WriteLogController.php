<?php
// Lớp định nghĩa các hàm xử lý việc ghi log.
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WriteLogController extends Controller
{
    // Ghi log thông tin.
    public static function Write_InFo($content)
    {        
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date("d-m-Y");
        $date2 = date('d/m/Y H:i:s');

        file_put_contents('./logs/User_log'.'_'. $date .'.txt', "[$date2] : " . $content . ".".PHP_EOL.PHP_EOL, FILE_APPEND | LOCK_EX);
    }

    // Ghi log cảnh báo
    public static function Write_Alert($content, $log_type = "Admin")
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date("d-m-Y");
        $date2 = date('d/m/Y H:i:s');

        file_put_contents('./logs/'.$log_type.'_'. $date .'.log', "\xEF\xBB\xBF" . "[$date2] Alert: " . $content.PHP_EOL.PHP_EOL, FILE_APPEND | LOCK_EX);
    }

    // Ghi log Debug
    public static function Write_Debug($content, $log_type = "Admin")
    {        
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date("d-m-Y");
        $date2 = date('d/m/Y H:i:s');

        file_put_contents('./logs/'.$log_type.'_'. $date .'.log', "\xEF\xBB\xBF" . "[$date2] Debug: " . $content.PHP_EOL.PHP_EOL, FILE_APPEND | LOCK_EX);   
    }

    // Ghi log báo lỗi
    public static function Write_Error($content, $log_type = "Admin")
    {        
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date("d-m-Y");
        $date2 = date('d/m/Y H:i:s');

        file_put_contents('./logs/'.$log_type.'_'. $date .'.log', "\xEF\xBB\xBF" . "[$date2] Error: " . $content.PHP_EOL.PHP_EOL, FILE_APPEND | LOCK_EX);   
    }
}