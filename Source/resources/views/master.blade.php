<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>
        <link rel="shortcut icon" type="image/x-icon" href="../img/title_icon.png">

        <!-- Global CSS -->
        <link rel="stylesheet" type="text/css" href="../css/main.css">

        <!-- Bootstrap CSS -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">

        <!-- jQuery -->
        <script src="../js/jquery.min.js"></script>

        <!-- Jquery validation -->
        <script src="../js/jquery.validate.min.js"></script>

        <!-- Bootstrap JavaScript -->
        <script src="../js/bootstrap.min.js"></script>

        <!-- Custom menu navbar -->
        <link rel="stylesheet" type="text/css" href="../css/menu.css">

        <!-- font awsome icons -->
        <link rel="stylesheet" href="../css/font-awesome.min.css">
    </head>
    
    <body>
        @yield('content')
    </body>
</html>