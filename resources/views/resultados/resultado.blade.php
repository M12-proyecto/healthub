@extends('layouts.app')

@section('title', 'Healthub - Resultados')
@section('page', 'Resultados')

@section('content')
    @can('create', $resultadoModel)
        <a href="{{ route('crearResultado') }}" class="btn btn-primary mb-2">Crear resultado</a>
    @endcan
    @if(count($resultados) > 0)
        <div id="resultados" class="table-responsive">
            <table id="tabla-resultados" class="table table-hover tabla-healthub">
                <thead>
                    <tr>
                        <th>Prueba médica</th>
                        <th>Centro</th>
                        <th>Resultado</th>
                        <th>Fecha</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($resultados as $resultado)
                        <tr>
                            <td>{{ $resultado->prueba }}</td>
                            <td>{{ $resultado->centro }}</td>
                            <td>{{ $resultado->resultado }}</td>
                            <td>{{ $resultado->fecha }}</td>
                            <td>
                                @can('read', $resultadoModel)
                                    <a href="{{ route('verResultado', $resultado) }}" class="btn btn-secondary">Ver</a>
                                @endcan
                            </td>
                            <td>
                                @can('update', $resultadoModel)
                                    <a href="{{ route('editarResultado', $resultado) }}" class="btn btn-primary">Editar</a>
                                @endcan
                            </td>
                            <td>
                                @can('delete', $resultadoModel)
                                    <form method="POST" action="{{ route('eliminarResultado', $resultado) }}">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" name="eliminarResultadoForm" class="btn btn-danger" value="Eliminar">
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <h2 class="text-center">No hay resultados</h2>
    @endif
@endsection