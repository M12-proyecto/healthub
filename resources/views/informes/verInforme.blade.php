@extends('layouts.app')

@section('title', 'Healthub - Ver informe')
@section('page', 'Informes')

@section('content')
<div class="botones-acciones">
    <a href="{{ route('informes') }}" class="btn btn-secondary">Volver a informes</a>
    @can('update', $informeModel)
        <a href="{{ route('editarInforme', $informe) }}" class="btn btn-primary">Editar</a>
    @endcan
    @can('delete', $informeModel)
        <form method="POST" action="{{ route('eliminarInforme', $informe) }}">
            @csrf
            @method('DELETE')
            <input type="submit" name="eliminarInformeForm" class="btn btn-danger" value="Eliminar">
        </form>
    @endcan
    <a href="{{ route('informeGenerarPDF', $informe) }}" target="_blank">
        <img src="{{ asset('img/pdf-icon.png') }}" class="pdf-icon" alt="Generar PDF" title="Generar PDF">
    </a>
</div>
<div id="informe">
    <div id="informe-encabezado" class="d-flex justify-content-between align-items-center p-3">
        <div class="d-flex gap-1 align-items-center">
            <img src="{{ asset('assets/images/faviconHealthHub1.ico') }}" alt="Healthub icon" height="30">
            <h2>Healthub</h2>
        </div>
        <div>
            <h2>Informe médico</h2>
        </div>
    </div>
    <div id="informe-contenido">
        <h4 class="subtitol-informe">Datos del paciente</h4>
        <div id="datosPaciente" class="p-3">
            <div class="row mb-4">
                <div class="col-md-4">
                    <h5>Nombre: <span>{{ $informe->paciente->nombre }}</span></h5>
                </div>
                <div class="col-md-4">
                    <h5>Primer apellido: <span>{{ $informe->paciente->apellido1 }}</span></h5>
                </div>
                <div class="col-md-4">
                    <h5>Segundo apellido: <span>{{ $informe->paciente->apellido2 }}</span></h5>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-4">
                    <h5>DNI: <span>{{ $informe->paciente->dni }}</span></h5>
                </div>
                <div class="col-md-4">
                    <h5>CIP: <span>{{ $informe->paciente->cip }}</span></h5>
                </div>
                <div class="col-md-4">
                    <h5>Fecha de nacimiento: <span>{{ $informe->paciente->fecha_nacimiento }}</span></h5>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-3">
                    <h5>Sexo: <span>{{ $informe->paciente->sexo }}</span></h5>
                </div>
                <div class="col-md-3">
                    <h5>Peso: <span>{{ $informe->paciente->getDatosPaciente($informe->paciente)->peso }} kg</span></h5>
                </div>
                <div class="col-md-3">
                    <h5>Altura: <span>{{ $informe->paciente->getDatosPaciente($informe->paciente)->altura }} m</span></h5>
                </div>
                <div class="col-md-3">
                    <h5>Grupo sanguineo: <span>{{ $informe->paciente->getDatosPaciente($informe->paciente)->grupo_sanguineo }}</span></h5>
                </div>
            </div>
        </div>
        <h4 class="subtitol-informe">Datos del informe</h4>
        <div id="datosInforme" class="p-3">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Medico responsable: <span>{{ $informe->medico->nombre }} {{ $informe->medico->apellido1 }} {{ $informe->medico->apellido2 }}</span></h5>
                </div>
                <div class="col-md-6">
                    <h5>Centro: <span>{{ $informe->centro }}</span></h5>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Tipo de informe: <span>{{ $informe->especialidad }}</span></h5>
                </div>
                <div class="col-md-6">
                    <h5>Fecha y hora del informe: <span>{{ $informe->created_at }}</span></h5>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-12">
                    <h5>Motivo de consulta:</h5>
                    <p>{{ $informe->motivo_consulta }}</p>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-12">
                    <h5>Enfermedad actual:</h5>
                    <p>{{ $informe->enfermedad_actual }}</p>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-12">
                    <h5>Diagnostico:</h5>
                    <p>{{ $informe->diagnostico }}</p>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-12">
                    <h5>Procedimiento:</h5>
                    <p>{{ $informe->procedimiento }}</p>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-12">
                    <h5>Tratamiento:</h5>
                    <p>{{ $informe->tratamiento }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection