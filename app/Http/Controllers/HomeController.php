<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    public function show() {
        if(session()->get('user')){
            return view('home');
        } else{
            return view('login');
        }
    }
}
