@extends('layouts.app')

@section('title', 'Healthub - Ver resultado')
@section('page', 'Resultados')

@section('content')
<div id="informe">
    <div id="informe-encabezado" class="d-flex justify-content-between align-items-center p-3">
        <div class="d-flex gap-1 align-items-center">
            <img src="{{ asset('assets/images/faviconHealthHub1.ico') }}" alt="Healthub icon" height="30">
            <h2>Healthub</h2>
        </div>
        <div>
            <h2>Resultado médico</h2>
        </div>
    </div>
    <div id="informe-contenido">
        <h4 class="subtitol-informe">Datos del paciente</h4>
        <div id="datosPaciente" class="p-3">
            <div class="row mb-4">
                <div class="col-md-4">
                    <h5>Nombre: <span>{{ $resultado->paciente->nombre }}</span></h5>
                </div>
                <div class="col-md-4">
                    <h5>Primer apellido: <span>{{ $resultado->paciente->apellido1 }}</span></h5>
                </div>
                <div class="col-md-4">
                    <h5>Segundo apellido: <span>{{ $resultado->paciente->apellido2 }}</span></h5>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-4">
                    <h5>DNI: <span>{{ $resultado->paciente->dni }}</span></h5>
                </div>
                <div class="col-md-4">
                    <h5>CIP: <span>{{ $resultado->paciente->cip }}</span></h5>
                </div>
                <div class="col-md-4">
                    <h5>Fecha de nacimiento: <span>{{ $resultado->paciente->fecha_nacimiento }}</span></h5>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-3">
                    <h5>Sexo: <span>{{ $resultado->paciente->sexo }}</span></h5>
                </div>
                <div class="col-md-3">
                    <h5>Peso: <span>{{ $resultado->paciente->getDatosPaciente($resultado->paciente)->peso }} kg</span></h5>
                </div>
                <div class="col-md-3">
                    <h5>Altura: <span>{{ $resultado->paciente->getDatosPaciente($resultado->paciente)->altura }} m</span></h5>
                </div>
                <div class="col-md-3">
                    <h5>Grupo sanguineo: <span>{{ $resultado->paciente->getDatosPaciente($resultado->paciente)->grupo_sanguineo }}</span></h5>
                </div>
            </div>
        </div>
        <h4 class="subtitol-informe">Datos del resultado</h4>
        <div id="datosInforme" class="p-3">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Prueba: <span>{{ $resultado->prueba }}</span></h5>
                </div>
                <div class="col-md-6">
                    <h5>Resultado: <span>{{ $resultado->resultado }}</span></h5>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Centro: <span>{{ $resultado->centro }}</span></h5>
                </div>
                <div class="col-md-6">
                    <h5>Fecha: <span>{{ $resultado->fecha }}</span></h5>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Unidades: <span>{{ $resultado->unidades }}</span></h5>
                </div>
                <div class="col-md-6">
                    <h5>Valores de normalidad: <span>{{ $resultado->valores_normalidad }}</span></h5>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-12">
                    <h5>Observaciones:</h5>
                    <p>{{ $resultado->obvservaciones }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection