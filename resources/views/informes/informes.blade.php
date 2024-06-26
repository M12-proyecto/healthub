@extends('layouts.app')

@section('title', 'Healthub - Informes')
@section('page', 'Informes')

@section('content')
    @can('create', $informeModel)
        <a href="{{ route('crearInforme') }}" class="btn btn-primary mb-2">Crear informe</a>
    @endcan
    @if(count($informes) > 0)
        <div id="informes" class="table-responsive">
            <table id="tabla-informes" class="table tabla-healthub">
                <thead>
                    <tr>
                        <th>Tipo de informe</th>
                        <th>Diagnostico</th>
                        <th>Motivo consulta</th>
                        <th>Centro sanitario</th>
                        <th>Fecha y hora</th>
                        <th>Archivo PDF</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($informes as $informe)
                        <tr>
                            <td>{{ $informe->especialidad }}</td>
                            <td>{{ $informe->diagnostico }}</td>
                            <td>{{ $informe->motivo_consulta }}</td>
                            <td>{{ $informe->centro }}</td>
                            <td>{{ $informe->created_at }}</td>
                            <td>
                                <a href="{{ route('informeGenerarPDF', $informe) }}" target="_blank">
                                    <img src="{{ asset('img/pdf-icon.png') }}" class="pdf-icon" alt="Generar PDF" title="Generar PDF">
                                </a>
                            </td>
                            <td>
                                @can('read', $informeModel)
                                    <a href="{{ route('verInforme', $informe) }}" class="btn btn-secondary">Ver</a>
                                @endcan
                            </td>
                            <td>
                                @can('update', $informeModel)
                                    <a href="{{ route('editarInforme', $informe) }}" class="btn btn-primary">Editar</a>
                                @endcan
                            </td>
                            <td>
                                @can('delete', $informeModel)
                                    <form method="POST" action="{{ route('eliminarInforme', $informe) }}">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" name="eliminarInformeForm" class="btn btn-danger" value="Eliminar">
                                    </form>
                                @endcan
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