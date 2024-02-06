<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    public function show() {
        $usuario = User::find(5);

        return view('home', ["usuario" => $usuario]);
    }
}
