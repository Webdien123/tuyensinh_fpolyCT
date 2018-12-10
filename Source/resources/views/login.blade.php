@extends('master')

@section('title', 'Đăng nhập')

@section('content')

<link rel="stylesheet" type="text/css" href="../css/login.css">

<div class="container-fluid">

	<div class="login-page col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4">
		<!-- div class="form">
		<form class="login-form" action="/login" method="POST">
			<h3>Đăng nhập</h3>
			{!! csrf_field() !!}
			<input type="text" name="user" class="form-control" placeholder="Tên tài khoản" autofocus="" required=""
				oninvalid="this.setCustomValidity('Vui lòng nhập tài khoản')"
				oninput="setCustomValidity('')">
			<input type="password" name="pass" class="form-control" placeholder="Mật khẩu" required
				oninvalid="this.setCustomValidity('Vui lòng nhập password')"
				oninput="setCustomValidity('')">
			@if ($login_status !== null)
				@if ($login_status == 0)
					<span class="login_error">Tài khoản không tồn tại.</span>
				@else
					<span class="login_error">Tên tài khoản hoặc mật khẩu không đúng.</span>
				@endif
			@endif
			<button class="btn btn-lg btn-primary btn-block" type="submit">
				Sign In
			</button>
		</form>
		</div> -->
	</div>

	<div class="container">
		<div class="info">
			<h1>Đăng nhập</h1>
		</div>
	</div>
	<div class="form">
		<div class="thumbnail"><img src="../img/hat.svg"/></div>
		<form class="login-form" action="/login" method="POST">
			{!! csrf_field() !!}
			<input type="text" name="user" placeholder="Tên tài khoản" autofocus="" required=""
				oninvalid="this.setCustomValidity('Vui lòng nhập tài khoản')"
				oninput="setCustomValidity('')">
			<input type="password" name="pass" placeholder="Mật khẩu" required
				oninvalid="this.setCustomValidity('Vui lòng nhập password')"
				oninput="setCustomValidity('')">
			@if ($login_status !== null)
				@if ($login_status == 0)
					<span class="login_error">Tài khoản không tồn tại.</span>
				@else
					<span class="login_error">Tên tài khoản hoặc mật khẩu không đúng.</span>
				@endif
			@endif
			<button class="btn btn-lg btn-primary btn-block" type="submit">
				Sign In
			</button>
		</form>
	</div>

@endsection