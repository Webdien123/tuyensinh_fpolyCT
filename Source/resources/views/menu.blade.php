<style type="text/css">
    @media (max-width: 1200px) {
        .navbar-header {
            float: none;
        }
        .navbar-left,.navbar-right {
            float: none !important;
        }
        .navbar-toggle {
            display: block;
        }
        .navbar-collapse {
            border-top: 1px solid transparent;
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.1);
        }
        .navbar-fixed-top {
            top: 0;
            border-width: 0 0 1px;
        }
        .navbar-collapse.collapse {
            display: none!important;
        }
        .navbar-nav {
            float: none!important;
            margin-top: 7.5px;
        }
        .navbar-nav>li {
            float: none;
        }
        .navbar-nav>li>a {
            padding-top: 10px;
            padding-bottom: 10px;
        }
        .collapse.in{
            display:block !important;
        }
    }
</style>

<?php
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $date = date("d-m-Y");
?>

<nav class="navbar navbar-default" style="margin-bottom: 0px;">
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
            <li><a href="/">
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
                <li><a href="/nhatki{{ "/".$date }}">
                    <i class="fa fa-history" aria-hidden="true"></i>
                    Nhật ký hệ thống
                </a></li>
            @endif
        </ul>
        <ul class="nav navbar-nav navbar-right">
            @if(\Session::get("uname") == "fpolyct")
                <li><a href="#">
                    <img class="avatar" src="../img/title_icon.png" style="width: 30px; top: -20px; display:inline;">

                    {{ " ".Session::get("uhoten") }}
                </a></li>
            @else
                <li><a href="/profile">
                    <img id="img_avt" class="avatar" style="width: 30px; top: -20px; display:inline;">

                    {{ " ".Session::get("uhoten") }}
                </a></li>
            @endif
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