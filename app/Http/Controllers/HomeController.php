<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    public function show() {
        if(session()->has('user')) {
            $usuario = User::find(session()->get('user')->id);
            
            return view('home')->with('usuario', $usuario);
        }else {
            return redirect()->route('login');
        }
    }
}
