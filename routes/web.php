<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
//use Spatie\Permission\Models\Role;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// roles

//$role = Role::create(['name' => 'admin']);
//$role = Role::create(['name' => 'medico']);
//$role = Role::create(['name' => 'paciente']);

Route::get('/', function () {
    return view('home');
});

// view register
Route::get('/register', function () {
    return view('register');
});

// view login
Route::get('/login', function () {
    return view('login');
});

// register db 
Route::post('/register', [AuthController::class, 'register']);

// login db
Route::post('/login', [AuthController::class, 'login']);

//logout
Route::post('/logout', [AuthController::class, 'logout']);