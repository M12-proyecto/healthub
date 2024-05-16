@extends('layouts.app')
@section('title', 'Healthub - perfil')
@section('page', 'perfil')

@section('content')
<div id="perfil" class="container rounded mt-5 mb-5 pb-3">
    <form action="{{ route('profile') }}" method="POST" class="row" enctype="multipart/form-data">
        @csrf

        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
            <img class="rounded-circle mt-5" width="150px" src="{{$usuario->foto ? $usuario->foto : asset('assets/images/users/default.webp') }}">  
                <span class="font-weight-bold">{{ $usuario->nombre }} {{$usuario->apellido1}} {{$usuario->apellido2}} </span>
                <span>{{$correos_electronicos->correo_electronico}}</span>
            </div>
        </div>
        <div class="col-md-5 border-right">
            <div class="p-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Perfil</h4>
                </div>
                <div class="row mt-2">
                    <div class="col-md-4">
                        <label class="labels" class="form-label" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Campo obligatorio">Nombre <span class="campo-obligatorio">*</span></label>
                        <input type="text" name="nombre" class="form-control" placeholder="Nombre..." value="{{ $usuario->nombre ? $usuario->nombre : '' }}">
                        @error('nombre')
                            <div class="alert alert-danger mt-3">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="labels" class="form-label" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Campo obligatorio">Primer apellido <span class="campo-obligatorio">*</span></label>
                        <input type="text" name="apellido1" class="form-control" placeholder="Primer apellido..." value="{{ $usuario->apellido1 ? $usuario->apellido1 : '' }}">
                        @error('apellido1')
                            <div class="alert alert-danger mt-3">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="labels" class="form-label" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Campo obligatorio">Segundo apellido <span class="campo-obligatorio">*</span></label>
                        <input type="text" name="apellido2" class="form-control" placeholder="Segundo apellido" value="{{ $usuario->apellido2 ? $usuario->apellido2 : '' }}">
                        @error('apellido2')
                            <div class="alert alert-danger mt-3">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <label class="labels" class="form-label" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Campo obligatorio">DNI <span class="campo-obligatorio">*</span></label>
                        <input type="text" name="dni" class="form-control" value="{{ $usuario->dni ? $usuario->dni : '' }}" readonly>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label class="labels" class="form-label" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Campo obligatorio">CIP <span class="campo-obligatorio">*</span></label>
                        <input type="text" name="cip" class="form-control" value="{{ $usuario->cip ? $usuario->cip : '' }}" readonly>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label class="labels">Cambiar contraseña</label>
                        <input type="password" name="change_password" placeholder="Escribe tu nueva contraseña" class="form-control">
                        @error('change_password')
                            <div class="alert alert-danger mt-3">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12 mt-3">
                        <label class="labels" class="form-label" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Campo obligatorio">Rol <span class="campo-obligatorio">*</span></label>
                        <select class="form-control" id="asignRol" name="role">
                            <option value="Paciente" {{ $usuario->hasRole('Paciente') ? 'selected' : '' }}>Paciente</option>
                            <option value="Administrador" {{ $usuario->hasRole('Administrador') ? 'selected' : '' }}>Administrador</option>
                            <option value="Recepcionista" {{ $usuario->hasRole('Recepcionista') ? 'selected' : '' }}>Recepcionista</option>
                            <option value="Medico" {{ $usuario->hasRole('Medico') ? 'selected' : '' }}>Medico</option>
                        </select>
                        @error('role')
                            <div class="alert alert-danger mt-3">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12 mt-3">
                        <label class="labels" class="form-label" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Campo obligatorio">Fecha de nacimiento <span class="campo-obligatorio">*</span></label>
                        <input type="date" name="fecha_nacimiento" class="form-control" value="{{ $usuario->fecha_nacimiento }}" readonly>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label class="labels" class="form-label" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Campo obligatorio">Sexo <span class="campo-obligatorio">*</span></label>
                        <select class="form-control" id="gender" name="gender">
                            <option value="Hombre" {{ $usuario->sexo == 'Hombre' ? 'selected' : '' }}>Hombre</option>
                            <option value="Mujer" {{ $usuario->sexo == 'Mujer' ? 'selected' : '' }}>Mujer</option>
                        </select>
                        @error('gender')
                            <div class="alert alert-danger mt-3">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12 mt-3">
                        <label class="labels">Foto perfil</label>
                        <input type="file" name="foto" alt="imagen de perfil" class="form-control mt-2">
                        @error('foto')
                            <div class="alert alert-danger mt-3">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <label class="labels" class="form-label" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Campo obligatorio">Número teléfono <span class="campo-obligatorio">*</span></label>
                    <input type="text" name="numero_telefono" class="form-control" placeholder="Numero de telefono ..." value="{{ $numeros_telefono->numero_telefono ? $numeros_telefono->numero_telefono : '' }}">
                    @error('numero_telefono')
                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-12 mt-3">
                    <label class="labels" class="form-label" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Campo obligatorio">Correo electrónico <span class="campo-obligatorio">*</span></label>
                    <input type="text" name="correo_electronico" class="form-control" placeholder="Correo electronico ..." value="{{ $correos_electronicos->correo_electronico ? $correos_electronicos->correo_electronico : '' }}">
                    @error('correo_electronico')
                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label class="labels">Ciudad</label>
                        <input type="text" name="ciudad" class="form-control" placeholder="Ciudad ..." value="{{ $direcciones->ciudad ? $direcciones->ciudad : '' }}">
                        @error('ciudad')
                            <div class="alert alert-danger mt-3">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6"><label class="labels">Código postal</label>
                        <input type="text" name="codigo_postal" class="form-control" placeholder="Codigo postal ..." value="{{ $direcciones->codigo_postal ? $direcciones->codigo_postal : '' }}">
                        @error('codigo_postal')
                            <div class="alert alert-danger mt-3">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mt-5 text-center"><button class="btn btn-primary profile-button" name="updateProfile" type="submit">Actualizar perfil</button></div>
        </div>
        <div class="col-md-4">
            <div class="p-3">
                <div class="col-md-12">
                    <label class="labels">Calle</label>
                    <input type="text" name="calle" class="form-control" placeholder="Calle ..." value="{{ $direcciones->calle ? $direcciones->calle : '' }}">
                    @error('calle')
                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label class="labels">Piso</label>
                    <input type="text" name="piso" class="form-control" placeholder="Numero de piso ..." value="{{ $direcciones->piso ? $direcciones->piso : '' }}">
                    @error('piso')
                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label class="labels">Número de puerta</label>
                    <input type="text" name="numero" class="form-control" placeholder="Numero de puerta ..." value="{{ $direcciones->numero ? $direcciones->numero : '' }}">
                    @error('numero')
                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            @if($usuario->hasRole('Paciente') && $paciente)
                <div class="p-3">
                    <div class="col-md-12">
                        <label class="labels">Peso</label>
                        <input type="text" name="peso" class="form-control" placeholder="Peso ..." value="{{ $paciente ? $paciente->peso : ''  }}">
                        @error('peso')
                            <div class="alert alert-danger mt-3">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label class="labels">Altura</label>
                        <input type="text" name="altura" class="form-control" placeholder="Altura" value="{{ $paciente ? $paciente->altura : '' }}">
                        @error('altura')
                            <div class="alert alert-danger mt-3">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label class="labels">Grupo sanguineo</label>
                        <select class="form-control" id="grupo_sanguineo" name="grupo_sanguineo">
                            <option value="" {{ !($paciente->grupo_sanguineo) ? 'selected' : ''}}>Selecciona un grupo sanguineo</option>
                            <option value="A+" {{ $paciente->grupo_sanguineo == 'A+' ? 'selected' : ''}}>A+</option>
                            <option value="A-" {{ $paciente->grupo_sanguineo == 'A-' ? 'selected' : ''}}>A-</option>
                            <option value="B+" {{ $paciente->grupo_sanguineo == 'B+' ? 'selected' : ''}}>B+</option>
                            <option value="B-" {{ $paciente->grupo_sanguineo == 'B-' ? 'selected' : ''}}>B-</option>
                            <option value="AB+" {{ $paciente->grupo_sanguineo == 'AB+' ? 'selected' : ''}}>AB+</option>
                            <option value="AB-" {{ $paciente->grupo_sanguineo == 'AB-' ? 'selected' : ''}}>AB-</option>
                            <option value="O+" {{ $paciente->grupo_sanguineo == 'O+' ? 'selected' : ''}}>O+</option>
                            <option value="O-" {{ $paciente->grupo_sanguineo == 'O-' ? 'selected' : ''}}>O-</option>
                        </select>
                        @error('grupo_sanguineo')
                            <div class="alert alert-danger mt-3">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="p-3">
                    <label class="labels">Contactos de emergencia</label>
                    <div class="col-md-12">
                        <label class="labels">Nombre</label>
                        <input type="text" name="contacto_nombre" class="form-control" placeholder="Nombre del contacto ..." value="{{ $contactos_emergencia ? $contactos_emergencia->nombre : ''}}">
                        @error('contacto_nombre')
                            <div class="alert alert-danger mt-3">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label class="labels">Número de teléfono</label>
                        <input type="text" name="contacto_numero" class="form-control" placeholder="Numero del contacto ..." value="{{ $contactos_emergencia ? $contactos_emergencia->numero_telefono : '' }}">
                        @error('contacto_numero')
                            <div class="alert alert-danger mt-3">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label class="labels">Correo electronico</label>
                        <input type="text" name="contacto_correo" class="form-control" placeholder="Correo del contacto ..." value="{{ $contactos_emergencia ? $contactos_emergencia->correo_electronico : '' }}">
                        @error('contacto_correo')
                            <div class="alert alert-danger mt-3">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            @endif
        </div>
    </form>
</div>
@endsection