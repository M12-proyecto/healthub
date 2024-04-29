<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Informe;
use Illuminate\Http\Request;

class InformeController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function show()
    {
        $informes = User::getInformes();

        if($informes) {
            foreach ($informes as $informe) {
                $informe->created_at = Informe::formatTimestamp($informe->created_at);
            }
        }

        return view('informes/informes')->with(["informes" => $informes]);
    }

    /**
     * Show the form for creating a new resource and store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        // $this->authorize('create', Informe::class);

        if($request->has('crearInformeForm')) {
            $datosValidados = $request->validate([
                'paciente_id' => 'required|exists:usuarios,id',
                'medico_id' => 'required|exists:usuarios,id',
                'centro' => 'required|string|max:45',
                'especialidad' => 'required|string|max:45',
                'motivo_consulta' => 'required|string|max:455',
                'enfermedad_actual' => 'required|string|max:455',
                'diagnostico' => 'required|string|max:455',
                'procedimiento' => 'required|string|max:455',
                'tratamiento' => 'required|string|max:455',
            ], [
                'paciente_id.required' => 'El campo paciente es obligatorio',
                'medico_id.required' => 'El campo medico es obligatorio',
                'paciente_id.exists' => 'El paciente seleccionado no existe',
                'medico_id.exists' => 'El medico seleccionado no existe',
                'centro.required' => 'El campo centro es obligatorio',
                'especialidad.required' => 'El campo especialidad es obligatorio',
                'motivo_consulta.required' => 'El campo motivo de consulta es obligatorio',
                'enfermedad_actual.required' => 'El campo enfermedad actual es obligatorio',
                'diagnostico.required' => 'El campo diagnostico es obligatorio',
                'procedimiento.required' => 'El campo procedimiento es obligatorio',
                'tratamiento.required' => 'El campo tratamiento es obligatorio'
            ]);

            $informe = new Informe();
            $informe->paciente_id = $datosValidados['paciente_id'];
            $informe->medico_id = $datosValidados['medico_id'];
            $informe->centro = $datosValidados['centro'];
            $informe->especialidad = $datosValidados['especialidad'];
            $informe->motivo_consulta = $datosValidados['motivo_consulta'];
            $informe->enfermedad_actual = $datosValidados['enfermedad_actual'];
            $informe->diagnostico = $datosValidados['diagnostico'];
            $informe->procedimiento = $datosValidados['procedimiento'];
            $informe->tratamiento = $datosValidados['tratamiento'];
            
            $informe->save();
            
            return redirect()->route("informes");
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

            return view('informes/crearInforme')->with([
                "pacientes" => $pacientes,
                "medicos" => $medicos
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function read(Informe $informe)
    {
        if($informe) {
            $informe->paciente->fecha_nacimiento = Informe::formatDate($informe->paciente->fecha_nacimiento);
            $informe->created_at = Informe::formatTimestamp($informe->created_at);
        }

        return view('informes/verInforme')->with(['informe' => $informe]);
    }

    /**
     * Show the form for editing the specified resource and update the specified resource in storage.
     */
    public function update(Request $request, Informe $informe = new Informe())
    {
        // $this->authorize('create', Informe::class);

        if($request->has('editarInformeForm')) {
            $datosValidados = $request->validate([
                'paciente_id' => 'required|exists:usuarios,id',
                'medico_id' => 'required|exists:usuarios,id',
                'centro' => 'required|string|max:45',
                'especialidad' => 'required|string|max:45',
                'motivo_consulta' => 'required|string|max:455',
                'enfermedad_actual' => 'required|string|max:455',
                'diagnostico' => 'required|string|max:455',
                'procedimiento' => 'required|string|max:455',
                'tratamiento' => 'required|string|max:455',
            ], [
                'paciente_id.required' => 'El campo paciente es obligatorio',
                'medico_id.required' => 'El campo medico es obligatorio',
                'paciente_id.exists' => 'El paciente seleccionado no existe',
                'medico_id.exists' => 'El medico seleccionado no existe',
                'centro.required' => 'El campo centro es obligatorio',
                'especialidad.required' => 'El campo especialidad es obligatorio',
                'motivo_consulta.required' => 'El campo motivo de consulta es obligatorio',
                'enfermedad_actual.required' => 'El campo enfermedad actual es obligatorio',
                'diagnostico.required' => 'El campo diagnostico es obligatorio',
                'procedimiento.required' => 'El campo procedimiento es obligatorio',
                'tratamiento.required' => 'El campo tratamiento es obligatorio'
            ]);

            $informe->paciente_id = $datosValidados['paciente_id'];
            $informe->medico_id = $datosValidados['medico_id'];
            $informe->centro = $datosValidados['centro'];
            $informe->especialidad = $datosValidados['especialidad'];
            $informe->motivo_consulta = $datosValidados['motivo_consulta'];
            $informe->enfermedad_actual = $datosValidados['enfermedad_actual'];
            $informe->diagnostico = $datosValidados['diagnostico'];
            $informe->procedimiento = $datosValidados['procedimiento'];
            $informe->tratamiento = $datosValidados['tratamiento'];
            
            $informe->save();
            
            return redirect()->route("informes");
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

            return view('informes/editarInforme')->with([
                "informe" => $informe,
                "pacientes" => $pacientes,
                "medicos" => $medicos
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request, Informe $informe = new Informe())
    {
        // $this->authorize('delete', Informe::class);

        if($request->has('eliminarInformeForm')) {
            $informe->delete();

            return redirect()->route("informes");
        }else {
            return redirect()->route("informes");
        }
    }
}
