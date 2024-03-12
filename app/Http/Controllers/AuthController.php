<?php

namespace App\Http\Controllers;

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
            'fechaCumpleanos' => 'nullable|date',
            'email' => 'nullable|email',
            'gender' => 'nullable|string|in:Mujer,Hombre',
            'direccion' => 'nullable|string',
            'codigoPostal' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:255',
            'provincia' => 'nullable|string|max:255',
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
            'fecha_nacimiento' => $request->fechaCumpleanos,
            'sexo' => $request->gender,
            'password' => Hash::make($request->password),
        ]);
        $usuario->assignRole('paciente');
        $response["success"] = true;

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

            session()->put('token', $response["token"]);
            session()->put('user', $response['user']);
            session()->put('role', $response['role']);
        } else {
            $response['error'] = 'Invalid credentials';
        }
        return response()->json($response, 200);
    }

    public function logout(Request $request){
        $response =["success" => true,"message" => "Sessión cerrada"];

        session()->forget('token');
        session()->forget('user');
        session()->forget('role');

        return redirect()->route('login');
    }
}
