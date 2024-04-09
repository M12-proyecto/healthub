<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Models\Cita;
use Illuminate\Support\Facades\View;

class VerifyIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->session()->has('user')) {
            return redirect()->route('login');
        }

        $usuario = User::find(session()->get('user')->id);
        $citas = Cita::where('paciente_id', $usuario->id)->orderBy('fecha')->get();

        if($citas) {
            foreach($citas as $cita) {
                $cita->paciente_id = User::find($cita->paciente_id);
                $cita->medico_id = User::find($cita->medico_id);
                $cita->fecha = date("d/m/Y", strtotime($cita->fecha));
                $cita->hora = date("H:i", strtotime($cita->hora));
            }
        }

        View::share('usuario', $usuario);
        View::share('citas', $citas);

        return $next($request);
    }
}