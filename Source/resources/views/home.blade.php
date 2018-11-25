@extends('master')

@section('title', 'hỗ trợ tuyển sinh')

@section('content')

    <!-- Chèn menu -->
    @include('menu')
	
    <!-- Tô đen tab đầu tiền đang hiển thị trên menu -->
    <script type="text/javascript">
        $(".navbar-nav > li").eq(0).addClass("active");

        // Mảng lưu tọa độ tất cả các vị trí marker trên map.
        var ddiem_list = <?php echo json_encode($ddiem_list); ?>;
    </script>

    <div class="alert alert-success" id="success-alert">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <strong id="alert-text">Lưu địa điểm thành công</strong>
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
                        <button type="button" onclick="alert('Chức năng đang phát triển')" class="btn btn-danger">
                            <span class="glyphicon glyphicon-trash"></span>
                            Xóa
                        </button>
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
                                <textarea name="ghichu" id="ghichu" class="form-control" rows="3" placeholder="nhập ghi chú (nếu cần)"></textarea>
                            </div>
                        </div>
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
        });
    </script>

@endsection