@extends('master')

@section('title', 'Đăng nhập')

@section('content')

<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<style type="text/css">
    body {
    padding-top: 40px;
    padding-bottom: 40px;
    background-color: #BAB7B7;
  }
  .fullscreen_bg {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-size: cover;
    background-position: 50% 50%;
    /*background-image: url('http://31.media.tumblr.com/ad65726441493f47e0c8f0473206f4e5/tumblr_mvwl4fCEb21rdpk23o1_1280.jpg');*/
  }
  .form-signin {
    /*max-width: 280px;*/
    width: 100%;
    padding: 15px;
    margin: 10% auto;
  }
  .form-signin .form-signin-heading, .form-signin {
    margin-bottom: 10px;
  }
  .form-signin .form-control {
    position: relative;
    font-size: 16px;
    height: auto;
    padding: 10px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
  }
  .form-signin .form-control:focus {
    z-index: 2;
  }
  .form-signin input[type="text"] {
    margin-bottom: -1px;
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
    border-top-style: solid;
    border-right-style: solid;
    border-bottom-style: none;
    border-left-style: solid;
    border-color: #000;
  }
  .form-signin input[type="password"] {
    margin-bottom: 10px;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    border-top-style: none;
    border-right-style: solid;
    border-bottom-style: solid;
    border-left-style: solid;
    border-color: #000;
  }
  .form-signin-heading {
    color: #fff;
    text-align: center;
    text-shadow: 0 2px 2px rgba(0,0,0,0.7);
  }
  .login_error {
    font-weight: bold;
    color: #FC4C4C;
  }
</style>

<div id="fullscreen_bg" class="fullscreen_bg"/>

<div class="container  col-xs-12 col-sm-4 col-sm-offset-4">

	<form class="form-signin" action="/login" method="POST">
		{!! csrf_field() !!}
		<h1 class="form-signin-heading text-muted">Đăng nhập</h1>
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

@endsection