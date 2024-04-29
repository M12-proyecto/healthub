@extends('layouts.app')

@section('title', 'Healthub - Informes')
@section('page', 'Informes')

@section('content')
    <a href="{{ route('crearInforme') }}" class="btn btn-primary mb-2">Crear informe</a>
    @if(count($informes) > 0)
        <div id="informes" class="table-responsive">
            <table id="tabla-informes" class="table table-hover">
                <thead>
                    <tr>
                        <th>Tipo de informe</th>
                        <th>Archivo PDF</th>
                        <th>Diagnostico</th>
                        <th>Motivo consulta</th>
                        <th>Centro sanitario</th>
                        <th>Fecha y hora</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($informes as $informe)
                        <tr>
                            <td>{{ $informe->especialidad }}</td>
                            <td></td>
                            <td>{{ $informe->diagnostico }}</td>
                            <td>{{ $informe->motivo_consulta }}</td>
                            <td>{{ $informe->centro }}</td>
                            <td>{{ $informe->created_at }}</td>
                            <td>
                                <a href="{{ route('verInforme', $informe) }}" class="btn btn-secondary">Ver</a>
                            </td>
                            <td>
                                <a href="{{ route('editarInforme', $informe) }}" class="btn btn-primary">Editar</a>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('eliminarInforme', $informe) }}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" name="eliminarInformeForm" class="btn btn-danger" value="Eliminar">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <h2 class="text-center">No hay informes</h2>
    @endif
@endsection