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

// Creacion de roles

// $role = Role::create(['name' => 'Administrador']);
// $role = Role::create(['name' => 'Medico']);
// $role = Role::create(['name' => 'Paciente']);
// $role = Role::create(['name' => 'Recepcionista']);

Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/home', [HomeController::class, 'show'])->name('home')->middleware('verifyIfAuthenticated');

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
Route::get('/citas', [CitasController::class, 'show'])->name("citas")->middleware('verifyIfAuthenticated');
Route::get('/citas/crear', [CitasController::class, 'create'])->name("crearCita")->middleware('verifyIfAuthenticated');
Route::get('/citas/editar/{cita}', [CitasController::class, 'update'])->name("editarCita")->middleware('verifyIfAuthenticated');

Route::post('/citas/crear', [CitasController::class, 'create'])->name("crearCita")->middleware('verifyIfAuthenticated');
Route::post('/citas/editar/{cita}', [CitasController::class, 'update'])->name("editarCita")->middleware('verifyIfAuthenticated');

Route::delete('/citas/eliminar/{cita}', [CitasController::class, 'delete'])->name("eliminarCita")->middleware('verifyIfAuthenticated');
