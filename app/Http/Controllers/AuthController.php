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
        $response = ["success" =>false]; 
        $validate = Validator::make($request->all(),[
            'cip' => 'nullable|string|max:255',
            'nombre' => 'nullable|string|max:255',
            'primerApellido' => 'nullable|string|max:255',
            'secondApellido' => 'nullable|string|max:255',
            'fechaNacimiento' => 'nullable|date',
            'gender' => 'nullable|string|in:Mujer,Hombre',
            'codigoPostal' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:255',
            'numeroDocumento' => 'required|string|max:255',
            'password' => 'required|string',
        ]);

        if($validate->fails()) {
            $response = ["error" => $validate->errors()];
            return response()->json($response,200);
        }

        $usuario = User::create([
            'cip' => $request->cip,
            'dni' => $request->numeroDocumento,
            'nombre' => $request->nombre,
            'apellido1' => $request->primerApellido,
            'apellido2' => $request->secondApellido,
            'fecha_nacimiento' => $request->fechaNacimiento,
            'sexo' => $request->gender,
            'foto' => $request->perfil,
            'password' => Hash::make($request->password),
        ]);

        // Obtener el ID del usuario
        $usuario_id = $usuario->id;
        
        // asignar role
        if($request->role) {
            $role = Role::where('name', $request->role)->first();
            $usuario->roles()->detach();
            $usuario->roles()->attach($role, ['model_type' => User::class]);

            if($request->role == 'Medico'){
                $medico = Empleados::create([
                    'usuario_id' => $usuario_id,
                    'planta' => '1',
                    'sala' => '2'
                ]);
            } else {
                $paciente = pacientes::create([
                    'usuario_id' => $usuario_id,
                    'peso' => 60,
                    'altura' => 180,
                    'grupo_sanguineo' => 'A+'
                ]);
            }
        }

        $response["success"] = true;

        foreach ($request->telefonos as $telefono) {
            // Guardar teléfonos
            $numerosTelefono = numeros_telefono::create([
                'usuario_id' => $usuario_id,
                'numero_telefono' => $telefono['telefono'],
            ]);
        }

        // Guardar direcciones
        $direcciones = direcciones::create([
            'usuario_id' => $usuario_id,
            'ciudad' => $request->ciudad,
            'calle' => $request->calle,
            'numero' => $request->numero,
            'piso' => $request->piso,
            'codigo_postal' => $request->codigoPostal,
        ]);

        // Guardar correos electrónicos
        foreach ($request->correos as $correo) {
            $correos = correos_electronicos::create([
                'usuario_id' => $usuario_id,
                'correo_electronico' => $correo['correo'],
            ]);
        }

        // Guardar personas de contacto
        if($request->role == 'Paciente') {
            foreach ($request->personaContacto as $contacto) {
                $contacto_emergencia = contactos_emergencia::create([
                    'paciente_id' => $usuario_id,
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

        $usuario = $request->session()->get('user');
        // Obtener los datos del usuario desde la base de datos
        $usuarioFromDB = User::find($usuario->id);
        $request->session()->put('user', $usuarioFromDB);
        $usuario = $usuarioFromDB;
        

        $direcciones = direcciones::where('usuario_id', $usuario->id)->first();
        $contactos = contactos_emergencia::where('paciente_id', $usuario->id)->first();
        $correos = correos_electronicos::where('usuario_id', $usuario->id)->first();
        $numeros_telefono = numeros_telefono::where('usuario_id', $usuario->id)->first();
        $paciente = pacientes::where('usuario_id', $usuario->id)->first();

        if($request->has('updateProfile')) {
            // Validar los datos del formulario
            $request->validate([
                'nombre' => 'string|max:255',
                'apellido1' => 'string|max:255',
                'apellido2' => 'string|max:255',
                'fecha_nacimiento' => 'date',
                'gender' => 'string|in:Mujer,Hombre',
                'numero_telefono' => 'numeric',
                'correo_electronico' => 'string|max:255',
                'ciudad' => 'string|max:255',
                'calle' => 'string|max:255',
                'piso' => 'string|max:255',
                'numero' => 'numeric',
                'peso' => 'numeric',
                'codigo_postal' => 'numeric',
                'altura' => 'numeric',
                'grupo_sanguineo' => 'string|max:255',
                'role' => 'string|max:255',
                'contacto_nombre' => 'string|max:255',
                'contacto_numero' => 'numeric',
                'contacto_correo' => 'string|max:255',
            ]);
            
            // Actualizar usuario solo si el campo del formulario no está vacío
            if ($request->filled('nombre'))$usuario->nombre = $request->nombre;

            if ($request->filled('apellido1'))$usuario->apellido1 = $request->apellido1;
            if ($request->filled('apellido2'))$usuario->apellido2 = $request->apellido2;
            if ($request->filled('fecha_nacimiento'))$usuario->fecha_nacimiento = $request->fecha_nacimiento;
            if ($request->filled('gender'))$usuario->sexo = $request->gender;
            if ($request->filled('change_password'))$usuario->password = Hash::make($request->change_password);
            
            // Guardar la imagen en el servidor si se ha enviado
            if ($request->hasFile('foto')) {
                $imagen = $request->file('foto');
                
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
            
            if($request->role == 'Medico'){
                 // Eliminar el registro de paciente si existe
                pacientes::where('usuario_id', $usuario->id)->delete();

                $medico = Empleados::create([
                    'usuario_id' => $usuario->id,
                    'planta' => '1',
                    'sala' => '2'
                ]);
    
            } else if($request->role == 'Paciente') {
                // Eliminar el registro de empleado si existe
                Empleados::where('usuario_id', $usuario->id)->delete();

                $paciente = pacientes::create([
                    'usuario_id' => $usuario->id,
                    'peso' => 60,
                    'altura' => 180,
                    'grupo_sanguineo' => 'A+'
                ]);
            }

            // Obtener role
            $rol = Role::where('name', $request->role)->first();
            if ($rol) {
                // Desasignar todos los roles actuales del usuario
                $usuario->roles()->detach();
                // Asignar el nuevo rol al usuario con el modelo_type correcto
                $usuario->roles()->attach($rol, ['model_type' => User::class]);
            }

            $usuario->save();

            if($usuario->hasRole('Paciente')) {
                // Actualizar paciente 
                if ($request->filled('peso'))$paciente->peso = $request->peso;
                if ($request->filled('altura'))$paciente->altura = $request->altura;
                if ($request->filled('grupo_sanguineo'))$paciente->grupo_sanguineo = $request->grupo_sanguineo;
                $paciente->save();

                // Actualizar persona de contacto 
                if ($request->filled('contacto_nombre'))$contactos->nombre = $request->contacto_nombre;
                if ($request->filled('contacto_numero'))$contactos->numero_telefono = $request->contacto_numero;
                if ($request->filled('contacto_correo'))$contactos->correo_electronico = $request->contacto_correo;
                $contactos->save();
            }
            // Actualizar direcciones 
            if ($request->filled('ciudad')) $direcciones->ciudad = $request->ciudad;
            if ($request->filled('calle'))$direcciones->calle = $request->calle;
            if ($request->filled('numero'))$direcciones->numero = $request->numero;
            if ($request->filled('piso'))$direcciones->piso = $request->piso;
            if ($request->filled('codigo_postal'))$direcciones->codigo_postal = $request->codigo_postal;
            $direcciones->save();

            // Actualizar correo 
            if ($request->filled('correo_electronico'))$correos->correo_electronico = $request->correo_electronico;
            $correos->save();

            // actualizar telefono
            if ($request->filled('numero_telefono'))$numeros_telefono->numero_telefono = $request->numero_telefono;
            $numeros_telefono->save();

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
