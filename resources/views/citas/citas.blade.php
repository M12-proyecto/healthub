@extends('layouts.app')

@section('title', 'Healthub - Citas')
@section('page', 'Citas')

@section('content')
    @can('create', $citaModel)
        <a href="{{ route('crearCita') }}" class="btn btn-primary mb-2">{{ $usuario->getRole() === 'Paciente' ? 'Solicitar cita' : 'Crear cita'}}</a>
    @endcan
    @if(count($citas) > 0)
        <div id="citas">
            @foreach($citas as $cita)
                <div class="card card-cita">
                    <div class="card-header card-cita-header p-3 d-flex justify-content-between align-items-center">
                        {{$cita->asunto}}
                        <div class="d-flex gap-1">
                            <a href="{{ route('citaGenerarPDF', $cita) }}" target="_blank">
                                <img src="{{ asset('img/pdf-icon.png') }}" class="pdf-icon" alt="Generar PDF" title="Generar PDF">
                            </a>
                            @can('update', $citaModel)
                                <a href="{{ route('editarCita', $cita) }}" class="btn btn-primary">Editar</a>
                            @endcan
                            @can('delete', $citaModel)
                                <form method="POST" action="{{ route('eliminarCita', $cita) }}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" name="eliminarCitaForm" class="btn btn-danger" value="Eliminar">
                                </form>
                            @endcan
                        </div>
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
            @endforeach
        </div>
    @else
        <h2 class="text-center">No hay citas</h2>
    @endif
@endsection