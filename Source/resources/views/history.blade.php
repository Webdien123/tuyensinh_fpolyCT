@extends('master')

@section('title', 'Nhật kí hệ thống')

@section('content')

    <!-- Chèn menu -->
    @include('menu')

    <center>
        <h3 style="padding-top: 2%">Nhật kí hệ thống ngày {{ $date }}</h3>
    </center>

    <?php
        $count = count($lines);
    ?>
    <div class="container">
    	<table class="table table-hover">
	    	<thead>
	    		<tr>
	    			<th></th>
	    		</tr>
	    	</thead>
	    	<tbody>
	    		@if ($count == 0)
	                <tr>
	                    <td style="font-style: inherit; font-weight: bold; text-align: center;">Chưa có dữ liệu</td>
	                </tr>
	            @else
		    		@for($i = 0; $i < $count; $i++)
		    			<tr>
			    			{!! $lines[$i] !!}
			    		</tr>
		    		@endfor
	    		@endif
	    		
	    	</tbody>
	    </table>
    </div>


@endsection