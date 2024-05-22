<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Resultado PDF</title>
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
                <h2 class="horizontal-item">Resultado médico</h2>
            </div>
        </div>
        <div id="informe-contenido" style="background-color: #f8f8fb;">
            <h4 class="subtitol-informe">Datos del paciente</h4>
            <div id="datosPaciente" class="p-3">
                <div class="horizontal-container">
                    <h5 class="horizontal-item">Nombre: <span>{{ $resultado->paciente->nombre }}</span></h5>
                    <h5 class="horizontal-item">Primer apellido: <span>{{ $resultado->paciente->apellido1 }}</span></h5>
                    <h5 class="horizontal-item">Segundo apellido: <span>{{ $resultado->paciente->apellido2 }}</span></h5>
                </div>
                <div class="horizontal-container">
                    <h5 class="horizontal-item">DNI: <span>{{ $resultado->paciente->dni }}</span></h5>                
                    <h5 class="horizontal-item">CIP: <span>{{ $resultado->paciente->cip }}</span></h5>                
                    <h5 class="horizontal-item">Fecha de nacimiento: <span>{{ $resultado->paciente->fecha_nacimiento }}</span></h5>
                </div>
                <div class="horizontal-container">
                    <h5 class="horizontal-item">Sexo: <span>{{ $resultado->paciente->sexo }}</span></h5>
                    <h5 class="horizontal-item">Peso: <span>{{ $resultado->paciente->getDatosPaciente($resultado->paciente)->peso }} kg</span></h5>
                    <h5 class="horizontal-item">Altura: <span>{{ $resultado->paciente->getDatosPaciente($resultado->paciente)->altura }} m</span></h5>
                    <h5 class="horizontal-item">Grupo sanguineo: <span>{{ $resultado->paciente->getDatosPaciente($resultado->paciente)->grupo_sanguineo }}</span></h5>
                </div>
            </div>
            <h4 class="subtitol-informe">Datos del resultado</h4>
            <div id="datosInforme" class="p-3">
                <div class="horizontal-container">
                    <h5 class="horizontal-item">Prueba: <span>{{ $resultado->prueba }}</span></h5>
                    <h5 class="horizontal-item">Resultado: <span>{{ $resultado->resultado }}</span></h5>
                </div>
                <div class="horizontal-container">
                    <h5 class="horizontal-item">Centro: <span>{{ $resultado->centro }}</span></h5>
                    <h5 class="horizontal-item">Fecha: <span>{{ $resultado->fecha }}</span></h5>
                </div>
                <div class="horizontal-container">
                    <h5 class="horizontal-item">Unidades: <span>{{ $resultado->unidades }}</span></h5>
                    <h5 class="horizontal-item">Valores de normalidad: <span>{{ $resultado->valores_normalidad }}</span></h5>
                </div>
                <div class="horizontal-container">
                    <h5 class="horizontal-item">Observaciones:</h5>
                    <p class="horizontal-item">{{ $resultado->observaciones }}</p>
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