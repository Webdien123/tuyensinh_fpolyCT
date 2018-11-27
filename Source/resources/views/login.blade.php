@extends('master')

@section('title', 'Đăng nhập')

@section('content')

<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<style type="text/css">
	@import url(https://fonts.googleapis.com/css?family=Roboto:300);

	.form {
	  z-index: 1;
	  background: #FFFFFF;
	  margin-top: 20%;
	  padding: 45px;
	  text-align: center;
	  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
	}
	.form input {
	  font-family: "Roboto", sans-serif;
	  outline: 0;
	  background: #f2f2f2;
	  width: 100%;
	  border: 0;
	  margin: 0 0 15px;
	  padding: 15px;
	  box-sizing: border-box;
	  font-size: 14px;
	}
	.form button {
	  font-family: "Roboto", sans-serif;
	  text-transform: uppercase;
	  outline: 0;
	  background: #5E5861;
	  width: 100%;
	  border: 0;
	  padding: 15px;
	  color: #FFFFFF;
	  font-size: 14px;
	  -webkit-transition: all 0.3 ease;
	  transition: all 0.3 ease;
	  cursor: pointer;
	}
	.form button:hover,.form button:active,.form button:focus {
	  background: #43A047;
	}
	body {
	  background: #5E5861;
	  font-family: "Roboto", sans-serif;
	  -webkit-font-smoothing: antialiased;
	  -moz-osx-font-smoothing: grayscale;      
	}
</style>

<div class="container-fluid">

	<div class="login-page col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4">
		<div class="form">
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
		</div>
	</div>
</div>

@endsection