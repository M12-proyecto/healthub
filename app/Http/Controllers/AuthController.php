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
            'cip' => 'required|string|max:255',
            'numeroDocumento' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'primerApellido' => 'required|string|max:255',
            'secondApellido' => 'required|string|max:255',
            'fechaCumpleanos' => 'required|date',
            'gender' => 'required|string|in:Mujer,Hombre',
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
        } else {
            $response['error'] = 'Invalid credentials';
        }
        return response()->json($response, 200);
    }

    public function logout(Request $request){
        $response = ["success" => false];
        $user = User::where('dni', $request->dni)->first();
        $user->currentAccessTocken()->delete();
        $response =["success" => true,"message" => "Sessión cerrada"];
        return response()->json($response, 200);
    }
}
