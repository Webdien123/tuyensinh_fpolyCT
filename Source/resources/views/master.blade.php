<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>
        <link rel="shortcut icon" type="image/x-icon" href="..\img\title_icon.jpg" />

        <!-- Bootstrap CSS -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">


        <!--===============================================================================================-->  
        <link rel="stylesheet" type="text/css" href="css/util.css">
        <link rel="stylesheet" type="text/css" href="css/main.css">
        <!--===============================================================================================-->
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.3/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Style collap menu cho mọi size màn hình -->
        <!-- <style type="text/css">
            @media (max-width: 2000px) {
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
        </style> -->
    </head>

    <body style="padding-top: 50px; background-color: #D4ECED">        

        @yield('content')

    </body>
</html>