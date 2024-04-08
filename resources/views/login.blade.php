<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="healthub app" name="description" />
    <meta content="masterPro" name="author" />
    <title>Healthub - Login</title>
    <link rel="shortcut icon" href="{{asset('assets/images/faviconHealthHub1.ico')}}">
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    @viteReactRefresh      
    @vite('resources/js/app.js')
</head>
<body class="auth-body-bg">
    <div id="login"></div>
    <!-- JAVASCRIPT -->
    <script src="{{asset('assets/libs/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
    <script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
    <script src="https://kit.fontawesome.com/2007d43c69.js" crossorigin="anonymous"></script>
</body>
</html>