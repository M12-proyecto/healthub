<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Login | Healthub</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="healthub app" name="description" />
        <meta content="masterPro" name="author" />
        <link rel="shortcut icon" href="{{asset('assets/images/faviconHealthHub1.ico')}}">
        <link rel="stylesheet" href="{{asset('css/main.css')}}">
        @viteReactRefresh      
        @vite('resources/js/app.js')
    </head>
    <body class="auth-body-bg">
        <div id="login"></div>
         <!-- JAVASCRIPT -->
        @vite("resources/assets/libs/jquery/jquery.min.js")
        @vite("resources/assets/libs/bootstrap/js/bootstrap.bundle.min.js")
        @vite("resources/assets/libs/metismenu/metisMenu.min.js")
        @vite("resources/assets/libs/simplebar/simplebar.min.js")
        @vite("resources/assets/libs/apexcharts/apexcharts.min.js")
    </body>
</html>
