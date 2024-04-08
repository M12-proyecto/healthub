<!DOCTYPE html>
<html lang="es">
    <head>        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Healthub</title>
        <link rel="shortcut icon" href="{{asset('assets/images/faviconHealthHub1.ico')}}">
        <link rel="stylesheet" href="{{asset('css/main.css')}}">
        <link href="{{asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
        <script src="{{asset('assets/js/plugin.js')}}"></script>
        @viteReactRefresh      
        @vite('resources/js/App.jsx')
    </head>
    <body data-sidebar="dark">

    <div class="container rounded bg-white mt-5 mb-5">
    <div class="row">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" src="{{ $user->foto }}"><span class="font-weight-bold">{{ $user->nombre   }} {{$user->apellido1}} {{$user->apellido2}} </span><span class="text-black-50">edogaru@mail.com.my</span><span> </span></div>
        </div>
        <div class="col-md-5 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Perfil</h4>
                </div>
                <div class="row mt-2">
                    <div class="col-md-4"><label class="labels">Nombre</label><input type="text" class="form-control" value=""></div>
                    <div class="col-md-4"><label class="labels">primer apellido</label><input type="text" class="form-control" value=""></div>
                    <div class="col-md-4"><label class="labels">segundo apellido</label><input type="text" class="form-control" value=""></div>
                </div>
                <div class="row mt-2">
                <label class="labels">Dirección</label>
                    <div class="col-md-4"><label class="labels">Calle</label><input type="text" class="form-control" value=""></div>
                    <div class="col-md-4"><label class="labels">Piso</label><input type="text" class="form-control" value=""></div>
                    <div class="col-md-4"><label class="labels">Número</label><input type="text" class="form-control" value=""></div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12"><label class="labels">Número teléfono</label><input type="text" class="form-control" value=""></div>
                    <!-- <div class="col-md-12"><label class="labels">Address Line 2</label><input type="text" class="form-control" placeholder="enter address line 2" value=""></div> -->
                    <div class="col-md-12"><label class="labels">Código postal</label><input type="text" class="form-control" value=""></div>
                    <div class="col-md-12"><label class="labels">Correo</label><input type="text" class="form-control" value=""></div>

                </div>
                <div class="row mt-3">
                    <div class="col-md-6"><label class="labels">Cuidad</label><input type="text" class="form-control" value=""></div>
                    <div class="col-md-6"><label class="labels">Código postal</label><input type="text" class="form-control" value=""></div>
                </div>
                <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="button">Actualizar perfil</button></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center experience"><span>Edit Experience</span><span class="border px-3 p-1 add-experience"><i class="fa fa-plus"></i>&nbsp;Experience</span></div><br>
                <div class="col-md-12"><label class="labels">Experience in Designing</label><input type="text" class="form-control" placeholder="experience" value=""></div> <br>
                <div class="col-md-12"><label class="labels">Additional Details</label><input type="text" class="form-control" placeholder="additional details" value=""></div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

    <!-- <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <img src="{{ $user->foto }}" style="width:150px; height:150px; float:left; border-radius:50%; margin-right:25px;">
                <h2>{{ $user->nombre }}'s Profile</h2>
                <form enctype="multipart/form-data" action="/profile" method="POST">

                </form>
            </div>
        </div>
    </div> -->

    <!-- JAVASCRIPT -->
    <script src="{{asset('assets/libs/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
    <script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>
    <script src="{{asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/dashboard.init.js')}}"></script>
    <script src="{{asset('assets/js/app.js')}}"></script>
    </body>
</html>