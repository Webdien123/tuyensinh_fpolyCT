@extends('master')

@section('title', 'Đăng nhập')

@section('content')

<link rel="stylesheet" type="text/css" href="../css/login.css">

<div class="container">
	<div class="info">
		<h1>Đăng nhập</h1>
	</div>
</div>
<div class="form">
	<div class="thumbnail"><img src="../img/hat.svg"/></div>
	<form class="login-form" action="/login" method="POST">
		{!! csrf_field() !!}
		@if ($login_status !== null)
			@if ($login_status == 0)
				<span style="font-weight: bold; font-style: inherit; color: red">Tài khoản không tồn tại.</span>
			@else
				<span style="font-weight: bold; font-style: inherit; color: red">Tên tài khoản hoặc mật khẩu không đúng.</span>
			@endif
		@endif
		<input type="text" name="user" placeholder="Tên tài khoản" autofocus="" required=""
			oninvalid="this.setCustomValidity('Vui lòng nhập tài khoản')"
			oninput="setCustomValidity('')">
		<input type="password" name="pass" placeholder="Mật khẩu" required
			oninvalid="this.setCustomValidity('Vui lòng nhập password')"
			oninput="setCustomValidity('')">
		
		<button class="btn btn-lg btn-primary btn-block" type="submit">
			Sign In
		</button>
	</form>
</div>

@endsection