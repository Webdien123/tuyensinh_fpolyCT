<nav class="navbar navbar-default" style="margin-bottom: 10px;">
<div class="container-fluid">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
        </button>
        <a class="navbar-brand" href="/">
            <img width="120px" height="40px"src="../img/logo.png" style="position:relative;top:-10px">
        </a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
            <li><a href="/map">
                <i class="fa fa-globe" aria-hidden="true"></i>
                Google Map
            </a></li>
            <li><a href="/dstruong">
                <i class="fa fa-list-ul" aria-hidden="true"></i>
                Danh sách trường
            </a></li>

            @if(\Session::get("ulevel") == '1')
                <li><a href="/account">
                    <i class="fa fa-address-book" aria-hidden="true"></i>
                    Quản lý tài khoản
                </a></li>
                <!-- <li><a href="#" onclick="alert('Chức năng đang phát triển')">
                    <i class="fa fa-history" aria-hidden="true"></i>
                    Lịch sử hệ thống
                </a></li> -->
            @endif
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="/profile">
                <img id="img_avt" class="avatar" style="width: 30px; top: -20px; display:inline;">

                {{ " ".Session::get("uhoten") }}
            </a></li>
            <li><a href="/logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        </ul>
    </div>

    <script type="text/javascript">
        jQuery(document).ready(function($) {
        
        var avt_path = '{{ url("/") }}' + "/avt/" + '{{ \Session::get("uname") }}' + ".png";
        $("#img_avt").attr('src', avt_path);

        $("#img_avt").error(function () {
            if ( $(this).attr("src").indexOf("png") != -1 ) {
                $(this).unbind("error").attr("src", $(this).attr("src").replace("png", "jpg"));
            }
            $("#img_avt").error(function () {
                if ( $(this).attr("src").indexOf("jpg") != -1 ) {
                    $(this).unbind("error").attr("src", $(this).attr("src").replace("jpg", "gif"));
                }
                $("#img_avt").error(function () {
                    $(this).unbind("error").attr("src", "../img/no_avt.png");
                });
            });
        });
        });
    </script>
</div>
</nav>