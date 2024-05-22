<?php

namespace App\Http\Controllers;

use App\Models\contactos_emergencia;
use App\Models\correos_electronicos;
use App\Models\direcciones;
use App\Models\Empleados;
use App\Models\numeros_telefono;
use App\Models\pacientes;
// use App\Models\Role;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use HasApiTokens;
    public function __construct(){}

    public function register(Request $request)
    {
        $response = ["success" => false];

        $request->merge(['numeroDocumento' => $this->sanitize($request->numeroDocumento)]);
        $request->merge(['cip' => $this->sanitize($request->cip)]);
        $request->merge(['nombre' => $this->sanitize($request->nombre)]);
        $request->merge(['primerApellido' => $this->sanitize($request->primerApellido)]);
        $request->merge(['secondApellido' => $this->sanitize($request->secondApellido)]);
        $request->merge(['password' => $this->sanitize($request->password)]);
        $request->merge(['fechaNacimiento' => $this->sanitize($request->fechaNacimiento)]);
        $request->merge(['role' => $this->sanitize($request->role)]);
        $request->merge(['gender' => $this->sanitize($request->gender)]);

        $validate = Validator::make($request->all(),[
            'numeroDocumento' => 'required|string|max:255',
            'cip' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'primerApellido' => 'required|string|max:255',
            'secondApellido' => 'required|string|max:255',
            'password' => 'required|string',
            'fechaNacimiento' => 'required|date_format:Y-m-d',
            'role' => 'required|string|in:Paciente,Medico',
            'gender' => 'required|string|in:Mujer,Hombre'
        ]);

        if($validate->fails()) {
            $response = ["error" => $validate->errors()];
            return response()->json($response,200);
        }

        $usuario = User::create([
            'dni' => $request->numeroDocumento,
            'cip' => $request->cip,
            'password' => Hash::make($request->password),
            'nombre' => $request->nombre,
            'apellido1' => $request->primerApellido,
            'apellido2' => $request->secondApellido,
            'fecha_nacimiento' => $request->fechaNacimiento,
            'sexo' => $request->gender,
            'foto' => $request->perfil,
        ]);
        
        // Asignar role
        if($request->role) {
            $role = Role::where('name', $request->role)->first();
            $usuario->roles()->detach();
            $usuario->roles()->attach($role, ['model_type' => User::class]);

            if($request->role == 'Medico'){
                $medico = Empleados::create([
                    'usuario_id' => $usuario->id,
                    'planta' => null,
                    'sala' => null
                ]);
            } else {
                $paciente = pacientes::create([
                    'usuario_id' => $usuario->id,
                    'peso' => null,
                    'altura' => null,
                    'grupo_sanguineo' => null
                ]);
            }
        }

        $response["success"] = true;

        foreach ($request->telefonos as $telefono) {
            // Guardar teléfonos
            $numerosTelefono = numeros_telefono::create([
                'usuario_id' => $usuario->id,
                'numero_telefono' => $telefono['telefono'],
            ]);
        }

        // Guardar direcciones
        $direcciones = direcciones::create([
            'usuario_id' => $usuario->id,
            'ciudad' => $request->ciudad,
            'calle' => $request->calle,
            'numero' => $request->numero,
            'piso' => $request->piso,
            'codigo_postal' => $request->codigoPostal,
        ]);

        // Guardar correos electrónicos
        foreach ($request->correos as $correo) {
            $correos = correos_electronicos::create([
                'usuario_id' => $usuario->id,
                'correo_electronico' => $correo['correo'],
            ]);
        }

        // Guardar personas de contacto
        if($request->role == 'Paciente') {
            foreach ($request->personaContacto as $contacto) {
                $contacto_emergencia = contactos_emergencia::create([
                    'paciente_id' => $usuario->id,
                    'nombre' => $contacto['nombreContacte'],
                    'numero_telefono' => $contacto['telefono'],
                    'correo_electronico' => $contacto['email'],
                ]);
            }
        }
        
        return response()->json($response, 200);
    }

    public function login(Request $request)
    {
        $response = ["success" => false];

        $request->merge(['dni' => $this->sanitize($request->dni)]);
        $request->merge(['password' => $this->sanitize($request->password)]);
    
        $validate = Validator::make($request->all(), [
            'dni' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);
    
        if ($validate->fails()) {
            $response = ["error" => $validate->errors()];
            return response()->json($response, 200);
        }

        if (Auth::attempt($request->only('dni', 'password'))) {
            $user = User::where('dni', $request->dni)->first();
            $response["token"] = $user->createToken('healthub')->plainTextToken;
            $response['success'] = true;
            $response['user'] = $user;
            $response['role'] = $user->getRoleNames();

            session()->put('user', $response['user']);
            session()->put('token', $response['token']);
            session()->put('role', $response['role']);

        } else {
            $response['error'] = 'Invalid credentials';
        }
        return response()->json($response, 200);
    }

    public function logout(){
        session()->forget('user');
        session()->forget('token');
        session()->forget('role');

        return redirect()->route('login');
    }

    public function profile(Request $request)
    {
        $usuario = User::getAuthenticatedUser();
        $rol_usuario = User::getRole();
        $direcciones = direcciones::where('usuario_id', $usuario->id)->first();
        $contactos = contactos_emergencia::where('paciente_id', $usuario->id)->first();
        $correos = correos_electronicos::where('usuario_id', $usuario->id)->first();
        $numeros_telefono = numeros_telefono::where('usuario_id', $usuario->id)->first();
        $paciente = pacientes::where('usuario_id', $usuario->id)->first();

        if($request->has('updateProfile')) {
            $request->merge(['nombre' => $this->sanitize($request->nombre)]);
            $request->merge(['apellido1' => $this->sanitize($request->apellido1)]);
            $request->merge(['apellido2' => $this->sanitize($request->apellido2)]);
            $request->merge(['change_password' => $this->sanitize($request->change_password)]);
            $request->merge(['role' => $request->role]);
            $request->merge(['gender' => $request->gender]);
            $request->merge(['foto' => $request->foto]);
            $request->merge(['numero_telefono' => trim(str_replace(' ', '', $this->sanitize($request->numero_telefono)))]);
            $request->merge(['correo_electronico' => $this->sanitize($request->correo_electronico)]);
            $request->merge(['ciudad' => $this->sanitize($request->ciudad)]);
            $request->merge(['codigo_postal' => trim(str_replace(' ', '', $this->sanitize($request->codigo_postal)))]);
            $request->merge(['calle' => $this->sanitize($request->calle)]);
            $request->merge(['piso' => $this->sanitize($request->piso)]);
            $request->merge(['numero' => $this->sanitize($request->numero)]);
            $request->merge(['peso' => $this->sanitize($request->peso)]);
            $request->merge(['altura' => $this->sanitize($request->altura)]);
            $request->merge(['grupo_sanguineo' => $request->grupo_sanguineo]);
            $request->merge(['contacto_nombre' => $this->sanitize($request->contacto_nombre)]);
            $request->merge(['contacto_numero' => trim(str_replace(' ', '', $this->sanitize($request->contacto_numero)))]);
            $request->merge(['contacto_correo' => $this->sanitize($request->contacto_correo)]);

            $request->validate([
                'nombre' => 'required|string|not_regex:/[0-9]/|max:255',
                'apellido1' => 'required|string|not_regex:/[0-9]/|max:255',
                'apellido2' => 'required|string|not_regex:/[0-9]/|max:255',
                'change_password' => 'nullable|string|max:255',
                'role' => 'required|string|in:Paciente,Administrador,Recepcionista,Medico',
                'gender' => 'required|string|in:Mujer,Hombre',
                'foto' => 'nullable|file|mimes:jpeg,png,jpg,webp|max:2048',
                'numero_telefono' => 'required|numeric|digits:9',
                'correo_electronico' => 'required|string|max:255',
                'ciudad' => 'nullable|string|not_regex:/[0-9]/|max:255',
                'codigo_postal' => 'nullable|numeric|digits:5',
                'calle' => 'nullable|string|max:255',
                'piso' => 'nullable|string|max:255',
                'numero' => 'nullable|string|max:255',
                'peso' => 'nullable|numeric|min:0|max:600',
                'altura' => 'nullable|numeric|min:0|max:3',
                'grupo_sanguineo' => 'nullable|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
                'contacto_nombre' => 'nullable|string|not_regex:/[0-9]/|max:255',
                'contacto_numero' => 'nullable|numeric|digits:9',
                'contacto_correo' => 'nullable|string|max:255'
            ], [
                'nombre.required' => 'El nombre es obligatorio.',
                'nombre.string' => 'El nombre debe ser una cadena de caracteres.',
                'nombre.not_regex' => 'El nombre no puede contener números.',
                'nombre.max' => 'El nombre no debe exceder los 255 caracteres.',
                'apellido1.required' => 'El primer apellido es obligatorio.',
                'apellido1.string' => 'El primer apellido debe ser una cadena de caracteres.',
                'apellido1.not_regex' => 'El primer apellido no puede contener números.',
                'apellido1.max' => 'El primer apellido no debe exceder los 255 caracteres.',
                'apellido2.required' => 'El segundo apellido es obligatorio.',
                'apellido2.string' => 'El segundo apellido debe ser una cadena de caracteres.',
                'apellido2.not_regex' => 'El segundo apellido no puede contener números.',
                'apellido2.max' => 'El segundo apellido no debe exceder los 255 caracteres.',
                'change_password.string' => 'El campo de cambio de contraseña debe ser una cadena de caracteres.',
                'change_password.max' => 'La contraseña no debe exceder los 255 caracteres.',
                'role.required' => 'El rol es obligatorio.',
                'role.string' => 'El rol debe ser una cadena de caracteres.',
                'role.in' => 'El rol seleccionado no es válido.',
                'gender.required' => 'El género es obligatorio.',
                'gender.string' => 'El género debe ser una cadena de caracteres.',
                'gender.in' => 'El género seleccionado no es válido.',
                'foto.file' => 'La foto debe ser un archivo.',
                'foto.mimes' => 'La foto debe ser de tipo jpeg, png, jpg, o webp.',
                'foto.max' => 'La foto no debe exceder los 2MB.',
                'numero_telefono.required' => 'El número de teléfono es obligatorio.',
                'numero_telefono.numeric' => 'El número de teléfono debe ser numérico.',
                'numero_telefono.digits' => 'El número de teléfono debe tener 9 dígitos.',
                'correo_electronico.required' => 'El correo electrónico es obligatorio.',
                'correo_electronico.string' => 'El correo electrónico debe ser una cadena de caracteres.',
                'correo_electronico.max' => 'El correo electrónico no debe exceder los 255 caracteres.',
                'ciudad.string' => 'La ciudad debe ser una cadena de caracteres.',
                'ciudad.not_regex' => 'La ciudad no puede contener números.',
                'ciudad.max' => 'La ciudad no debe exceder los 255 caracteres.',
                'codigo_postal.numeric' => 'El código postal debe ser numérico.',
                'codigo_postal.digits' => 'El código postal debe tener 5 dígitos.',
                'calle.string' => 'La calle debe ser una cadena de caracteres.',
                'calle.max' => 'La calle no debe exceder los 255 caracteres.',
                'piso.string' => 'El piso debe ser una cadena de caracteres.',
                'piso.max' => 'El piso no debe exceder los 255 caracteres.',
                'numero.string' => 'El número debe ser una cadena de caracteres.',
                'numero.max' => 'El número no debe exceder los 255 caracteres.',
                'peso.numeric' => 'El peso debe ser un valor numérico.',
                'peso.min' => 'El peso mínimo permitido es 0.',
                'peso.max' => 'El peso máximo permitido es 600.',
                'altura.numeric' => 'La altura debe ser un valor numérico.',
                'altura.min' => 'La altura mínima permitida es 0.',
                'altura.max' => 'La altura máxima permitida es 3.',
                'grupo_sanguineo.string' => 'El grupo sanguíneo debe ser una cadena de caracteres.',
                'grupo_sanguineo.in' => 'El grupo sanguíneo seleccionado no es válido.',
                'contacto_nombre.string' => 'El nombre del contacto debe ser una cadena de caracteres.',
                'contacto_nombre.not_regex' => 'El nombre del contacto no puede contener números.',
                'contacto_nombre.max' => 'El nombre del contacto no debe exceder los 255 caracteres.',
                'contacto_numero.numeric' => 'El número de teléfono del contacto debe ser numérico.',
                'contacto_numero.digits' => 'El número de teléfono del contacto debe tener 9 dígitos.',
                'contacto_correo.string' => 'El correo electrónico del contacto debe ser una cadena de caracteres.',
                'contacto_correo.max' => 'El correo electrónico del contacto no debe exceder los 255 caracteres.'
            ]);

            $usuario->nombre = $request->nombre;
            $usuario->apellido1 = $request->apellido1;
            $usuario->apellido2 = $request->apellido2;
            if($request->filled('change_password')) $usuario->password = Hash::make($request->change_password);
            $usuario->sexo = $request->gender;

            // Guardar la imagen en el servidor si se ha enviado
            if ($request->hasFile('foto')) {
                $imagen = $request->foto;
                
                // Eliminar la imagen existente si hay una
                if ($usuario->foto) {
                    Storage::delete($usuario->foto);
                }
            
                // Obtener el tipo de contenido de la imagen
                $tipoContenido = $imagen->getMimeType();
            
                // Convertir la imagen a base64 con el formato de URI de datos
                $imagenBase64 = 'data:' . $tipoContenido . ';base64,' . base64_encode(file_get_contents($imagen->getRealPath()));
            
                // Guardar la imagen base64 en el campo 'foto' de la tabla de usuarios
                $usuario->foto = $imagenBase64;
            }

            $usuario->save();

            // Actualizar telefono
            $numeros_telefono->numero_telefono = $request->numero_telefono;
            $numeros_telefono->save();

            // Actualizar correo
            $correos->correo_electronico = $request->correo_electronico;
            $correos->save();

            // Actualizar direcciones 
            if ($request->filled('ciudad')) $direcciones->ciudad = $request->ciudad;
            if ($request->filled('calle')) $direcciones->calle = $request->calle;
            if ($request->filled('numero')) $direcciones->numero = $request->numero;
            if ($request->filled('piso')) $direcciones->piso = $request->piso;
            if ($request->filled('codigo_postal')) $direcciones->codigo_postal = $request->codigo_postal;

            $direcciones->save();

            if($request->role != User::getRole()) {
                // Obtener rol
                $rol = Role::where('name', $request->role)->first();

                if ($rol) {
                    // Desasignar todos los roles actuales del usuario
                    $usuario->roles()->detach();
                    // Asignar el nuevo rol al usuario con el modelo_type correcto
                    $usuario->roles()->attach($rol, ['model_type' => User::class]);
                }

                if($request->role === 'Paciente') {
                    // Eliminar el registro de empleado si existe
                    Empleados::where('usuario_id', $usuario->id)->delete();

                    $paciente = pacientes::create([
                        'usuario_id' => $usuario->id,
                        'peso' => null,
                        'altura' => null,
                        'grupo_sanguineo' => null
                    ]);

                    $contactos = contactos_emergencia::create([
                        'paciente_id' => $usuario->id,
                        'nombre' => null,
                        'numero_telefono' => null,
                        'correo_electronico' => null
                    ]);
                }else {
                    // Eliminar el registro de paciente si existe
                    pacientes::where('usuario_id', $usuario->id)->delete();
                    contactos_emergencia::where('paciente_id', $usuario->id)->delete();

                    $empleado = Empleados::where('usuario_id', $usuario->id)->first();

                    if(!$empleado) {
                        $medico = Empleados::create([
                            'usuario_id' => $usuario->id,
                            'planta' => null,
                            'sala' => null
                        ]);
                    }
                }
            }

            // Actualizar datos de los pacientes
            if(User::getRole() === 'Paciente') {
                // Actualizar paciente 
                if($request->filled('peso')) $paciente->peso = $request->peso;
                if($request->filled('altura')) $paciente->altura = $request->altura;
                if($request->filled('grupo_sanguineo')) $paciente->grupo_sanguineo = $request->grupo_sanguineo;

                $paciente->save();

                // Actualizar persona de contacto 
                if($request->filled('contacto_nombre')) $contactos->nombre = $request->contacto_nombre;
                if($request->filled('contacto_numero')) $contactos->numero_telefono = $request->contacto_numero;
                if($request->filled('contacto_correo')) $contactos->correo_electronico = $request->contacto_correo;

                $contactos->save();
            }

            return redirect()->route('profile');
        }

        return view('profile', [
            'usuario' => $usuario,
            'direcciones' => $direcciones,
            'contactos_emergencia' => $contactos,
            'correos_electronicos' => $correos,
            'numeros_telefono' => $numeros_telefono,
            'paciente' => $paciente,
            'rol_usuario' => $rol_usuario
        ]);
    }

    public function changePassword(Request $request) {
        $response = ["success" => false]; 
        $validate = Validator::make($request->all(),[
            'dni' => 'required|string|max:255',
            'password' => 'required|string',
        ]);
    
        if($validate->fails()) {
            $response = ["error" => $validate->errors()];
            return response()->json($response, 200);
        }
    
        $usuario = User::where('dni', $request->dni)->first();
        if ($usuario) {
            $usuario->password = Hash::make($request->password);
            $usuario->save();
            $response["success"] = true; // Actualizar la respuesta a éxito
        }
    
        return response()->json($response, 200);
    }
}
