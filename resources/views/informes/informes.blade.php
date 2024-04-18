@extends('layouts.app')

@section('title', 'Healthub - Informes')
@section('page', 'Informes')

@section('content')
    <a href="#" class="btn btn-primary mb-2">Crear informe</a>
    <div class="row row-cols-2">
        @if(count($informes) > 0)
            @foreach($informes as $informe)
                <div class="col">
                    <div class="card card-informe">
                        <div class="card-header p-3 d-flex justify-content-between align-items-center">
                            {{ $informe->motivo_consulta }}
                            <div class="d-flex gap-1">
                                <a href="#" class="btn btn-secondary">Editar informe</a>
                                <form method="POST" action="#}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" name="eliminarInformeForm" class="btn btn-danger" value="Eliminar informe">
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5>Nombre del paciente</h5>
                                    <p>{{$informe->paciente->nombre}} {{$informe->paciente->apellido1}} {{$informe->paciente->apellido2}}</p>
                                </div>
                                <div class="col">
                                    <h5>Nombre del medico</h5>
                                    <p>{{$informe->medico->nombre}} {{$informe->medico->apellido1}} {{$informe->medico->apellido2}}</p>
                                </div>
                                <div class="col">
                                    <h5>Asunto</h5>
                                    <p>{{$informe->motivo_consulta}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <h5>Fecha y hora</h5>
                                    <p>{{ $informe->created_at }}</p>
                                </div>
                                <div class="col">
                                    <h5>Ubicacion</h5>
                                    <p>{{$informe->centro}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <h2 class="text-center">No hay informes</h2>
        @endif
    </div>
@endsection