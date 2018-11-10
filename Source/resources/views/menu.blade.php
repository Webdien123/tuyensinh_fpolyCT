<!-- Menu -->
<div>
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="background-color: #FFFFFF; margin-left: 8%">
        
        <div class="container">
            <div class="navbar-header">

                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Đây là menu mobile</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">
                    <img src="..\img\logo.png" style="width: 120px; height: 40px; left: 0; top: 5px; position: fixed;">
                </a>
            </div>
            <div id="navbar" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;">
                <ul class="nav navbar-nav">
                    <!-- <li class="active"><a href="/">Google map</a></li> -->
                    <li><a href="/map">Google map</a></li>
                    <li><a href="#">Danh sách đánh dấu</a></li>                    
                    <li><a href="/account">Quản lý người dùng</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ \Session::get("uhoten") }}<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Thông tin tài khoản</a></li>
                            <li><a href="/logout">Đăng xuất</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
        </nav>
</div>