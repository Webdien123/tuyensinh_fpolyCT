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
    public function getView($page = null, $param = null)
    {
        // return $this->viewBaoTri(); // Điều hướng về trang bảo trì. (bật lên khi bảo trì website)
        if (\Session::has('uname')) {        
        	switch ($page) {
        		case '':
        			return $this->viewMap();
                case 'dstruong':
                    return $this->viewDsTruong();
                case 'xuat_dstruong':
                    return ExcelController::Export_DSTrương();
                case 'lsutuongtac':
                    return $this->viewTuongTac($param);
        		case 'account':
                    if (\Session::get('ulevel') == "1") {
                        return $this->viewAccount();
                    }
                    else{
                        return $this->viewMap();
                    }
                case 'nhatki':
                    return $this->viewNhatKi($param);
                case 'debug':
                    return $this->viewDebug($param);
                case 'profile':
                    return $this->viewProFile($param);
                case 'logout':
                    return LoginController::Logout();
                default:
                    return $this->viewNotFound();
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
        WriteLogController::Write_Info(\Session::get("uhoten")." vào trang bản đồ.");
        date_default_timezone_set("Asia/Ho_Chi_Minh");            
        if(mktime(0, 0, 0, 12, 2, date("Y")) > strtotime('now')) {
            $namhoc = date("Y");
        }
        else{
            $namhoc = date('Y', strtotime('+1 years'));
        }
        $ddiem_list = DiaDiem::getAllDiaDiem($namhoc);
        return View::make('home')->with([
            'ddiem_list' => $ddiem_list,
            'year' => $namhoc
        ]);
    }

    // Lấy trang danh sách trường.
    public static function viewDsTruong($show_bk_alert = false, $bk_alert_type = "", $bk_alert_content = "")
    {
        WriteLogController::Write_Info(\Session::get("uhoten")." vào trang danh sách trường.");
        $ddiem_list = DiaDiem::getAllDiaDiem();
        return View::make('dstruong')->with([
            'ddiem_list' => $ddiem_list,
            'show_bk_alert' => $show_bk_alert,
            'bk_alert_type' => $bk_alert_type,
            'bk_alert_content' => $bk_alert_content
        ]);
    }    

    // Lấy trang lịch sử tương tác.
    public static function viewTuongTac($id_truong)
    {
        $ddiem = DiaDiem::getDDiemByID($id_truong);
        WriteLogController::Write_Info(\Session::get("uhoten")." xem nhật kí tương tác '".$ddiem[0]->ten_diadiem."'.");
        return View::make('lsutuongtac')->with([
            'ddiem' => $ddiem
        ]);
    }

    // Lấy trang nhật kí hệ thống.
    public static function viewNhatKi($ngay_xem = "")
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date("d-m-Y");
        if ($ngay_xem == "") {
            $date2 = date('d/m/Y H:i:s');

            $filename = './logs/User_log'.'_'. $date .'.txt';
        } else {
            $date = $ngay_xem;
            $filename = './logs/User_log'.'_'. $ngay_xem .'.txt';
        }        

        if ( !file_exists($filename) ) {
            $lines = [];
        }
        else{
            $lines = file($filename, FILE_IGNORE_NEW_LINES);
        }   
        return View::make('history')->with([
                'date' => $date,
                'lines' => $lines
            ]);     
    } 

    // Xem debug log.
    public static function viewDebug($ngay_xem = "")
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date("d-m-Y");
        if ($ngay_xem == "") {
            $date2 = date('d/m/Y H:i:s');

            $filename = './logs/Debug_log'.'_'. $date .'.txt';
        } else {
            $date = $ngay_xem;
            $filename = './logs/Debug_log'.'_'. $ngay_xem .'.txt';
        }        

        $lines = file($filename, FILE_IGNORE_NEW_LINES);

        return View::make('history')->with([
            'date' => $date,
            'lines' => $lines
        ]);
    } 

    // Lấy trang quản lý account.
    public static function viewAccount($alert = false, $alert_type = "", $alert_content = "")
    {
        WriteLogController::Write_Info(\Session::get("uhoten")." vào trang quản lý tài khoản.");
    	$acc_list = NguoiDung::getAllUser();
    	return View::make('account')->with([
            'acc_list' => $acc_list,
            'show_alert' => $alert,
            'alert_type' => $alert_type,
            'alert_message' => $alert_content
        ]);
    }

    // Lấy trang thông tin tài khoản.
    public static function viewProFile($username, $update_info = 0)
    {
        WriteLogController::Write_Info(\Session::get("uhoten")." về trang thông tin cá nhân.");
        $user_info = "";
        if ($username == "") {
            $user_info = NguoiDung::getUser( \Session::get("uname") );
        } else {
            $user_info = NguoiDung::getUser( $username );
        }
        return View::make('profile')->with([
            'user_info' => $user_info,
            'change_pass_error' => 0,
            'update_info' => $update_info
        ]);
    }

    // Trang 404.
    public function viewNotFound()
    {
        return view("not_found");
    }

    // Trang bảo trì.
    public function viewBaoTri()
    {
        return view("baotri");
    }
}
