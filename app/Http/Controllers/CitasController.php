<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cita;

class CitasController extends Controller
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
        $usuario = User::find(5);
        $citas = Cita::where('paciente_id', $usuario->id)->get();

        foreach($citas as $cita) {
            $cita->paciente_id = User::find($cita->paciente_id);
            $cita->medico_id = User::find($cita->medico_id);
            $cita->fecha = date("d/m/Y", strtotime($cita->fecha));
            $cita->hora = date("H:i", strtotime($cita->hora));
        }

        return view('citas')->with([
            'usuario' => $usuario,
            'citas' => $citas
        ]);
    }

    public function create(Request $request) {
        if($request->all()) {

        }else {
            return redirect()->route('citas');
        }
    }

    public function update(Request $request) {

    }

    public function delete(Request $request) {

    }
}
