@extends('layouts.app')

@section('title', 'Healthub - Crear cita')
@section('page', 'Citas')

@section('content')
<div class="row">
    <form method='POST' action='{{ route("crearCita") }}' class="row g-3">
        @csrf

        <div class="col-md-4">
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

        <div class="col-md-4">
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
        <div class="col-md-4">
            <label for="inputAsunto" class="form-label" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Campo obligatorio">Asunto <span class="campo-obligatorio">*</span></label>
            <input type="text" class="form-control" id="inputAsunto" name="asunto" placeholder="Cita para ..." value="{{ old('asunto') }}">
            @error('asunto')
                <div class="alert alert-danger mt-3">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-4">
            <label for="inputFecha" class="form-label" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Campo obligatorio">Fecha <span class="campo-obligatorio">*</span></label>
            <input type="date" class="form-control" id="inputFecha" name="fecha" value="{{ old('fecha') }}">
            @error('fecha')
                <div class="alert alert-danger mt-3">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-4">
            <label for="inputHora" class="form-label" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Campo obligatorio">Hora <span class="campo-obligatorio">*</span></label>
            <input type="time" class="form-control" id="inputHora" name="hora" value="{{ old('hora') }}">
            @error('hora')
                <div class="alert alert-danger mt-3">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-4">
            <label for="inputUbicacion" class="form-label" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Campo obligatorio">Ubicacion <span class="campo-obligatorio">*</span></label>
            <input type="text" class="form-control" id="inputUbicacion" name="ubicacion" placeholder="Hospital, centro médico ..." value="{{ old('ubicacion') }}">
            @error('ubicacion')
                <div class="alert alert-danger mt-3">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-12">
            <label for="inputNotas" class="form-label">Notas</label>
            <textarea class="form-control" id="inputNotas" name="notas" placeholder="Información adicional aqui ..." rows="6">{{ old('notas') }}</textarea>
            @error('notas')
                <div class="alert alert-danger mt-3">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary" name="crearCitaForm">Crear cita</button>
            <a href="{{ route('citas') }}" class="btn btn-danger">Cancelar</a>
        </div>
    </form>
</div>
@endsection