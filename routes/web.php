<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CitasController;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

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
//$role = Role::create(['name' => 'Adminnn']);

Route::get('/', function () {
    return view('login');
});

Route::get('/home', [HomeController::class, 'show'])->name('home');

// view register
Route::get('/register', function () {
    return view('register');
})->name('register');

// view login
Route::get('/login', function () {
    return view('login');
})->name('login');

// register db 
Route::post('/register', [AuthController::class, 'register']);

// login db
Route::post('/login', [AuthController::class, 'login']);

//logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas para las citas
Route::get('/citas', [CitasController::class, 'show'])->name("citas");
Route::get('/citas/crear', [CitasController::class, 'create'])->name("crearCita");
