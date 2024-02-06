<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
    
        $credentials = request(['email', 'password']);
    
        if (!Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        $user = $request->user();
        $token = $user->createToken('authToken')->accessToken;
    
        return response()->json(['token' => $token, 'user' => $user]);
    }
    
    

    public function register(Request $request)
    {
        $request->validate([
            'cip' => 'required|string|max:255',
            'numeroDocumento' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'primerApellido' => 'required|string|max:255',
            'secondApellido' => 'required|string|max:255',
            'fechaCumpleanos' => 'required|date',
            'gender' => 'required|string|in:Mujer,Hombre',
            'password' => 'required|string|min:1|confirmed:confirmPassword',
        ]);

        $usuario = new Usuario;
        $usuario->cip = $request->cip;
        $usuario->nombre = $request->nombre;
        $usuario->primer_apellido = $request->primerApellido;
        $usuario->second_apellido = $request->secondApellido;
        $usuario->fecha_cumpleanos = $request->fechaCumpleanos;
        $usuario->gender = $request->gender;
        $usuario->numero_documento = $request->numeroDocumento;
        $usuario->password = Hash::make($request->password);
        $usuario->rol = 'paciente';

        $usuario->save();

        $token = $usuario->createToken('authToken')->accessToken;

        return response()->json(['token' => $token, 'user' => $usuario]);
    }
}
