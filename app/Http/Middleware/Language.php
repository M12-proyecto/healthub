<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Language {
    public function handle($request, Closure $next)
    {
        if (Session::has('language')) {
            $language = Session::get('language');
            $flag = $this->getFlagForLanguage($language);
            view()->share('languageFlag', $this->removeFlagsFromUrl($flag));
        } else {
            $language = 'es'; // Si no hay idioma seleccionado, predeterminar a español
            view()->share('languageFlag', asset('assets/images/flags/spain.jpg'));
        }

        App::setLocale($language);

        return $next($request);
    }

    private function getFlagForLanguage($language)
    {
        // Mapeo de idiomas a rutas de banderas
        $flags = [
            'en' => 'us.jpg',
            'es' => 'spain.jpg',
            'ca' => 'catalan.png',
            'it' => 'italy.jpg',
            'ru' => 'russia.jpg',
        ];

        // Obtener la ruta de la bandera para el idioma dado
        return asset('assets/images/flags/' . $flags[$language]);
    }

    private function removeFlagsFromUrl($url)
    {
        // Eliminar "flags" de la URL
        return preg_replace("/\/flags\//", "/", $url);
    }
}