@extends('master')

@section('title', 'hỗ trợ tuyển sinh')

@section('content')

    <!-- Chèn menu -->
    @include('menu')
	
    <!-- Tô đen tab đầu tiền đang hiển thị trên menu -->
    <script type="text/javascript">
        $(".navbar-nav > li").eq(0).addClass("active");
    </script>

	<div id="map" style="width:100%; height:90%;"></div>

    <input type="text" id="pac-input" class="form-control" style="width: 80%; margin-left: 10px; margin-top: 10px; border-radius: 2px" placeholder="Nhập địa điểm cần tìm">

	<script type="text/javascript" src="../js/tuyensinh.js"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAnR7YAAG83jkhURYhrUkKbOfGDqA2BTqw&libraries=places"></script>

@endsection