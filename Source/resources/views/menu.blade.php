<nav class="navbar navbar-default" style="margin-bottom: 2px;">
<div class="container-fluid">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
        </button>
        <a class="navbar-brand" href="/">
            <img width="120px" height="40px"src="./img/logo.png" style="position:relative;top:-10px">
        </a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
            <li><a href="/map">Google Map</a></li>
            <li><a href="#">Danh sách trường</a></li>
            <li><a href="/account">Quản lý người dùng</a></li>
            <li><a href="/history">Lịch sử hệ thống</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="#"><span class="glyphicon glyphicon-user"></span>{{ " ".Session::get("uhoten") }}</a></li>
            <li><a href="/logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        </ul>
    </div>
</div>
</nav>