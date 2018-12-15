<?php
// Lớp định nghĩa các hàm xử lý việc nhập xuất file excel.
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Excel;
use App\DiaDiem;

class ExcelController extends Controller
{
    public static $mask_dangki;

    public static function Export_DSTrương()
    {
        if (\Session::has('uname')) {
            $date = date("d-m-Y");
            $tenfile = "Tuyển sinh (".$date.")";
            $ddiem_list = DiaDiem::getAllDiaDiem();


            $data = self::ChuyenVeArray($ddiem_list);

            WriteLogController::Write_InFo(\Session::get("uname")." backup dữ liệu tuyển sinh ".$date, "success");

            WriteLogController::Write_Debug(\Session::get("uname")." backup dữ liệu tuyển sinh ".$date, "success");

            return Excel::create($tenfile, function($excel) use ($data) {
                $excel->sheet("tuyensinh", function($sheet) use ($data)
                {
                    $sheet->fromArray($data);
                });
            })->download("xls");
        }
        else{
            return view('login');
        }
    }

    public function Import_DSTruong(Request $R)
    {
        if ($R->hasFile('file_restore')) {

            // Lấy đường dẫn của file.
            $path = Input::file('file_restore')->getRealPath();
            $data = Excel::selectSheets('tuyensinh')->load($path, function($reader) {})->get();
            if (count($data)) {

                \DB::beginTransaction();
                try {

                    // Lấy dữ liệu từ file.                    
                    $ddiem_data = self::TaoDuLieuDDiem($data);

                    // Xóa toàn bộ dữ liệu cũ.
                    DiaDiem::RemoveAllDiaDiem();

                    $count = count($ddiem_data);

                    // Insert dữ liệu địa điểm.                   
                    for ($i=0; $i < $count; $i++) { 
                        DiaDiem::AddDiaDiemByParam(
                            $ddiem_data[$i]["id"], 
                            $ddiem_data[$i]["ten_diadiem"], 
                            $ddiem_data[$i]["diachi"], 
                            $ddiem_data[$i]["lat"], 
                            $ddiem_data[$i]["lng"], 
                            $ddiem_data[$i]["chiso1"], 
                            $ddiem_data[$i]["chiso2"], 
                            $ddiem_data[$i]["namhoc"], 
                            $ddiem_data[$i]["ghichu"]);
                    }

                    WriteLogController::Write_Debug(\Session::get("uhoten")." phục hồi dữ liệu thành công.","success");
                    WriteLogController::Write_InFo(\Session::get("uhoten")." phục hồi dữ liệu thành công.", "success");
                    \DB::commit();

                    return ViewController::viewDsTruong(true, "ok", "Phục hồi dữ liệu thành công");
                    
                } catch (Exception $e) {
                    \DB::rollback();
                    WriteLogController::Write_Debug(\Session::get("uhoten")." phục hồi dữ liệu thất bại.<br>Mã lỗi: <br>".$e->getMessage(), "danger");
                    WriteLogController::Write_InFo(\Session::get("uhoten")." phục hồi dữ liệu thất bại.", "danger");

                    return ViewController::viewDsTruong(true, "fail", "Phục hồi thất bại");
                }
            }
        }
        return ViewController::viewDsTruong();
    }

    // Hàm chuyển mảng data về mảng 2 chiều và xóa đi các cột không cần thiết.
    public static function ChuyenVeArray($data)
    {
        if (\Session::has('uname')) {
            $data_array = [];

            // Chuyển sang mảng hai chiều và xóa cột Mã sự kiện, mã loại danh sách
            for ($i = 0; $i < count($data); $i++) { 
                $data_array[] = (array) $data[$i];
                $data_array[$i]['chiso1'] = (string)$data_array[$i]['chiso1'];
                $data_array[$i]['chiso2'] = (string)$data_array[$i]['chiso2'];
            }
            return $data_array;
        }
        else{
            return view('login');
        } 
    }

    // Hàm tạo dữ liệu cho bảng địa điểm.
    public static function TaoDuLieuDDiem($data)
    {
        if (\Session::has('uname')) {
            foreach ($data as $key => $value) {
                $insert[] = [
                    'id' => $value->id, 
                    'ten_diadiem' => $value->ten_diadiem,
                    'diachi' => $value->diachi,
                    'lat' => $value->lat,
                    'lng' => $value->lng,
                    'chiso1' => $value->chiso1,
                    'chiso2' => $value->chiso2,
                    'namhoc' => $value->namhoc,
                    'ghichu' => $value->ghichu,

                ];
            }
            return $insert;
        }
        else{
            return view('login');
        }
    }

}