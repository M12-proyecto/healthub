<?php

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\InformeController;

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
})->name('register')->middleware('verifyIfAuthenticated');

// view login
Route::get('/login', function () {
    return view('login');
})->name('login')->middleware('verifyIfAuthenticated');

// register db 
Route::post('/register', [AuthController::class, 'register']);

// login db
Route::post('/login', [AuthController::class, 'login']);

//logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas para las citas
Route::get('/citas', [CitaController::class, 'show'])->name("citas")->middleware('verifyIfAuthenticated');
Route::get('/citas/crear', [CitaController::class, 'create'])->name("crearCita")->middleware('verifyIfAuthenticated');
Route::get('/citas/editar/{cita}', [CitaController::class, 'update'])->name("editarCita")->middleware('verifyIfAuthenticated');

Route::post('/citas/crear', [CitaController::class, 'create'])->name("crearCita")->middleware('verifyIfAuthenticated');
Route::post('/citas/editar/{cita}', [CitaController::class, 'update'])->name("editarCita")->middleware('verifyIfAuthenticated');

Route::delete('/citas/eliminar/{cita}', [CitaController::class, 'delete'])->name("eliminarCita")->middleware('verifyIfAuthenticated');

// Rutas para los informes
Route::get('/informes', [InformeController::class, 'show'])->name('informes')->middleware('verifyIfAuthenticated');