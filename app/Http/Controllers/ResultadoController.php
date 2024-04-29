<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Resultado;

class ResultadoController extends Controller
{
    // controlador de lo resutados de los pacientes
    public function __construct(){}

    public function show(){
        $usuario = User::getAuthenticatedUser();
        $userRole = User::getRole();

        if($userRole === 'Medico') {
            $resultados = Resultado::where('medico_id', $usuario->id)->get();
        }else if($userRole === 'Paciente') {
            $resultados = Resultado::where('paciente_id', $usuario->id)->get();
        }else {
            $resultados = Resultado::orderBy('fecha')->get();
        }

        return view('resultados/resultado')->with(['resultadoModel'=> Resultado::class, 'resultados' => $resultados]);
    }

    public function create(Request $request) {
        $this->authorize('create', Resultado::class);
        
        if($request->has('crearResuladoForm')) {
            $datosValidados = $request->validate([
                'paciente_id' => 'required|exists:usuarios,id',
                'medico_id' => 'required|exists:usuarios,id',
                'centro' => 'required|string|max:45',
                'fecha' => 'required|date',
                'prueba' => 'required|string|max:45',
                'resultado' => 'required|string|max:45',
                'observaciones' => '',
            ], [
                'paciente_id.required' => 'El campo paciente es obligatorio',
                'medico_id.required' => 'El campo medico es obligatorio',
                'paciente_id.exists' => 'El paciente seleccionado no existe',
                'medico_id.exists' => 'El medico seleccionado no existe',
                'centro.required' => 'El campo centro es obligatorio',
                'fecha.required' => 'El campo fecha es obligatorio',
                'prueba.required' => 'El campo prueba es obligatorio',
                'resultado.required' => 'El campo resultado es obligatorio',
            ]);

            $resultado = new Resultado();
            $resultado->paciente_id = $datosValidados['paciente_id'];
            $resultado->medico_id = $datosValidados['medico_id'];
            $resultado->centro = $datosValidados['centro'];
            $resultado->fecha = $datosValidados['fecha'];
            $resultado->prueba = $datosValidados['prueba'];
            $resultado->resultado = $datosValidados['resultado'];
            $resultado->unidades = $request->unidades;
            $resultado->valores_normalidad = $request->valores_normalidad;

            if($datosValidados["observaciones"]) {
                $datosValidados["observaciones"] = $this->sanitize($datosValidados["observaciones"]);
                $resultado->observaciones = $datosValidados['observaciones'];
            }
            
            $resultado->save();
            
            return redirect()->route("resultados");
        }else {
            $pacientes = User::whereHas('roles', function ($query) {
                $query->where('name', 'Paciente');
            })
            ->orderBy('nombre')
            ->get();

            $medicos = User::whereHas('roles', function ($query) {
                $query->where('name', 'Medico');
            })
            ->orderBy('nombre')
            ->get();

            return view('resultados/crearResultado')->with([
                "pacientes" => $pacientes,
                "medicos" => $medicos
            ]);
        }
    }

    public function update(Request $request, Resultado $resultado = new Resultado) {
        $this->authorize('update', Resultado::class);
        if($request->has('editarResultadoForm')) {
            $datosValidados = $request->validate([
                'paciente_id' => 'required|exists:usuarios,id',
                'medico_id' => 'required|exists:usuarios,id',
                'centro' => 'required|string|max:45',
                'fecha' => 'required|date',
                'prueba' => 'required|string|max:45',
                'resultado' => 'required|string|max:45',
                'observaciones' => '',
            ], [
                'paciente_id.required' => 'El campo paciente es obligatorio',
                'medico_id.required' => 'El campo medico es obligatorio',
                'paciente_id.exists' => 'El paciente seleccionado no existe',
                'medico_id.exists' => 'El medico seleccionado no existe',
                'centro.required' => 'El campo centro es obligatorio',
                'fecha.required' => 'El campo fecha es obligatorio',
                'prueba.required' => 'El campo prueba es obligatorio',
                'resultado.required' => 'El campo resultado es obligatorio',
            ]);

            $resultado->paciente_id = $datosValidados['paciente_id'];
            $resultado->medico_id = $datosValidados['medico_id'];
            $resultado->centro = $datosValidados['centro'];
            $resultado->fecha = $datosValidados['fecha'];
            $resultado->prueba = $datosValidados['prueba'];
            $resultado->resultado = $datosValidados['resultado'];
            $resultado->unidades = $request->unidades;
            $resultado->valores_normalidad = $request->valores_normalidad;
            
            if($datosValidados["observaciones"]) {
                $datosValidados["observaciones"] = $this->sanitize($datosValidados["observaciones"]);
                $resultado->observaciones = $datosValidados['observaciones'];
            }

            $resultado->save();

            return redirect()->route('resultados');

        }else {
            $pacientes = User::whereHas('roles', function ($query) {
                $query->where('name', 'Paciente');
            })
            ->orderBy('nombre')
            ->get();

            $medicos = User::whereHas('roles', function ($query) {
                $query->where('name', 'Medico');
            })
            ->orderBy('nombre')
            ->get();

            return view('resultados/editarResultado')->with([
                "resultado" => $resultado,
                "pacientes" => $pacientes,
                "medicos" => $medicos
            ]);
        }
    }

    public function delete(Request $request, Resultado $resultado = new Resultado()) {
        $this->authorize('delete', Resultado::class);
        
        if($request->has('eliminarResultadoForm')) {
            $resultado->delete();
            return redirect()->route("resultados");
        }else {
            return redirect()->route("resultados");
        }
    }
}
