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
        // Obtener la ruta actual
        $ruta = $request->path();

        // Verificar la ruta y realizar acciones según sea necesario
        if ($ruta === 'login' or $ruta === 'register') {
            if ($request->session()->has('user')) {
                return redirect()->route('home');
            }
        }else {
            if (!$request->session()->has('user')) {
                return redirect()->route('login');
            }
        }

        if($request->session()->has('user')) {
            $usuario = User::getAuthenticatedUser();
            $userRole = User::getRole();

            if($userRole === 'Medico') {
                $citas = Cita::where('medico_id', $usuario->id)->orderBy('fecha')->orderBy('hora')->get();
            }else if($userRole === 'Paciente') {
                $citas = Cita::where('paciente_id', $usuario->id)->orderBy('fecha')->orderBy('hora')->get();
            }else {
                $citas = Cita::orderBy('fecha')->orderBy('hora')->get();
            }
    
            if($citas) {
                foreach($citas as $cita) {
                    $cita->paciente_id = User::find($cita->paciente_id);
                    $cita->medico_id = User::find($cita->medico_id);
                    $cita->fecha = date("d/m/Y", strtotime($cita->fecha));
                    $cita->hora = date("H:i", strtotime($cita->hora));
                }
            }

            $citaModel = Cita::class;
    
            View::share('usuario', $usuario);
            View::share('citas', $citas);
            View::share('citaModel', $citaModel);
        }

        return $next($request);
    }
}