<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\TramiteController;
// use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\RequisitoController;
use App\Http\Controllers\TipoTramiteController;
use App\Http\Controllers\CentroAtencionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\DiaController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function() {
    Route::post('login', 'login');
    Route::post('register', 'register');
});

Route::get('/catalogos/tramites', [TramiteController::class, 'getTramites']);
Route::get('/catalogos/centros-de-atencion', [CentroAtencionController::class, 'getCentrosAtencion']);
Route::post('/centro-atencion/guardar-nuevo', [CentroAtencionController::class, 'guardarNuevoCentro']);
Route::post('/centro-atencion/actualizar-centro', [CentroAtencionController::class, 'actualizarCentroAtencion']);
Route::post('/centro-atencion/eliminar-centro', [CentroAtencionController::class, 'eliminarCentroAtencion']);

Route::get('/catalogos/tipos-de-tramite', [TipoTramiteController::class, 'getTipoTramite']);
//Rutas utilizadas para catalogo de requisitos
Route::get('/catalogos/requisitos', [RequisitoController::class, 'getRequisitos']);
Route::post('/requisito/guardar-nuevo', [RequisitoController::class, 'guardarNuevoRequisito']);
Route::post('/requisito/actualizar-requisito', [RequisitoController::class, 'actualizarRequisito']);
Route::post('/requisito/eliminar-requisito', [RequisitoController::class, 'eliminarRequisito']);

Route::get('/tramites-citas', [TramiteController::class, 'getTramitesCitas']);
Route::post('/calendario-citas', [DiaController::class, 'getCalendarioCitas']);
Route::post('/citas/agendar-cita', [CitaController::class, 'agendarCita']);

//Rutas utilizadas para catalogo de Usuarios
Route::get('/catalogos/usuarios', [UserController::class, 'getUsuarios']);
Route::post('/usuarios/agregar-usuario', [UserController::class, 'guardarNuevoUsuario']);
Route::post('/usuarios/actualizar-usuario', [UserController::class, 'actualizarUsuario']);
Route::post('/usuarios/eliminar-usuario', [UserController::class, 'eliminarUsuario']);

//Rutas utilizadas para los roles 
Route::get('/catalogos/roles', [RolController::class, 'getRoles']);

//Rutas utilizadas para catalogo de notas 
Route::get('/catalogos/notas', [NotaController::class, 'getNota']);
Route::post('/notas/agregar-nota', [NotaController::class, 'guardarNuevaNota']);
Route::post('/notas/actualizar-nota', [NotaController::class, 'actualizarNota']);
Route::post('/notas/eliminar-nota', [NotaController::class, 'eliminarNota']);

Route::post('/tramite/guardar-nuevo', [TramiteController::class, 'guardarNuevoTramite']);
Route::post('/tramite/actualizar-tramite', [TramiteController::class, 'actualizarTramite']);
Route::post('/tramite/eliminar-tramite', [TramiteController::class, 'eliminarTramite']);



Route::post('/buscar-cita', [CitaController::class, 'buscarCita']);
Route::get('/cancelar-cita/{id}', [CitaController::class, 'cancelarCita']);
Route::get('/imprimir-cita/{id}', [CitaController::class, 'imprimirCita']);


Route::post('/horarios/llenar-dias', [DiaController::class, 'getDiasMes']);
Route::post('/horarios/guardar-dias', [DiaController::class, 'guardarDias']);
Route::post('/horarios/dias-editar', [DiaController::class, 'getDiasEditar']);
Route::post('/horarios/actualizar-horario', [DiaController::class, 'actualizarHorario']);

Route::post('/tramite/requisitos-tipo-tramite', [TramiteController::class, 'getRequisitosTramite']);

// Route::post('agregar-usuario', 'UserController@store');
