@extends('layouts.app')
@section('title', 'Healthub - perfil')
@section('page', 'perfil')

@section('content')
<div class="container rounded bg-white mt-5 mb-5">
    <form action="{{ route('profile') }}" method="POST" class="row" enctype="multipart/form-data">
        @csrf

        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
            <img class="rounded-circle mt-5" width="150px" src="{{$usuario->foto ? $usuario->foto : asset('assets/images/users/default.webp') }}">  
                <span class="font-weight-bold">{{ $usuario->nombre }} {{$usuario->apellido1}} {{$usuario->apellido2}} </span>
                <span class="text-black-50">{{$correos_electronicos->correo_electronico}}</span>
            </div>
        </div>
        <div class="col-md-5 border-right">
            <div class="p-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Perfil</h4>
                </div>
                <div class="row mt-2">
                    <div class="col-md-4"><label class="labels">Nombre</label><input type="text" name="nombre" class="form-control" value="{{ $usuario->nombre ? $usuario->nombre : '' }}"></div>
                    <div class="col-md-4"><label class="labels">Primer apellido</label><input type="text" name="apellido1" class="form-control" value="{{ $usuario->apellido1 ? $usuario->apellido1 : '' }}"></div>
                    <div class="col-md-4"><label class="labels">Segundo apellido</label><input type="text" name="apellido2" class="form-control" value="{{ $usuario->apellido2 ? $usuario->apellido2 : '' }}"></div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12"><label class="labels">DNI</label><input type="text" name="dni" class="form-control" value="{{ $usuario->dni ? $usuario->dni : '' }}" readonly></div>
                    <div class="col-md-12"><label class="labels">CIP</label><input type="text" name="cip" class="form-control" value="{{ $usuario->cip ? $usuario->cip : '' }}" readonly></div>
                    <div class="col-md-12"><label class="labels">Cambiar contraseña</label><input type="password" name="change_password" placeholder="Escribe tu nueva contraseña" class="form-control"></div>
                    <div class="col-md-12">
                        <label class="labels">Role</label>
                        <select class="form-control" id="asignRol" name="role">
                            <option value="Paciente" {{ $usuario->hasRole('Paciente') ? 'selected' : '' }}>Paciente</option>
                            <option value="Administrador" {{ $usuario->hasRole('Administrador') ? 'selected' : '' }}>Administrador</option>
                            <option value="Recepcionista" {{ $usuario->hasRole('Recepcionista') ? 'selected' : '' }}>Recepcionista</option>
                            <option value="Medico" {{ $usuario->hasRole('Medico') ? 'selected' : '' }}>Medico</option>
                        </select>
                    </div>
                    <div class="col-md-12"><label class="labels">Fecha de nacimiento</label><input type="date" name="fecha_nacimiento" class="form-control" value="{{ $usuario->fecha_nacimiento }}" readonly></div>
                    <div class="col-md-12"><label class="labels">Sexo</label>
                        <select class="form-control" id="gender" name="gender">
                            <option value="Hombre" {{ $usuario->sexo == 'Hombre' ? 'selected' : '' }}>Hombre</option>
                            <option value="Mujer" {{ $usuario->sexo == 'Mujer' ? 'selected' : '' }}>Mujer</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                    <label class="labels">Foto perfil</label>
                    <input type="file" name="foto" alt="imagen de perfil" class="form-control mt-2">
                </div>
                </div>
                <div class="col-md-12"><label class="labels">Número teléfono</label><input type="text" name="numero_telefono" class="form-control" value="{{ $numeros_telefono->numero_telefono ? $numeros_telefono->numero_telefono : '' }}"></div>
                <div class="col-md-12"><label class="labels">Correo</label><input type="text" name="correo_electronico" class="form-control" value="{{ $correos_electronicos->correo_electronico ? $correos_electronicos->correo_electronico : '' }}"></div>
                <div class="row">
                    <div class="col-md-6"><label class="labels">Cuidad</label><input type="text" name="ciudad" class="form-control" value="{{ $direcciones->ciudad ? $direcciones->ciudad : '' }}"></div>
                    <div class="col-md-6"><label class="labels">Código postal</label>
                        <input type="text" name="codigo_postal" class="form-control" value="{{ $direcciones->codigo_postal ? $direcciones->codigo_postal : '' }}">
                        <input type="text" name="user" class="form-control d-none" value="{{ $usuario }}">
                    </div>
                </div>
            </div>
            <div class="mt-5 text-center"><button class="btn btn-primary profile-button" name="updateProfile" type="submit">Actualizar perfil</button></div>
        </div>
        <div class="col-md-4">
            <div class="p-3">
                <div class="col-md-12"><label class="labels">Calle</label><input type="text" name="calle" class="form-control" value="{{ $direcciones->calle ? $direcciones->calle : '' }}"></div> <br>
                <div class="col-md-12"><label class="labels">Piso</label><input type="text" name="piso" class="form-control" value="{{ $direcciones->piso ? $direcciones->piso : '' }}"></div>
                <div class="col-md-12"><label class="labels">Número</label><input type="text" name="numero" class="form-control" value="{{ $direcciones->numero ? $direcciones->numero : '' }}"></div>
            </div>
            @if($usuario->hasRole('Paciente') && $paciente)
            <div class="p-3">
                <div class="col-md-12"><label class="labels">Peso</label><input type="text" name="peso" class="form-control" value="{{ $paciente ? $paciente->peso : ''  }}"></div> <br>
                <div class="col-md-12"><label class="labels">Altura</label><input type="text" name="altura" class="form-control" value="{{ $paciente ? $paciente->altura : '' }}"></div>
                <div class="col-md-12"><label class="labels">Grupo sanguineo</label>
                    <select class="form-control" id="grupo_sanguineo" name="grupo_sanguineo">
                        <option value="A+" {{ $paciente->grupo_sanguineo == 'A+' ? 'selected' : ''}}>A+</option>
                        <option value="A-" {{ $paciente->grupo_sanguineo == 'A-' ? 'selected' : ''}}>A-</option>
                        <option value="B+" {{ $paciente->grupo_sanguineo == 'B+' ? 'selected' : ''}}>B+</option>
                        <option value="B-" {{ $paciente->grupo_sanguineo == 'B-' ? 'selected' : ''}}>B-</option>
                        <option value="AB+" {{ $paciente->grupo_sanguineo == 'AB+' ? 'selected' : ''}}>AB+</option>
                        <option value="AB-" {{ $paciente->grupo_sanguineo == 'AB-' ? 'selected' : ''}}>AB-</option>
                        <option value="0+" {{ $paciente->grupo_sanguineo == 'O+' ? 'selected' : ''}}>O+</option>
                        <option value="0-" {{ $paciente->grupo_sanguineo == 'O-' ? 'selected' : ''}}>O-</option>
                    </select>
                </div>
            </div>
            <div class="p-3">
                <label class="labels">Contactos de emergencia</label>
                <div class="col-md-12"><label class="labels">Nombre</label><input type="text" name="contacto_nombre" class="form-control" value="{{ $contactos_emergencia ? $contactos_emergencia->nombre : ''}}"></div> <br>
                <div class="col-md-12"><label class="labels">Número de teléfono</label><input type="text" name="contacto_numero" class="form-control" value="{{ $contactos_emergencia ? $contactos_emergencia->numero_telefono : '' }}"></div>
                <div class="col-md-12"><label class="labels">Correo electronico</label><input type="text" name="contacto_correo" class="form-control" value="{{ $contactos_emergencia ? $contactos_emergencia->correo_electronico : '' }}"></div>
            </div>
            @endif
        </div>
    </form>
</div>
@endsection