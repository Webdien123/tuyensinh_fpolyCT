@extends('master')

@section('title', 'hỗ trợ tuyển sinh')

@include('menu')

@section('content')

        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,700italic,400,600,700" rel="stylesheet" type="text/css">
        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Bootstrap JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		
        <input type="text" id="pac-input" class="form-control" style="width: 80%; margin-left: 10px; margin-top: 10px; border-radius: 2px" placeholder="Nhập địa điểm cần tìm">

		<div id="map" style="width:100%;height:90%; margin-top: 5px"></div>

		<script type="text/javascript" src="../js/tuyensinh.js"></script>

		<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAnR7YAAG83jkhURYhrUkKbOfGDqA2BTqw&callback=myMap"></script> -->

        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAnR7YAAG83jkhURYhrUkKbOfGDqA2BTqw&callback=initMap&libraries=places"></script>

@endsection