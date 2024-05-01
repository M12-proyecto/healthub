@extends('layouts.app')

@section('title', 'Healthub - Crear informe')
@section('page', 'Informes')

@section('content')
<div class="row">
    <form method='POST' action='{{ route("crearInforme") }}' class="row g-3">
        @csrf

        <div class="col-md-3">
            <label for="inputPaciente" class="form-label" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Campo obligatorio">Paciente <span class="campo-obligatorio">*</span></label>
            <select class="form-select" id="inputPaciente" name="paciente_id">
                @if(count($pacientes) > 0)
                    <option {{ $errors->has('paciente_id') ? 'selected' : '' }}>Seleccionar paciente...</option>
                    @foreach($pacientes as $paciente)
                        <option value="{{ $paciente->id }}" {{ old('paciente_id') == $paciente->id ? 'selected' : '' }}>{{ $paciente->nombre." ".$paciente->apellido1." ".$paciente->apellido2}}</option>
                    @endforeach
                @else
                    <option selected>No hay pacientes</option>
                @endif
            </select>
            @error('paciente_id')
                <div class="alert alert-danger mt-3">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-3">
            <label for="inputMedico" class="form-label" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Campo obligatorio">Medico <span class="campo-obligatorio">*</span></label>
            <select class="form-select" id="inputMedico" name="medico_id">
                @if(count($medicos) > 0)
                    <option {{ $errors->has('medico_id') ? 'selected' : '' }}>Seleccionar medico...</option>
                    @foreach($medicos as $medico)
                        <option value="{{ $medico->id }}" {{ old('medico_id') == $medico->id ? 'selected' : '' }}>{{ $medico->nombre." ".$medico->apellido1." ".$medico->apellido2}}</option>
                    @endforeach
                @else
                    <option selected>No hay medicos</option>
                @endif
            </select>
            @error('medico_id')
                <div class="alert alert-danger mt-3">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-3">
            <label for="inputCentro" class="form-label" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Campo obligatorio">Centro <span class="campo-obligatorio">*</span></label>
            <input type="text" class="form-control" id="inputCentro" name="centro" placeholder="Hospital, centro médico ..." value="{{ old('centro') }}">
            @error('centro')
                <div class="alert alert-danger mt-3">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-3">
            <label for="inputEspecialidad" class="form-label" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Campo obligatorio">Especialidad <span class="campo-obligatorio">*</span></label>
            <input type="text" class="form-control" id="inputEspecialidad" name="especialidad" placeholder="Especialidad médica ..." value="{{ old('especialidad') }}">
            @error('especialidad')
                <div class="alert alert-danger mt-3">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="inputMotivoConsulta" class="form-label" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Campo obligatorio">Motivo de la consulta <span class="campo-obligatorio">*</span></label>
            <textarea class="form-control" id="inputMotivoConsulta" name="motivo_consulta" rows="6">{{ old('motivo_consulta') }}</textarea>
            @error('motivo_consulta')
                <div class="alert alert-danger mt-3">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="inputEnfermedadActual" class="form-label" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Campo obligatorio">Enfermedad actual <span class="campo-obligatorio">*</span></label>
            <textarea class="form-control" id="inputEnfermedadActual" name="enfermedad_actual" rows="6">{{ old('enfermedad_actual') }}</textarea>
            @error('enfermedad_actual')
                <div class="alert alert-danger mt-3">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="inputDiagnostico" class="form-label" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Campo obligatorio">Diagnostico <span class="campo-obligatorio">*</span></label>
            <textarea class="form-control" id="inputDiagnostico" name="diagnostico" rows="6">{{ old('diagnostico') }}</textarea>
            @error('diagnostico')
                <div class="alert alert-danger mt-3">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="inputProcedimiento" class="form-label" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Campo obligatorio">Procedimiento <span class="campo-obligatorio">*</span></label>
            <textarea class="form-control" id="inputProcedimiento" name="procedimiento" rows="6">{{ old('procedimiento') }}</textarea>
            @error('procedimiento')
                <div class="alert alert-danger mt-3">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-12">
            <label for="inputTratamiento" class="form-label" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Campo obligatorio">Tratamiento <span class="campo-obligatorio">*</span></label>
            <textarea class="form-control" id="inputTratamiento" name="tratamiento" rows="6">{{ old('tratamiento') }}</textarea>
            @error('tratamiento')
                <div class="alert alert-danger mt-3">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary" name="crearInformeForm">Crear informe</button>
        </div>
    </form>
</div>
@endsection