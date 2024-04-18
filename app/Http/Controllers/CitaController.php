<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cita;
use App\Models\Role;

class CitaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show()
    {
        return view('citas/citas');
    }

    public function create(Request $request) {
        $this->authorize('create', Cita::class);

        if($request->has('crearCitaForm')) {
            $datosValidados = $request->validate([
                'paciente_id' => 'required|exists:usuarios,id',
                'medico_id' => 'required|exists:usuarios,id',
                'asunto' => 'required|string|max:45',
                'fecha' => 'required|date',
                'hora' => 'required|date_format:H:i',
                'ubicacion' => 'required|string|max:45',
                'notas' => '',
            ], [
                'paciente_id.required' => 'El campo paciente es obligatorio',
                'medico_id.required' => 'El campo medico es obligatorio',
                'paciente_id.exists' => 'El paciente seleccionado no existe',
                'medico_id.exists' => 'El medico seleccionado no existe',
                'asunto.required' => 'El campo asunto es obligatorio',
                'fecha.required' => 'El campo fecha es obligatorio',
                'hora.required' => 'El campo hora es obligatorio',
                'ubicacion.required' => 'El campo ubicacion es obligatorio',
            ]);

            $cita = new Cita();
            $cita->paciente_id = $datosValidados['paciente_id'];
            $cita->medico_id = $datosValidados['medico_id'];
            $cita->asunto = $datosValidados['asunto'];
            $cita->fecha = $datosValidados['fecha'];
            $cita->hora = $datosValidados['hora'];
            $cita->ubicacion = $datosValidados['ubicacion'];

            if($datosValidados["notas"]) {
                $datosValidados["notas"] = $this->sanitize($datosValidados["notas"]);
                $cita->notas = $datosValidados['notas'];
            }
            
            $cita->save();
            
            return redirect()->route("citas");
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

            return view('citas/crearCita')->with([
                "pacientes" => $pacientes,
                "medicos" => $medicos
            ]);
        }
    }

    public function update(Request $request, Cita $cita = new Cita()) {
        $this->authorize('update', Cita::class);

        if($request->has('editarCitaForm')) {
            $request["hora"] = substr($request["hora"], 0, 5);

            $datosValidados = $request->validate([
                'paciente_id' => 'required|exists:usuarios,id',
                'medico_id' => 'required|exists:usuarios,id',
                'asunto' => 'required|string|max:45',
                'fecha' => 'required|date',
                'hora' => 'required|date_format:H:i',
                'ubicacion' => 'required|string|max:45',
                'notas' => '',
            ], [
                'paciente_id.required' => 'El campo paciente es obligatorio',
                'medico_id.required' => 'El campo medico es obligatorio',
                'paciente_id.exists' => 'El paciente seleccionado no existe',
                'medico_id.exists' => 'El medico seleccionado no existe',
                'asunto.required' => 'El campo asunto es obligatorio',
                'fecha.required' => 'El campo fecha es obligatorio',
                'hora.required' => 'El campo hora es obligatorio',
                'ubicacion.required' => 'El campo ubicacion es obligatorio',
            ]);
            
            $cita->paciente_id = $datosValidados['paciente_id'];
            $cita->medico_id = $datosValidados['medico_id'];
            $cita->asunto = $datosValidados['asunto'];
            $cita->fecha = $datosValidados['fecha'];
            $cita->hora = $datosValidados['hora'];
            $cita->ubicacion = $datosValidados['ubicacion'];

            if($datosValidados["notas"]) {
                $datosValidados["notas"] = $this->sanitize($datosValidados["notas"]);
                $cita->notas = $datosValidados['notas'];
            }
            
            $cita->save();
            
            return redirect()->route("citas");
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

            return view('citas/editarCita')->with([
                "cita" => $cita,
                "pacientes" => $pacientes,
                "medicos" => $medicos
            ]);
        }
    }

    public function delete(Request $request, Cita $cita = new Cita()) {
        $this->authorize('delete', Cita::class);

        if($request->has('eliminarCitaForm')) {
            $cita->delete();
            return redirect()->route("citas");
        }else {
            return redirect()->route("citas");
        }
    }
}
