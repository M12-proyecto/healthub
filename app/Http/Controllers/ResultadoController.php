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
        $resultados = User::getResultados();

        if($resultados) {
            foreach ($resultados as $resultado) {
                $resultado->fecha = Resultado::formatDate($resultado->fecha);
            }
        }
        
        return view('resultados/resultado')->with([
            'resultadoModel'=> Resultado::class,
            'resultados' => $resultados
        ]);
    }

    public function create(Request $request) {
        $this->authorize('create', Resultado::class);
        
        if($request->has('crearResultadoForm')) {
            $datosValidados = $request->validate([
                'paciente_id' => 'required|exists:usuarios,id',
                'medico_id' => 'required|exists:usuarios,id',
                'centro' => 'required|string|max:45',
                'fecha' => 'required|date_format:Y-m-d',
                'prueba' => 'required|string|max:45',
                'resultado' => 'required|string|max:45',
                'unidades' => '',
                'valores_normalidad' => '',
                'observaciones' => '',
            ], [
                'paciente_id.required' => 'El campo paciente es obligatorio.',
                'paciente_id.exists' => 'El paciente seleccionado no existe.',
                'medico_id.required' => 'El campo médico es obligatorio.',
                'medico_id.exists' => 'El médico seleccionado no existe.',
                'centro.required' => 'El campo centro es obligatorio.',
                'centro.string' => 'El campo centro debe ser una cadena de texto.',
                'centro.max' => 'El campo centro no debe superar los :max caracteres.',
                'fecha.required' => 'El campo fecha es obligatorio.',
                'fecha.date_format' => 'El campo fecha debe estar en formato DD-MM-YYYY.',
                'prueba.required' => 'El campo prueba es obligatorio.',
                'prueba.string' => 'El campo prueba debe ser una cadena de texto.',
                'prueba.max' => 'El campo prueba no debe superar los :max caracteres.',
                'resultado.required' => 'El campo resultado es obligatorio.',
                'resultado.string' => 'El campo resultado debe ser una cadena de texto.',
                'resultado.max' => 'El campo resultado no debe superar los :max caracteres.'
            ]);

            $resultado = new Resultado();
            $resultado->paciente_id = $datosValidados['paciente_id'];
            $resultado->medico_id = $datosValidados['medico_id'];
            $resultado->centro = $datosValidados['centro'];
            $resultado->fecha = $datosValidados['fecha'];
            $resultado->prueba = $datosValidados['prueba'];
            $resultado->resultado = $datosValidados['resultado'];

            if($datosValidados["unidades"]) {
                $datosValidados["unidades"] = $this->sanitize($datosValidados["unidades"]);
                $resultado->unidades = $datosValidados['unidades'];
            }

            if($datosValidados["valores_normalidad"]) {
                $datosValidados["valores_normalidad"] = $this->sanitize($datosValidados["valores_normalidad"]);
                $resultado->valores_normalidad = $datosValidados['valores_normalidad'];
            }

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

    /**
     * Display the specified resource.
     */
    public function read(Resultado $resultado)
    {
        $resultadoModel = Resultado::class;
        
        if($resultado) {
            $resultado->paciente->fecha_nacimiento = Resultado::formatDate($resultado->paciente->fecha_nacimiento);
            $resultado->fecha = Resultado::formatDate($resultado->fecha);
        }

        return view('resultados/verResultado')->with([
            'resultado' => $resultado,
            'resultadoModel' => $resultadoModel
        ]);
    }

    public function update(Request $request, Resultado $resultado = new Resultado) {
        $this->authorize('update', Resultado::class);
        
        if($request->has('editarResultadoForm')) {
            $datosValidados = $request->validate([
                'paciente_id' => 'required|exists:usuarios,id',
                'medico_id' => 'required|exists:usuarios,id',
                'centro' => 'required|string|max:45',
                'fecha' => 'required|date_format:Y-m-d',
                'prueba' => 'required|string|max:45',
                'resultado' => 'required|string|max:45',
                'unidades' => '',
                'valores_normalidad' => '',
                'observaciones' => '',
            ], [
                'paciente_id.required' => 'El campo paciente es obligatorio.',
                'paciente_id.exists' => 'El paciente seleccionado no existe.',
                'medico_id.required' => 'El campo médico es obligatorio.',
                'medico_id.exists' => 'El médico seleccionado no existe.',
                'centro.required' => 'El campo centro es obligatorio.',
                'centro.string' => 'El campo centro debe ser una cadena de texto.',
                'centro.max' => 'El campo centro no debe superar los :max caracteres.',
                'fecha.required' => 'El campo fecha es obligatorio.',
                'fecha.date_format' => 'El campo fecha debe estar en formato DD-MM-YYYY.',
                'prueba.required' => 'El campo prueba es obligatorio.',
                'prueba.string' => 'El campo prueba debe ser una cadena de texto.',
                'prueba.max' => 'El campo prueba no debe superar los :max caracteres.',
                'resultado.required' => 'El campo resultado es obligatorio.',
                'resultado.string' => 'El campo resultado debe ser una cadena de texto.',
                'resultado.max' => 'El campo resultado no debe superar los :max caracteres.'
            ]);

            $resultado->paciente_id = $datosValidados['paciente_id'];
            $resultado->medico_id = $datosValidados['medico_id'];
            $resultado->centro = $datosValidados['centro'];
            $resultado->fecha = $datosValidados['fecha'];
            $resultado->prueba = $datosValidados['prueba'];
            $resultado->resultado = $datosValidados['resultado'];

            if($datosValidados["unidades"]) {
                $datosValidados["unidades"] = $this->sanitize($datosValidados["unidades"]);
                $resultado->unidades = $datosValidados['unidades'];
            }

            if($datosValidados["valores_normalidad"]) {
                $datosValidados["valores_normalidad"] = $this->sanitize($datosValidados["valores_normalidad"]);
                $resultado->valores_normalidad = $datosValidados['valores_normalidad'];
            }
            
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
