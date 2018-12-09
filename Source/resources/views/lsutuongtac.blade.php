@extends('master')

@section('title', 'Nhật kí tương tác')

@section('content')
	
	<!-- Chèn menu -->
    @include('menu')

    <link rel="stylesheet" type="text/css" href="../css/lsutuongtac.css">

    <?php
        $count = count($ddiem);
    ?>

	<div class="container">
		<h2>{{ $ddiem[0]->ten_diadiem }}</h2>
		<h4>{{ $ddiem[0]->diachi }}</h4>

		

		<div class="row">
			<div class="col-xs-12">
				<div id="tracking-pre"></div>
				<div id="tracking">
				<div class="text-center tracking-status-intransit">
					<p class="tracking-status">Nhật kí tương tác</p>
				</div>
				<div class="tracking-list">
					<div class="tracking-item">
						<div class="tracking-icon status-intransit" style="color: #F7A340">
							<i class="fa fa-line-chart" aria-hidden="true"></i>
						</div>
						<div class="tracking-content" style="height: 500px">
							<h4>Số liệu tuyển sinh qua các năm:</h4>
							<div id="chart_div" style="width: 100%; height: 100%; padding-left: 0px;"></div>
						</div>
					</div>
					@for ($i = 0; $i < $count; $i++)
					<div class="tracking-item">
						<div class="tracking-icon status-intransit">
							<i class="fa fa-calendar" aria-hidden="true"></i>
						</div>
						<h3 class="tracking-date">{{ $ddiem[$i]->namhoc }}</h3>
						<div class="tracking-content">
							<h4>Chỉ số 1: {{ $ddiem[$i]->chiso1 }} </h4>
							<h4>Chỉ số 2: {{ $ddiem[$i]->chiso2 }} </h4>
							<h4>Ghi chú:</h4>
							<span>
								{{ $ddiem[$i]->ghichu }}
							</span>
						</div>
					</div>
					@endfor
				</div>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
        var data = google.visualization.arrayToDataTable([
			['Năm', 'Chỉ số 1', { role: 'annotation'}, 'Chỉ số 2', { role: 'annotation'}, "Độ tăng giảm chỉ số 2"],
			<?php 
				for ($i = $count - 1; $i >= 0; $i--) {
					echo "['".$ddiem[$i]->namhoc."',".$ddiem[$i]->chiso1.",".$ddiem[$i]->chiso1.",".$ddiem[$i]->chiso2.",".$ddiem[$i]->chiso2.",".$ddiem[$i]->chiso2."],";
				}
			?>
        ]);


        var options = {
			vAxis: {title: ''},
			hAxis: {title: 'Năm'},
			height: '300px',
			seriesType: 'bars',
			legend: { position: 'top', maxLines: 3 },
			series: {
				0: {color: '#48D466'},
				1: {color: '#4AABE2'},				
				2: {type: 'line'}
			}
        };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>

@endsection