
@extends('layouts.app')
@section('title', 'Healthub - chat')

@viteReactRefresh      
@vite('resources/js/app.js')

@section('page', 'chat')

@section('content')
<body class="auth-body-bg">
    <div id="chat"></div>
    <!-- JAVASCRIPT -->
    <script src="{{asset('assets/libs/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
    <script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
    <script src="https://kit.fontawesome.com/2007d43c69.js" crossorigin="anonymous"></script>
</body>
@endsection