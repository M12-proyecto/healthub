@extends('layouts.app')

@section('title', 'Healthub - Informes')
@section('page', 'Informes')

@section('content')
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
                                <form action="{{ route('verInforme', $informe) }}">
                                    <input type="submit" class="btn btn-secondary" value="Ver">
                                </form>
                            </td>
                            <td>
                                <form action="">
                                    <input type="submit" class="btn btn-primary" value="Editar">
                                </form>
                            </td>
                            <td>
                                <form action="">
                                    <input type="submit" class="btn btn-danger" value="Eliminar">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <h2>No hay informes</h2>
    @endif
@endsection