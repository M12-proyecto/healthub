@extends('layouts.app')

@section('title', 'Healthub - Editar Resultado')
@section('page', 'Resultados')

@section('content')
<div class="row">
    <form method='POST' action='{{ route("editarResultado", $resultado) }}' class="row g-3">
        @csrf

        <div class="col-md-4">
            <label for="inputPaciente" class="form-label">Paciente</label>
            <select class="form-select" id="inputPaciente" name="paciente_id">
                @if(count($pacientes) > 0)
                    <option {{ $errors->has('paciente_id') ? 'selected' : '' }}>Seleccionar paciente...</option>
                    @foreach($pacientes as $paciente)
                        <option value="{{ $paciente->id }}" {{ old('paciente_id', $resultado->paciente_id) == $paciente->id ? 'selected' : '' }}>{{ $paciente->nombre." ".$paciente->apellido1." ".$paciente->apellido2}}</option>
                    @endforeach
                @else
                    <option selected>No hay pacientes</option>
                @endif
            </select>
            @error('paciente_id')
                <div class="alert alert-danger mt-3">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4">
            <label for="inputMedico" class="form-label">Medico</label>
            <select class="form-select" id="inputMedico" name="medico_id">
                @if(count($medicos) > 0)
                    <option {{ $errors->has('medico_id') ? 'selected' : '' }}>Seleccionar medico...</option>
                    @foreach($medicos as $medico)
                        <option value="{{ $medico->id }}" {{ old('medico_id', $resultado->medico_id) == $medico->id ? 'selected' : '' }}>{{ $medico->nombre." ".$medico->apellido1." ".$medico->apellido2}}</option>
                    @endforeach
                @else
                    <option selected>No hay medicos</option>
                @endif
            </select>
            @error('medico_id')
                <div class="alert alert-danger mt-3">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-4">
            <label for="inputCentro" class="form-label">Centro</label>
            <input type="text" class="form-control" id="inputCentro" name="centro" placeholder="Nombre del centro médico ..." value="{{ old('centro', $resultado->centro) }}">
            @error('centro')
                <div class="alert alert-danger mt-3">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-4">
            <label for="inputFecha" class="form-label">Fecha</label>
            <input type="date" class="form-control" id="inputFecha" name="fecha" value="{{ old('fecha', $resultado->fecha) }}">
            @error('fecha')
                <div class="alert alert-danger mt-3">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-4">
            <label for="inputPrueba" class="form-label">Prueba</label>
            <input type="text" class="form-control" id="inputPrueba" name="prueba" value="{{ old('prueba', $resultado->prueba) }}">
            @error('prueba')
                <div class="alert alert-danger mt-3">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-4">
            <label for="inputResultado" class="form-label">Resultado</label>
            <input type="text" class="form-control" id="inputResultado" name="resultado" placeholder="Resultado de la prueba ..." value="{{ old('resultado', $resultado->resultado) }}">
            @error('resultado')
                <div class="alert alert-danger mt-3">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-4">
            <label for="inputUnidades" class="form-label">Unidades</label>
            <input type="text" class="form-control" id="inputUnidades" name="unidades" placeholder="Unidades ..." value="{{ old('unidades', $resultado->unidades) }}">
            @error('resultado')
                <div class="alert alert-danger mt-3">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-4">
            <label for="inputValoresNormalidad" class="form-label">Valores Normalidad</label>
            <input type="text" class="form-control" id="inputValoresNormalidad" name="valores_normalidad" placeholder="Valores normalida ..." value="{{ old('valores_normalidad', $resultado->valores_normalidad) }}">
            @error('valores_normalidad')
                <div class="alert alert-danger mt-3">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-12">
            <label for="inputObservaciones" class="form-label">Observaciones</label>
            <textarea class="form-control" id="inputObservaciones" name="observaciones" placeholder="Información adicional aqui ..." cols="30" rows="10">{{ old('observaciones', $resultado->observaciones) }}</textarea>
            @error('observaciones')
                <div class="alert alert-danger mt-3">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary" name="editarResultadoForm">Editar cita</button>
        </div>
    </form>
</div>
@endsection