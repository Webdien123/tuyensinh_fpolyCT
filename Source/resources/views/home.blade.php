@extends('master')

@section('title', 'hỗ trợ tuyển sinh')

@section('content')

    <!-- Chèn menu -->
    @include('menu')
	
    <style type="text/css">
        .input-color {
            position: relative;
        }
        .input-color input {
            padding-left: 20px;
        }
        .input-color .color-box {
            width: 15px;
            height: 15px;
            display: inline-block;
            background-color: #ccc;
            padding-top: 5px;
            margin-left: 5px;
        }
    </style>

    <!-- Tô đen tab đầu tiền đang hiển thị trên menu -->
    <script type="text/javascript">
        $(".navbar-nav > li").eq(0).addClass("active");

        // Mảng lưu tọa độ tất cả các vị trí marker trên map.
        var ddiem_list = <?php echo json_encode($ddiem_list); ?>;

        // Năm học đang hiển thị.
        var selected_namhoc = <?php echo json_encode($year); ?>;

        // Màu hiển thị chỉ số 1 năm thứ 1.        
        var color_circle_1_1 = "#757474";

        // Màu hiển thị chỉ số 2 năm thứ 1.        
        var color_circle_2_1 = "#F25FF0";

        // Màu hiển thị chỉ số 1 năm thứ 2.
        var color_circle_1_2 = "#48D466";

        // Màu hiển thị chỉ số 2 năm thứ 2.
        var color_circle_2_2 = "#4AABE2";

        // Màu hiển thị chỉ số 1 năm thứ 3 (mới nhất).
        var color_circle_1_3 = "#FF0000";

        // Màu hiển thị chỉ số 2 năm thứ 3 (mới nhất).
        var color_circle_2_3 = "#EBCD00";
    </script>

    <div class="modal fade" id="success-alert" style="margin-top: 20%; text-align: center; z-index: 9999">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <div class="modal-body">
                    <strong id="alert-text"></strong>
                </div>
            </div>
        </div>
    </div>

	<div id="map" style="width:100%; height:90%;"></div>

    <input type="text" id="pac-input" class="form-control" style="width: 80%; margin-left: 10px; margin-top: 10px; border-radius: 2px" placeholder="Nhập địa điểm cần tìm">

    <div class="modal fade" id="modal_place_info">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    
                    <h4 class="modal-title" style="display: inline;">Thông tin vị trí</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <br>
                    <div class="btn-group pull-right">
                        <button type="button" id="btn_save_flag" class="btn btn-success">
                            <i class="fa fa-save" aria-hidden="true"></i>
                            Lưu
                        </button>
                        @if(\Session::get("ulevel") == "1")
                        <button type="button" id="btn_remove_flag" class="btn btn-danger">
                            <span class="glyphicon glyphicon-trash"></span>
                            Xóa
                        </button>
                        @endif
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <i class="fa fa-times" aria-hidden="true"></i>
                            Hủy
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                    <form id="f_update_ddiem" class="form-horizontal" role="form">

                        {!! csrf_field() !!}
                        <input type="hidden" name="id_ddiem" id="id_ddiem" class="form-control" value="">
                        <input type="hidden" name="lat" id="lat" class="form-control" value="">
                        <input type="hidden" name="lng" id="lng" class="form-control" value="">

                        <label>Tên địa điểm</label>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input type="text" name="ten_diadiem" id="ten_diadiem" class="form-control" placeholder="nhập tên địa điểm">
                            </div>
                        </div>

                        <label>Địa chỉ</label>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input type="text" name="diachi" id="diachi" class="form-control" placeholder="nhập địa chỉ">
                            </div>
                        </div>

                        <hr>
                        <h4>{{ "Năm ".$year." :" }}</h4>
                        <input type="hidden" name="_namhoc" id="_namhoc" class="form-control" value="">
                        <label>Chỉ số 1</label>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input type="number" name="chiso1" value="0" id="chiso1" class="form-control">
                            </div>
                        </div>

                        <label>Chỉ số 2</label>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input type="number" name="chiso2" value="0" id="chiso2" class="form-control">
                            </div>
                        </div>

                        <label>Ghi chú</label>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <textarea name="ghichu" id="ghichu" class="form-control" rows="1" placeholder="nhập ghi chú (nếu cần)"></textarea>
                            </div>
                        </div>

                        <hr>
                        <h4>{{ "Năm ".($year-1)." :" }}</h4>
                        <label>Chỉ số 1</label>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input type="number" name="chiso1_2" id="chiso1_2" class="form-control" disabled="">
                            </div>
                        </div>

                        <label>Chỉ số 2</label>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input type="number" name="chiso2_2" id="chiso2_2" class="form-control" disabled="">
                            </div>
                        </div>

                        <!-- <label>Ghi chú</label>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <textarea name="ghichu" id="ghichu" class="form-control" rows="1" placeholder="nhập ghi chú (nếu cần)"></textarea>
                            </div>
                        </div> -->

                        <hr>
                        <h4>{{ "Năm ".($year - 2)." :" }}</h4>
                        <label>Chỉ số 1</label>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input type="number" name="chiso1_1" id="chiso1_1" class="form-control" disabled="">
                            </div>
                        </div>

                        <label>Chỉ số 2</label>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input type="number" name="chiso2_1" id="chiso2_1" class="form-control" disabled="">
                            </div>
                        </div>

                        <!-- <label>Ghi chú</label>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <textarea name="ghichu" id="ghichu" class="form-control" rows="1" placeholder="nhập ghi chú (nếu cần)"></textarea>
                            </div>
                        </div> -->
                    </form>
                </div>
            </div>
        </div>
    </div>

    
    <!-- Script khởi tạo và hiển thị dữ liệu đã lưu lên map -->
	<script type="text/javascript" src="../js/khoi_tao_map.js"></script>

    <!-- Script xử lý các xử kiện và chức năng trên map cho trang tuyển sinh -->
    <script type="text/javascript" src="../js/tuyensinh.js"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAnR7YAAG83jkhURYhrUkKbOfGDqA2BTqw&libraries=places"></script>

    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $("#success-alert").hide(0);

            // Xử lý khi chọn năm.
            $("#chk_1").change(function() {
                console.log("CHON NAM 1");
                if(this.checked == true) {
                    showCircleByYear('1');
                }
                else{
                    hideCircleByYear('1');
                }
            });

            $("#chk_2").change(function() {
                if(this.checked) {
                    showCircleByYear('2');
                }
                else{
                    hideCircleByYear('2');
                }
            });

            $("#chk_3").change(function() {
                if(this.checked) {
                    showCircleByYear('3');
                }
                else{
                    hideCircleByYear('3');
                }
            });
        });
    </script>

@endsection