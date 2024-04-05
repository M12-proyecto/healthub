<?php

namespace App\Http\Controllers;

use App\Models\contactos_emergencia;
use App\Models\correos_electronicos;
use App\Models\direcciones;
use App\Models\numeros_telefono;
use App\Models\pacientes;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
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
            'email' => 'nullable|email',
            'gender' => 'nullable|string|in:Mujer,Hombre',
            'direccion' => 'nullable|string',
            'codigoPostal' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:255',
            'tipoDocumento' => 'nullable|string|in:DNI,NIE,Pasaporte',
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
        $usuario->assignRole('paciente');
        $response["success"] = true;
        // Obtener el ID del usuario
        $usuario_id = $usuario->id;

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

        $paciente = pacientes::create([
            'usuario_id' => $usuario_id,
            'peso' => 60,
            'altura' => 180,
            'grupo_sanguineo' => 'A+'
        ]);

        // Guardar personas de contacto
        foreach ($request->personaContacto as $contacto) {
            $contacto_emergencia = contactos_emergencia::create([
                'paciente_id' => $usuario_id,
                'nombre' => $contacto['nombreContacte'],
                'numero_telefono' => $contacto['telefono'],
                'correo_electronico' => $contacto['email'],
            ]);
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
}
