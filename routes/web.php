<?php

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\InformeController;
use App\Http\Controllers\ResultadoController;

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
Route::get('/register', function () {return view('register');})->name('register');

// view login
Route::get('/login', function () {return view('login');})->name('login');

// change password
Route::get('/changePassword', function () {return view('changePassword');});
Route::post('/changePassword', [AuthController::class, 'changePassword']);


// register db 
Route::post('/register', [AuthController::class, 'register']);

// login db
Route::post('/login', [AuthController::class, 'login']);

//logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// profile
Route::get('/profile', [AuthController::class, 'profile'])->name('profile')->middleware('verifyIfAuthenticated');
Route::post('/profile', [AuthController::class, 'profile'])->name('profile')->middleware('verifyIfAuthenticated');

// Rutas para las citas
Route::get('/citas', [CitaController::class, 'show'])->name("citas")->middleware('verifyIfAuthenticated');
Route::get('/citas/crear', [CitaController::class, 'create'])->name("crearCita")->middleware('verifyIfAuthenticated');
Route::get('/citas/pdf/{cita}', [CitaController::class, 'generarPDF'])->name("citaGenerarPDF")->middleware('verifyIfAuthenticated');
Route::get('/citas/editar/{cita}', [CitaController::class, 'update'])->name("editarCita")->middleware('verifyIfAuthenticated');

Route::post('/citas/crear', [CitaController::class, 'create'])->name("crearCita")->middleware('verifyIfAuthenticated');
Route::post('/citas/editar/{cita}', [CitaController::class, 'update'])->name("editarCita")->middleware('verifyIfAuthenticated');

Route::delete('/citas/eliminar/{cita}', [CitaController::class, 'delete'])->name("eliminarCita")->middleware('verifyIfAuthenticated');

// Rutas para los informes
Route::get('/informes', [InformeController::class, 'show'])->name('informes')->middleware('verifyIfAuthenticated');
Route::get('/informes/crear', [InformeController::class, 'create'])->name('crearInforme')->middleware('verifyIfAuthenticated');
Route::get('/informes/pdf/{informe}', [InformeController::class, 'generarPDF'])->name("informeGenerarPDF")->middleware('verifyIfAuthenticated');
Route::get('/informes/{informe}', [InformeController::class, 'read'])->name('verInforme')->middleware('verifyIfAuthenticated');
Route::get('/informes/editar/{informe}', [InformeController::class, 'update'])->name('editarInforme')->middleware('verifyIfAuthenticated');

Route::post('/informes/crear', [InformeController::class, 'create'])->name('crearInforme')->middleware('verifyIfAuthenticated');
Route::post('/informes/editar/{informe}', [InformeController::class, 'update'])->name('editarInforme')->middleware('verifyIfAuthenticated');

Route::delete('/informes/eliminar/{informe}', [InformeController::class, 'delete'])->name('eliminarInforme')->middleware('verifyIfAuthenticated');

// Rutas para los resultados
Route::get('/resultados', [ResultadoController::class, 'show'])->name('resultados')->middleware('verifyIfAuthenticated');
Route::get('/resultados/crear', [ResultadoController::class, 'create'])->name("crearResultado")->middleware('verifyIfAuthenticated');
Route::get('/resultados/pdf/{resultado}', [ResultadoController::class, 'generarPDF'])->name("resultadoGenerarPDF")->middleware('verifyIfAuthenticated');
Route::get('/resultados/{resultado}', [ResultadoController::class, 'read'])->name('verResultado')->middleware('verifyIfAuthenticated');
Route::get('/resultados/editar/{resultado}', [ResultadoController::class, 'update'])->name("editarResultado")->middleware('verifyIfAuthenticated');

Route::post('/resultados/crear', [ResultadoController::class, 'create'])->name("crearResultado")->middleware('verifyIfAuthenticated');
Route::post('/resultados/editar/{resultado}', [ResultadoController::class, 'update'])->name("editarResultado")->middleware('verifyIfAuthenticated');

Route::delete('/resultados/eliminar/{resultado}', [ResultadoController::class, 'delete'])->name("eliminarResultado")->middleware('verifyIfAuthenticated');

// rutas chat
Route::get('/chat', [ChatController::class, 'show'])->name('chat')->middleware('verifyIfAuthenticated');
Route::post('/chat/startChat', [ChatController::class, 'startChat'])->name('startChat')->middleware('verifyIfAuthenticated');
Route::post('/chat/saveMessage', [ChatController::class, 'saveMessage'])->name('saveMessage')->middleware('verifyIfAuthenticated');
Route::get('/chat/getMessages/{chat_id}', [ChatController::class, 'getMessages'])->name('getMessages')->middleware('verifyIfAuthenticated');
Route::delete('/chat/deleteMessage/{id}', [ChatController::class, 'deleteMessage'])->name('deleteMessage')->middleware('verifyIfAuthenticated');

// idiomas
Route::get('/lang/{language}', function ($language) {
    Session::put('language',$language);
    return redirect()->back();
})->name('language');