<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Informe;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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

        return view('informes/informes')->with([
            "informes" => $informes,
            "informeModel" => Informe::class
        ]);
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
                'paciente_id.required' => 'El campo paciente es obligatorio.',
                'paciente_id.exists' => 'El paciente seleccionado no existe.',
                'medico_id.required' => 'El campo médico es obligatorio.',
                'medico_id.exists' => 'El médico seleccionado no existe.',
                'centro.required' => 'El campo centro es obligatorio.',
                'centro.string' => 'El campo centro debe ser una cadena de texto.',
                'centro.max' => 'El campo centro no debe superar los :max caracteres.',
                'especialidad.required' => 'El campo especialidad es obligatorio.',
                'especialidad.string' => 'El campo especialidad debe ser una cadena de texto.',
                'especialidad.max' => 'El campo especialidad no debe superar los :max caracteres.',
                'motivo_consulta.required' => 'El campo motivo de consulta es obligatorio.',
                'motivo_consulta.string' => 'El campo motivo de consulta debe ser una cadena de texto.',
                'motivo_consulta.max' => 'El campo motivo de consulta no debe superar los :max caracteres.',
                'enfermedad_actual.required' => 'El campo enfermedad actual es obligatorio.',
                'enfermedad_actual.string' => 'El campo enfermedad actual debe ser una cadena de texto.',
                'enfermedad_actual.max' => 'El campo enfermedad actual no debe superar los :max caracteres.',
                'diagnostico.required' => 'El campo diagnóstico es obligatorio.',
                'diagnostico.string' => 'El campo diagnóstico debe ser una cadena de texto.',
                'diagnostico.max' => 'El campo diagnóstico no debe superar los :max caracteres.',
                'procedimiento.required' => 'El campo procedimiento es obligatorio.',
                'procedimiento.string' => 'El campo procedimiento debe ser una cadena de texto.',
                'procedimiento.max' => 'El campo procedimiento no debe superar los :max caracteres.',
                'tratamiento.required' => 'El campo tratamiento es obligatorio.',
                'tratamiento.string' => 'El campo tratamiento debe ser una cadena de texto.',
                'tratamiento.max' => 'El campo tratamiento no debe superar los :max caracteres.',
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
        $informeModel = Informe::class;
        
        if($informe) {
            $informe->paciente->fecha_nacimiento = Informe::formatDate($informe->paciente->fecha_nacimiento);
            $informe->created_at = Informe::formatTimestamp($informe->created_at);
        }

        return view('informes/verInforme')->with([
            'informe' => $informe,
            'informeModel' => $informeModel
        ]);
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
                'paciente_id.required' => 'El campo paciente es obligatorio.',
                'paciente_id.exists' => 'El paciente seleccionado no existe.',
                'medico_id.required' => 'El campo médico es obligatorio.',
                'medico_id.exists' => 'El médico seleccionado no existe.',
                'centro.required' => 'El campo centro es obligatorio.',
                'centro.string' => 'El campo centro debe ser una cadena de texto.',
                'centro.max' => 'El campo centro no debe superar los :max caracteres.',
                'especialidad.required' => 'El campo especialidad es obligatorio.',
                'especialidad.string' => 'El campo especialidad debe ser una cadena de texto.',
                'especialidad.max' => 'El campo especialidad no debe superar los :max caracteres.',
                'motivo_consulta.required' => 'El campo motivo de consulta es obligatorio.',
                'motivo_consulta.string' => 'El campo motivo de consulta debe ser una cadena de texto.',
                'motivo_consulta.max' => 'El campo motivo de consulta no debe superar los :max caracteres.',
                'enfermedad_actual.required' => 'El campo enfermedad actual es obligatorio.',
                'enfermedad_actual.string' => 'El campo enfermedad actual debe ser una cadena de texto.',
                'enfermedad_actual.max' => 'El campo enfermedad actual no debe superar los :max caracteres.',
                'diagnostico.required' => 'El campo diagnóstico es obligatorio.',
                'diagnostico.string' => 'El campo diagnóstico debe ser una cadena de texto.',
                'diagnostico.max' => 'El campo diagnóstico no debe superar los :max caracteres.',
                'procedimiento.required' => 'El campo procedimiento es obligatorio.',
                'procedimiento.string' => 'El campo procedimiento debe ser una cadena de texto.',
                'procedimiento.max' => 'El campo procedimiento no debe superar los :max caracteres.',
                'tratamiento.required' => 'El campo tratamiento es obligatorio.',
                'tratamiento.string' => 'El campo tratamiento debe ser una cadena de texto.',
                'tratamiento.max' => 'El campo tratamiento no debe superar los :max caracteres.',
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

    public function generarPDF(Informe $informe)
    {
        $informeModel = Informe::class;

        if ($informe) {
            $informe->paciente->fecha_nacimiento = Informe::formatDate($informe->paciente->fecha_nacimiento);
            $informe->created_at = Informe::formatTimestamp($informe->fecha);
        }

        $variables = [
            'informe' => $informe,
            'informeModel' => $informeModel
        ];

        $pdf = Pdf::loadView('informes.informePDF', $variables);

        return $pdf->stream('Informe.pdf');
    }
}
