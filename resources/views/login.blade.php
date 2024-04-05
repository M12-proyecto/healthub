<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="healthub app" name="description" />
    <meta content="masterPro" name="author" />
    <title>Healthub - Login</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('assets/images/faviconHealthHub1.ico')}}">

    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="{{asset('css/main.css')}}">

    <!-- Bootstrap Css -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
    <!-- App js -->
    <script src="{{asset('assets/js/plugin.js')}}"></script>
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
</body>
</html>
