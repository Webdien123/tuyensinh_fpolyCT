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
                        <button type="button" class="btn btn-primary">Save changes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <i class="fa fa-times" aria-hidden="true"></i>
                            Hủy
                        </button>
                    </div>
                    
                </div>
                <div class="modal-body">
                    
                </div>
                <div class="modal-footer">
                    
                </div>
            </div>
        </div>
    </div>


	<script type="text/javascript" src="../js/tuyensinh.js"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAnR7YAAG83jkhURYhrUkKbOfGDqA2BTqw&libraries=places"></script>

@endsection