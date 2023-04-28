<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiaController;
// use App\Http\Controllers\API\UserController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JuezController;
use App\Http\Controllers\JuzgadoController;
use App\Http\Controllers\TramiteController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\RequisitoController;
use App\Http\Controllers\CitaJuzgadoController;
use App\Http\Controllers\TipoTramiteController;
use App\Http\Controllers\CentroAtencionController;
use App\Http\Controllers\NumeroContactoController;

use App\Http\Controllers\ConsejeroController;
use App\Http\Controllers\CitaConsejeroController;


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
});


/**
 * RUTAS ADMINISTRATIVAS
 */
Route::group(['middleware' => 'auth:sanctum'], function ($router) {
    /**
     * RUTAS UTILIZADAS POR DEFENSORIA Y POR JUZGADOS
     */
    // Ruta para obtener las fechas de un mes o en un rango de fechas
    Route::post('/horarios/llenar-dias', [DiaController::class, 'getDiasMes']);
    Route::post('/horarios/dias-editar', [DiaController::class, 'getDiasEditar']);
    Route::post('/horarios/actualizar-horario-citas', [DiaController::class, 'actualizarHorarioCitas']);
    
    /**
     * RUTAS UTILIZADAS POR JUZGADOS
     */
    // Ruta para guardar horarios para citas de un juez
    Route::post('/horarios/guardar-dias-juez', [DiaController::class, 'guardarDiasJuez']);
    Route::post('/horarios/actualizar-horario-juez', [DiaController::class, 'actualizarHorarioJuez']);
    Route::get('/catalogos/citas-del-dia-juez', [CitaJuzgadoController::class, 'getCitasDelDiaJuez']);
    Route::post('/citas/guardar-cambios-cita-juez', [CitaJuzgadoController::class, 'guardarCambios']);
    Route::post('/citas/citas-del-dia-juez-buscada', [CitaJuzgadoController::class, 'selectDiaCitaJuez']);
    Route::post('/reporte/grafica-juzgado', [CitaJuzgadoController::class, 'getReporteGraficasJuzgado']);
    // Route::post('/reporte/grafica-consejero', [CitaConsejeroController::class, 'getReporteGraficasConsejero']);

    // Rutas para reportes y graficas
    Route::post('/reporte-juez/grafica', [CitaJuzgadoController::class, 'getReporteGraficas']);
    Route::post('/reporte-consejero/grafica', [CitaConsejeroController::class, 'getReporteGraficas']);
    Route::post('/reportes/generar-reporte-juez', [ReportesController::class, 'generarReporteJuez']);
    Route::post('/reportes/generar-reporte-consejero', [ReportesController::class, 'generarReporteConsejero']);

    Route::post('/reportes/exportar-reporte-citas-juez', [ReportesController::class, 'exportarExcelJuez']);
    Route::post('/reportes/exportar-reporte-citas-consejero', [ReportesController::class, 'exportarExcelConsejero']);


    /**
     * RUTAS UTILIZADAS POR DEFENSORIA PUBLICA
     */
    // Ruta para guardar horarios para citas de un centro de atención
    Route::post('/horarios/guardar-dias', [DiaController::class, 'guardarDias']);
    Route::post('/horarios/actualizar-horario', [DiaController::class, 'actualizarHorario']);
    // Ruta para citas del día
    Route::get('/catalogos/citas-del-dia', [CitaController::class, 'getCitasDelDia']);
    // Actualizar estatus cita y motivo*
    Route::post('/citas/guardar-cambios-cita', [CitaController::class, 'guardarCambios']);
    Route::post('/citas/citas-del-dia-buscada', [CitaController::class, 'selectDiaCita']);
    // Rutas para reportes y graficas
    Route::post('/reporte/grafica', [CitaController::class, 'getReporteGraficas']);
    Route::post('/reportes/generar-reporte', [ReportesController::class, 'generarReporte']);
    Route::post('/reportes/exportar-reporte-citas', [ReportesController::class, 'exportarExcel']);












    
    // Ruta para guardar número de whatsapp
    Route::post('/whatsapp/guardar-numero', [NumeroContactoController::class, 'guardarNumero']);


    


    // Rutas utilizadas para catalogo de tramites
    Route::get('/catalogos/tramites', [TramiteController::class, 'getTramites']);
    Route::post('/tramite/guardar-nuevo', [TramiteController::class, 'guardarNuevoTramite']);
    Route::post('/tramite/actualizar-tramite', [TramiteController::class, 'actualizarTramite']);
    Route::post('/tramite/eliminar-tramite', [TramiteController::class, 'eliminarTramite']);

    // Rutas utilizadas para catalogo de requisitos
    Route::get('/catalogos/requisitos', [RequisitoController::class, 'getRequisitos']);
    Route::post('/requisito/guardar-nuevo', [RequisitoController::class, 'guardarNuevoRequisito']);
    Route::post('/requisito/actualizar-requisito', [RequisitoController::class, 'actualizarRequisito']);
    Route::post('/requisito/eliminar-requisito', [RequisitoController::class, 'eliminarRequisito']);

    // Rutas utilizadas para catalogo de notas 
    Route::get('/catalogos/notas', [NotaController::class, 'getNota']);
    Route::post('/notas/agregar-nota', [NotaController::class, 'guardarNuevaNota']);
    Route::post('/notas/actualizar-nota', [NotaController::class, 'actualizarNota']);
    Route::post('/notas/eliminar-nota', [NotaController::class, 'eliminarNota']);

    // Rutas utilizadas para catalogo de centros de atención
    Route::get('/catalogos/centros-de-atencion', [CentroAtencionController::class, 'getCentrosAtencion']);
    Route::post('/centro-atencion/guardar-nuevo', [CentroAtencionController::class, 'guardarNuevoCentro']);
    Route::post('/centro-atencion/actualizar-centro', [CentroAtencionController::class, 'actualizarCentroAtencion']);
    Route::post('/centro-atencion/eliminar-centro', [CentroAtencionController::class, 'eliminarCentroAtencion']);

    // Rutas utilizadas para catalogo de Usuarios
    Route::get('/catalogos/usuarios', [UserController::class, 'getUsuarios']);
    Route::get('/catalogos/usuarios-consejeros', [UserController::class, 'getUsuariosConsejeros']);
    Route::post('/usuarios/agregar-usuario', [UserController::class, 'guardarNuevoUsuario']);
    Route::post('/usuarios/actualizar-usuario', [UserController::class, 'actualizarUsuario']);
    Route::post('/usuarios/eliminar-usuario', [UserController::class, 'eliminarUsuario']);
    
    //Rutas catalogo de juzgados
   
    Route::post('/guardar-juzgado', [JuzgadoController::class, 'guardarJuzgado']);
    Route::post('/actualizar-juzgado', [JuzgadoController::class, 'actualizarJuzgado']);
    Route::post('/eliminar-juzgado', [JuzgadoController::class, 'eliminarJuzgado']);

    //Rutas catalogo jueces
    Route::get('/juzgados-jueces', [JuezController::class, 'getJueces']);
    Route::post('/guardar-juez', [JuezController::class, 'guardarJuez']);
    Route::post('/actualizar-juez', [JuezController::class, 'actualizarJuez']);
    Route::post('/eliminar-juez', [JuezController::class, 'eliminarJuez']);
    

     //Rutas catalogo consejeros
     Route::post('/horarios/guardar-dias-consejero', [DiaController::class, 'guardarDiasConsejero']);
     Route::post('/horarios/dias-editar-consejero', [DiaController::class, 'getDiasEditarConsejero']);
     Route::post('/horarios/actualizar-horario-consejero', [DiaController::class, 'actualizarHorarioConsejero']);
     Route::post('/guardar-consejero', [ConsejeroController::class, 'guardarConsejero']);
     Route::post('/actualizar-consejero', [ConsejeroController::class, 'actualizarConsejero']);
     Route::post('/eliminar-consejero', [ConsejeroController::class, 'eliminarConsejero']);
     Route::get('/catalogos/citas-del-dia-consejero', [CitaConsejeroController::class, 'getCitasDelDiaConsejero']);
     Route::post('/citas/citas-del-dia-consejero-buscada', [CitaConsejeroController::class, 'selectDiaCitaConsejero']);
     Route::post('/citas/guardar-cambios-cita-consejero', [CitaConsejeroController::class, 'guardarCambios']);
     Route::post('/reporte/grafica-consejero', [CitaConsejeroController::class, 'getReporteGraficasConsejero']);


}); 

