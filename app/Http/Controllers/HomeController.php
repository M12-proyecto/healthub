<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    public function show() {
        $usuario = User::find(session()->get('user')->id);

        if(session()->get('user')) {
            return view('home')->with('usuario', $usuario);
        }else {
            return redirect()->route('login');
        }
    }
}
