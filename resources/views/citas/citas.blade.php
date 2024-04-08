@extends('layouts.app')

@section('title', 'Healthub - Citas')
@section('page', 'Citas')

@section('content')
<a href="{{ route('crearCita') }}" class="btn btn-primary mb-2">Crear citas</a>
<div class="row row-cols-2">
    @if(count($citas) > 0)
        @foreach($citas as $cita)
            <div class="col">
                <div class="card card-cita">
                    <div class="card-header p-3">
                        {{$cita->asunto}}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5>Nombre del paciente</h5>
                                <p>{{$cita->paciente_id->nombre}} {{$cita->paciente_id->apellido1}} {{$cita->paciente_id->apellido2}}</p>
                            </div>
                            <div class="col">
                                <h5>Nombre del medico</h5>
                                <p>{{$cita->medico_id->nombre}} {{$cita->medico_id->apellido1}} {{$cita->medico_id->apellido2}}</p>
                            </div>
                            <div class="col">
                                <h5>Asunto</h5>
                                <p>{{$cita->asunto}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h5>Fecha</h5>
                                <p>{{$cita->fecha}}</p>
                            </div>
                            <div class="col">
                                <h5>Hora</h5>
                                <p>{{$cita->hora}}</p>
                            </div>
                            <div class="col">
                                <h5>Ubicacion</h5>
                                <p>{{$cita->ubicacion}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h5>Notas</h5>
                                <p>{{($cita->notas) ? $cita->notas : "No hay notas"}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <p>No hay citas</p>
    @endif
</div>
@endsection