/**
 * RUTAS PUBLICAS
 */
Route::get('/juzgados-citas', [JuzgadoController::class, 'getJuzgados']);
Route::get('/whatsapp/get-numero', [NumeroContactoController::class, 'getNumero']);

Route::get('/catalogos/tipos-de-tramite', [TipoTramiteController::class, 'getTipoTramite']);

Route::get('/tramites-citas', [TramiteController::class, 'getTramitesCitas']);
Route::post('/calendario-citas', [DiaController::class, 'getCalendarioCitas']);
// Route::post('/calendario-citas-juez', [DiaController::class, 'getCalendarioCitasJuez']);
Route::post('/citas/agendar-cita', [CitaController::class, 'agendarCita']);
Route::post('/citas/agendar-cita-juez', [CitaJuzgadoController::class, 'agendarCitaJuez']);

//Rutas utilizadas para los roles 
Route::get('/catalogos/roles', [RolController::class, 'getRoles']);

Route::post('/buscar-cita', [CitaController::class, 'buscarCita']);
Route::get('/cancelar-cita/{id}', [CitaController::class, 'cancelarCita']);
Route::get('/cancelar-cita-juzgado/{id}', [CitaJuzgadoController::class, 'cancelarCitaJuzgado']);
Route::get('/imprimir-cita/{id}', [CitaController::class, 'imprimirCita']);
Route::get('/imprimir-cita-juzgado/{id}', [CitaJuzgadoController::class, 'imprimirCitaJuzgado']);
Route::get('/imprimir-cita-consejero/{id}', [CitaConsejeroController::class, 'imprimirCitaConsejero']);
Route::get('/cancelar-cita-consejero/{id}', [CitaConsejeroController::class, 'cancelarCitaConsejero']);

Route::post('/tramite/requisitos-tipo-tramite', [TramiteController::class, 'getRequisitosTramite']);
Route::post('/tramite/requisitos-tipo-tramite-editar', [TramiteController::class, 'getRequisitosTramiteEditar']);


Route::get('/juzgados-materias', [MateriaController::class, 'getMaterias']);
Route::get('/consejeros', [ConsejeroController::class, 'getConsejeros']);
Route::post('/citas/agendar-cita-consejero', [CitaConsejeroController::class, 'agendarCitaConsejero']);

Route::post('/consultar-curp', [CitaJuzgadoController::class, 'consultarCurp']);
Route::post('/consulta-curp', [CitaConsejeroController::class, 'consultaCurp']);