<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Informe PDF</title>
    <!-- App favicon -->

    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="{{ public_path('css/main.css') }}">

    <!-- Bootstrap Css -->
    <link href="{{ public_path('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Icons Css -->
    <link href="{{ public_path('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- App Css-->
    <link href="{{ public_path('assets/css/app.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- App js -->
    <script src="{{ public_path('assets/js/plugin.js') }}"></script>
    <style>
        .horizontal-container {
            text-align: justify; /* Justificar elementos */
        }
        .horizontal-item {
            display: inline-block; /* Colocar elementos en línea */
            margin: 10px; /* Espacio entre elementos */
        }
        .horizontal-item::after {
            content: ''; /* Contenido generado */
            display: inline-block; /* Convertir en bloque */
            width: 100%; /* Ancho completo */
        }
    </style>
</head>
<body data-sidebar="dark">
    <div id="informe">
        <div id="informe-encabezado" class="horizontal-container">
            <div class="horizontal-item">
                <img class="horizontal-item" src="{{ public_path('assets/images/LogoHealthHub3.png') }}" alt="Healthub icon" height="50">
                <h2 class="horizontal-item">Healthub</h2>
                <h2 class="horizontal-item">Informe médico</h2>
            </div>
        </div>
        <div id="informe-contenido" style="background-color: #f8f8fb;">
            <h4 class="subtitol-informe">Datos del paciente</h4>
            <div id="datosPaciente" class="p-3">
                <div class="horizontal-container">
                    <h5 class="horizontal-item">Nombre: <span>{{ $informe->paciente->nombre }}</span></h5>
                    <h5 class="horizontal-item">Primer apellido: <span>{{ $informe->paciente->apellido1 }}</span></h5>
                    <h5 class="horizontal-item">Segundo apellido: <span>{{ $informe->paciente->apellido2 }}</span></h5>
                </div>
                <div class="horizontal-container">
                    <h5 class="horizontal-item">DNI: <span>{{ $informe->paciente->dni }}</span></h5>
                    <h5 class="horizontal-item">CIP: <span>{{ $informe->paciente->cip }}</span></h5>
                    <h5 class="horizontal-item">Fecha de nacimiento: <span>{{ $informe->paciente->fecha_nacimiento }}</span></h5>
                </div>
                <div class="horizontal-container">
                    <h5 class="horizontal-item">Sexo: <span>{{ $informe->paciente->sexo }}</span></h5>
                    <h5 class="horizontal-item">Peso: <span>{{ $informe->paciente->getDatosPaciente($informe->paciente)->peso }} kg</span></h5>
                    <h5 class="horizontal-item">Altura: <span>{{ $informe->paciente->getDatosPaciente($informe->paciente)->altura }} m</span></h5>
                    <h5 class="horizontal-item">Grupo sanguineo: <span>{{ $informe->paciente->getDatosPaciente($informe->paciente)->grupo_sanguineo }}</span></h5>
                </div>
            </div>
            <h4 class="subtitol-informe">Datos del informe</h4>
            <div id="datosInforme" class="p-3">
                <div class="horizontal-container">
                    <h5 class="horizontal-item">Medico responsable: <span>{{ $informe->medico->nombre }} {{ $informe->medico->apellido1 }} {{ $informe->medico->apellido2 }}</span></h5>
                    <h5 class="horizontal-item">Centro: <span>{{ $informe->centro }}</span></h5>
                </div>
                <div class="horizontal-container">
                    <h5 class="horizontal-item">Tipo de informe: <span>{{ $informe->especialidad }}</span></h5>
                    <h5 class="horizontal-item">Fecha y hora del informe: <span>{{ $informe->created_at }}</span></h5>
                </div>
                <div style="margin-left: 10px;">
                    <div class="col-md-12">
                        <h5>Motivo de consulta:</h5>
                        <p>{{ $informe->motivo_consulta }}</p>
                    </div>
                </div>
                <div style="margin-left: 10px;">
                    <div class="col-md-12">
                        <h5>Enfermedad actual:</h5>
                        <p>{{ $informe->enfermedad_actual }}</p>
                    </div>
                </div>
                <div style="margin-left: 10px;">
                    <div class="col-md-12">
                        <h5>Diagnostico:</h5>
                        <p>{{ $informe->diagnostico }}</p>
                    </div>
                </div>
                <div style="margin-left: 10px;">
                    <div class="col-md-12">
                        <h5>Procedimiento:</h5>
                        <p>{{ $informe->procedimiento }}</p>
                    </div>
                </div>
                <div style="margin-left: 10px;">
                    <div class="col-md-12">
                        <h5>Tratamiento:</h5>
                        <p>{{ $informe->tratamiento }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- JAVASCRIPT -->
    <script src="{{ public_path('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ public_path('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ public_path('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ public_path('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ public_path('assets/libs/node-waves/waves.min.js') }}"></script>

    <!-- apexcharts -->
    <script src="{{ public_path('assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- dashboard init -->
    <script src="{{ public_path('assets/js/pages/dashboard.init.js') }}"></script>

    <!-- App js -->
    <script src="{{ public_path('assets/js/app.js') }}"></script>
</body>
</html>