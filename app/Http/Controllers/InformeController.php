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
        $usuario = User::getAuthenticatedUser();
        $rolUsuario = User::getRole();

        if($rolUsuario === 'Medico') {
            $informes = Informe::where('medico_id', $usuario->id)->orderBy('created_at')->get();
        }else if($rolUsuario === 'Paciente') {
            $informes = Informe::where('paciente_id', $usuario->id)->orderBy('created_at')->get();
        }else {
            $informes = Informe::orderBy('created_at')->get();
        }

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request, Informe $informe = new Informe())
    {
        //
    }
}
