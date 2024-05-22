@extends('layouts.app')
@section('title', 'Healthub - Perfil')
@section('page', 'Perfil')

@section('content')
<div id="perfil" class="container rounded mb-3 p-3">
    <form action="{{ route('profile') }}" method="POST" class="row" enctype="multipart/form-data">
        @csrf

        <div class="col-md-3 d-flex flex-column justify-content-center align-items-center gap-2">
            <img class="rounded-circle" width="150px" src="{{$usuario->foto ? $usuario->foto : asset('assets/images/users/default.webp') }}">  
            <span class="font-weight-bold">{{ $usuario->nombre }} {{$usuario->apellido1}} {{$usuario->apellido2}} </span>
            <span>{{$correos_electronicos->correo_electronico}}</span>
        </div>
        <div id="datos_personales" class="col-md-9">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <h2>Datos personales</h2>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="labels" class="form-label" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Campo obligatorio">Nombre <span class="campo-obligatorio">*</span></label>
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre..." value="{{ old('nombre', $usuario->nombre) }}">
                    @error('nombre')
                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="labels" class="form-label" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Campo obligatorio">Primer apellido <span class="campo-obligatorio">*</span></label>
                    <input type="text" name="apellido1" class="form-control" placeholder="Primer apellido..." value="{{ old('apellido1', $usuario->apellido1) }}">
                    @error('apellido1')
                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="labels" class="form-label" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Campo obligatorio">Segundo apellido <span class="campo-obligatorio">*</span></label>
                    <input type="text" name="apellido2" class="form-control" placeholder="Segundo apellido" value="{{ old('apellido2', $usuario->apellido2) }}">
                    @error('apellido2')
                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="labels" class="form-label" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Campo obligatorio">DNI <span class="campo-obligatorio">*</span></label>
                    <input type="text" name="dni" class="form-control" value="{{ old('dni', $usuario->dni) }}" disabled readonly>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="labels" class="form-label" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Campo obligatorio">CIP <span class="campo-obligatorio">*</span></label>
                    <input type="text" name="cip" class="form-control" value="{{ old('cip', $usuario->cip) }}" disabled readonly>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="labels" class="form-label" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Campo obligatorio">Fecha de nacimiento <span class="campo-obligatorio">*</span></label>
                    <input type="date" name="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento', $usuario->fecha_nacimiento) }}" disabled readonly>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="labels" class="form-label" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Campo obligatorio">Sexo <span class="campo-obligatorio">*</span></label>
                    <select class="form-control" id="gender" name="gender">
                        <option value="Hombre" {{ old('gender', $usuario->sexo) == 'Hombre' ? 'selected' : '' }}>Hombre</option>
                        <option value="Mujer" {{ old('gender', $usuario->sexo) == 'Mujer' ? 'selected' : '' }}>Mujer</option>
                    </select>
                    @error('gender')
                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="labels" class="form-label" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Campo obligatorio">Correo electrónico <span class="campo-obligatorio">*</span></label>
                    <input type="text" name="correo_electronico" class="form-control" placeholder="Correo electronico ..." value="{{ old('correo_electronico', $correos_electronicos->correo_electronico) }}">
                    @error('correo_electronico')
                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="labels" class="form-label" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Campo obligatorio">Número teléfono <span class="campo-obligatorio">*</span></label>
                    <input type="text" name="numero_telefono" class="form-control" placeholder="Numero de telefono ..." value="{{ old('numero_telefono', $numeros_telefono->numero_telefono) }}">
                    @error('numero_telefono')
                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div id="modificar_datos_usuario" class="col-md-12">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <h2>Modificar datos de usuario</h2>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="labels">Cambiar contraseña</label>
                    <input type="password" name="change_password" placeholder="Escribe tu nueva contraseña" class="form-control">
                    @error('change_password')
                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="labels" class="form-label" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Campo obligatorio">Rol <span class="campo-obligatorio">*</span></label>
                    <select class="form-control" id="asignRol" name="role">
                        <option value="Paciente" {{ old('role', $rol_usuario) == 'Paciente' ? 'selected' : '' }}>Paciente</option>
                        <option value="Administrador" {{ old('role', $rol_usuario) == 'Administrador' ? 'selected' : '' }}>Administrador</option>
                        <option value="Recepcionista" {{ old('role', $rol_usuario) == 'Recepcionista' ? 'selected' : '' }}>Recepcionista</option>
                        <option value="Medico" {{ old('role', $rol_usuario) == 'Medico' ? 'selected' : '' }}>Medico</option>
                    </select>
                    @error('role')
                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="labels">Foto perfil</label>
                    <input type="file" name="foto" alt="imagen de perfil" class="form-control">
                    @error('foto')
                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div id="datos_contacto" class="col-md-12">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <h2>Direccion</h2>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="labels">Calle</label>
                    <input type="text" name="calle" class="form-control" placeholder="Calle ..." value="{{ old('calle', $direcciones->calle) }}">
                    @error('calle')
                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="labels">Piso</label>
                    <input type="text" name="piso" class="form-control" placeholder="Numero de piso ..." value="{{ old('piso', $direcciones->piso) }}">
                    @error('piso')
                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="labels">Número de puerta</label>
                    <input type="text" name="numero" class="form-control" placeholder="Numero de puerta ..." value="{{ old('numero', $direcciones->numero) }}">
                    @error('numero')
                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="labels">Ciudad</label>
                    <input type="text" name="ciudad" class="form-control" placeholder="Ciudad ..." value="{{ old('ciudad', $direcciones->ciudad) }}">
                    @error('ciudad')
                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="labels">Código postal</label>
                    <input type="text" name="codigo_postal" class="form-control" placeholder="Codigo postal ..." value="{{ old('codigo_postal', $direcciones->codigo_postal) }}">
                    @error('codigo_postal')
                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div id="datos_contacto" class="col-md-12">
            <div class="row">
                @if($rol_usuario === 'Paciente' && $paciente && $contactos_emergencia)
                    <div class="col-md-12 mb-3">
                        <h2>Datos médicos</h2>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="labels">Peso</label>
                        <input type="text" name="peso" class="form-control" placeholder="Peso ..." value="{{ old('peso', $paciente->peso) }}">
                        @error('peso')
                            <div class="alert alert-danger mt-3">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="labels">Altura</label>
                        <input type="text" name="altura" class="form-control" placeholder="Altura" value="{{ old('altura', $paciente->altura) }}">
                        @error('altura')
                            <div class="alert alert-danger mt-3">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="labels">Grupo sanguineo</label>
                        <select class="form-control" id="grupo_sanguineo" name="grupo_sanguineo">
                            <option value="" {{ old('grupo_sanguineo', $paciente->grupo_sanguineo) == '' ? 'selected' : '' }}>Selecciona un grupo sanguineo</option>
                            <option value="A+" {{ old('grupo_sanguineo', $paciente->grupo_sanguineo) == 'A+' ? 'selected' : '' }}>A+</option>
                            <option value="A-" {{ old('grupo_sanguineo', $paciente->grupo_sanguineo) == 'A-' ? 'selected' : '' }}>A-</option>
                            <option value="B+" {{ old('grupo_sanguineo', $paciente->grupo_sanguineo) == 'B+' ? 'selected' : '' }}>B+</option>
                            <option value="B-" {{ old('grupo_sanguineo', $paciente->grupo_sanguineo) == 'B-' ? 'selected' : '' }}>B-</option>
                            <option value="AB+" {{ old('grupo_sanguineo', $paciente->grupo_sanguineo) == 'AB+' ? 'selected' : '' }}>AB+</option>
                            <option value="AB-" {{ old('grupo_sanguineo', $paciente->grupo_sanguineo) == 'AB-' ? 'selected' : '' }}>AB-</option>
                            <option value="O+" {{ old('grupo_sanguineo', $paciente->grupo_sanguineo) == 'O+' ? 'selected' : '' }}>O+</option>
                            <option value="O-" {{ old('grupo_sanguineo', $paciente->grupo_sanguineo) == 'O-' ? 'selected' : '' }}>O-</option>
                        </select>
                        @error('grupo_sanguineo')
                            <div class="alert alert-danger mt-3">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <h2>Datos de contactos de emergencia</h2>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="labels">Nombre</label>
                        <input type="text" name="contacto_nombre" class="form-control" placeholder="Nombre del contacto ..." value="{{ old('contacto_nombre', $contactos_emergencia->nombre) }}">
                        @error('contacto_nombre')
                            <div class="alert alert-danger mt-3">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="labels">Número de teléfono</label>
                        <input type="text" name="contacto_numero" class="form-control" placeholder="Numero del contacto ..." value="{{ old('contacto_numero', $contactos_emergencia->numero_telefono) }}">
                        @error('contacto_numero')
                            <div class="alert alert-danger mt-3">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="labels">Correo electronico</label>
                        <input type="text" name="contacto_correo" class="form-control" placeholder="Correo del contacto ..." value="{{ old('contacto_correo', $contactos_emergencia->correo_electronico) }}">
                        @error('contacto_correo')
                            <div class="alert alert-danger mt-3">{{ $message }}</div>
                        @enderror
                    </div>
                @endif
            </div>
        </div>
        <div class="text-center">
            <button class="btn btn-primary profile-button" name="updateProfile" type="submit">Actualizar perfil</button>
        </div>
    </form>
</div>
@endsection