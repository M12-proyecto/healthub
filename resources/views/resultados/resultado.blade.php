@extends('layouts.app')

@section('title', 'Healthub - Resultados')
@section('page', 'Resultados')

@section('content')
    @can('create', $resultadoModel)
        <a href="{{ route('crearResultado') }}" class="btn btn-primary mb-2">Crear resultado</a>
    @endcan
    <div class="row row-cols-2">
        @if(count($resultados) > 0)
            @foreach($resultados as $resultado)
                <div class="col">
                    <div class="card card-cita">
                        <div class="card-header p-3 d-flex justify-content-between align-items-center">
                            <div class="d-flex gap-1">
                                @can('update', $resultadoModel)
                                    <a href="{{ route('editarResultado', $resultado) }}" class="btn btn-secondary">Editar Resultado</a>
                                @endcan
                                @can('delete', $resultadoModel)
                                    <form method="POST" action="{{ route('eliminarResultado', $resultado) }}">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" name="eliminarResultadoForm" class="btn btn-danger" value="Eliminar Resultado">
                                    </form>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5>Nombre del paciente</h5>
                                    <p>{{$resultado->paciente->nombre}} {{$resultado->paciente->apellido1}} {{$resultado->paciente->apellido2}}</p>
                                </div>
                                <div class="col">
                                    <h5>Nombre del medico</h5>
                                    <p>{{$resultado->medico->nombre}} {{$resultado->medico->apellido1}} {{$resultado->medico->apellido2}}</p>
                                </div>
                                <div class="col">
                                    <h5>Centro</h5>
                                    <p>{{$resultado->centro}}</p>
                                </div>
                            </div>
                            <div class="row">
       
                                <div class="col">
                                    <h5>Fecha</h5>
                                    <p>{{$resultado->fecha}}</p>
                                </div>
                                <div class="col">
                                    <h5>Resultado</h5>
                                    <p>{{$resultado->resultado}}</p>
                                </div>
                                <div class="col">
                                    <h5>Unidades</h5>
                                    <p>{{$resultado->unidades}}</p>
                                </div>
                                <div class="col">
                                    <h5>Valores Normalidad</h5>
                                    <p>{{$resultado->valores_normalidad}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <h5>Prueba</h5>
                                    <p>{{$resultado->prueba}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <h5>Observaciones</h5>
                                    <p>{{($resultado->observaciones) ? $resultado->observaciones : "No hay notas"}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <h2 class="text-center">No hay Resultados</h2>
        @endif
    </div>
@endsection