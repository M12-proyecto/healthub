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
    
        $validate = Validator::make($request->all(), [
            'dni' => 'required|string',
            'password' => 'required|string',
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
        $direcciones = direcciones::where('usuario_id', $usuario->id)->first();
        $contactos = contactos_emergencia::where('paciente_id', $usuario->id)->first();
        $correos = correos_electronicos::where('usuario_id', $usuario->id)->first();
        $numeros_telefono = numeros_telefono::where('usuario_id', $usuario->id)->first();
        $paciente = pacientes::where('usuario_id', $usuario->id)->first();

        if($request->has('updateProfile')) {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'apellido1' => 'required|string|max:255',
                'apellido2' => 'required|string|max:255',
                'change_password' => 'nullable|string|max:255',
                'role' => 'required|string|in:Paciente,Administrador,Recepcionista,Medico',
                'gender' => 'required|string|in:Mujer,Hombre',
                'foto' => 'nullable|file|mimes:jpeg,png,jpg,webp|max:2048',
                'numero_telefono' => 'required|numeric',
                'correo_electronico' => 'required|string|max:255',
                'ciudad' => 'nullable|string|max:255',
                'codigo_postal' => 'nullable|numeric',
                'calle' => 'nullable|string|max:255',
                'piso' => 'nullable|string|max:255',
                'numero' => 'nullable|numeric',
                'peso' => 'nullable|numeric',
                'altura' => 'nullable|numeric',
                'grupo_sanguineo' => 'nullable|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
                'contacto_nombre' => 'nullable|string|max:255',
                'contacto_numero' => 'nullable|numeric',
                'contacto_correo' => 'nullable|string|max:255'
            ], [
                'nombre.required' => 'El campo nombre es obligatorio.',
                'nombre.string' => 'El campo nombre debe ser una cadena de texto.',
                'nombre.max' => 'El campo nombre no debe exceder de 255 caracteres.',
                'apellido1.required' => 'El campo primer apellido es obligatorio.',
                'apellido1.string' => 'El campo primer apellido debe ser una cadena de texto.',
                'apellido1.max' => 'El campo primer apellido no debe exceder de 255 caracteres.',
                'apellido2.required' => 'El campo segundo apellido es obligatorio.',
                'apellido2.string' => 'El campo segundo apellido debe ser una cadena de texto.',
                'apellido2.max' => 'El campo segundo apellido no debe exceder de 255 caracteres.',
                'change_password.string' => 'El campo cambiar contraseña debe ser una cadena de texto.',
                'change_password.max' => 'El campo cambiar contraseña no debe exceder de 255 caracteres.',
                'role.required' => 'El campo rol es obligatorio.',
                'role.string' => 'El campo rol debe ser una cadena de texto.',
                'role.in' => 'El campo rol debe ser uno de los siguientes valores: Paciente, Administrador, Recepcionista, Medico.',
                'gender.required' => 'El campo género es obligatorio.',
                'gender.string' => 'El campo género debe ser una cadena de texto.',
                'gender.in' => 'El campo género debe ser uno de los siguientes valores: Mujer, Hombre.',
                'foto.file' => 'El campo foto debe ser un archivo.',
                'foto.mimes' => 'El campo foto debe ser un archivo de tipo: jpeg, png, jpg, webp.',
                'foto.max' => 'El campo foto no debe exceder de 2048 kilobytes.',
                'numero_telefono.required' => 'El campo número de teléfono es obligatorio.',
                'numero_telefono.numeric' => 'El campo número de teléfono debe ser numérico.',
                'correo_electronico.required' => 'El campo correo electrónico es obligatorio.',
                'correo_electronico.string' => 'El campo correo electrónico debe ser una cadena de texto.',
                'correo_electronico.max' => 'El campo correo electrónico no debe exceder de 255 caracteres.',
                'ciudad.string' => 'El campo ciudad debe ser una cadena de texto.',
                'ciudad.max' => 'El campo ciudad no debe exceder de 255 caracteres.',
                'codigo_postal.numeric' => 'El campo código postal debe ser numérico.',
                'calle.string' => 'El campo calle debe ser una cadena de texto.',
                'calle.max' => 'El campo calle no debe exceder de 255 caracteres.',
                'piso.string' => 'El campo piso debe ser una cadena de texto.',
                'piso.max' => 'El campo piso no debe exceder de 255 caracteres.',
                'numero.numeric' => 'El campo número debe ser numérico.',
                'peso.numeric' => 'El campo peso debe ser numérico.',
                'altura.numeric' => 'El campo altura debe ser numérico.',
                'grupo_sanguineo.string' => 'El campo grupo sanguíneo debe ser una cadena de texto.',
                'grupo_sanguineo.in' => 'El campo grupo sanguíneo debe ser uno de los siguientes valores: A+, A-, B+, B-, AB+, AB-, O+, O-.',
                'contacto_nombre.string' => 'El campo nombre del contacto debe ser una cadena de texto.',
                'contacto_nombre.max' => 'El campo nombre del contacto no debe exceder de 255 caracteres.',
                'contacto_numero.numeric' => 'El campo número del contacto debe ser numérico.',
                'contacto_correo.string' => 'El campo correo del contacto debe ser una cadena de texto.',
                'contacto_correo.max' => 'El campo correo del contacto no debe exceder de 255 caracteres.',
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
                }else {
                    // Eliminar el registro de paciente si existe
                    pacientes::where('usuario_id', $usuario->id)->delete();

                    $medico = Empleados::create([
                        'usuario_id' => $usuario->id,
                        'planta' => null,
                        'sala' => null
                    ]);
                }
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
