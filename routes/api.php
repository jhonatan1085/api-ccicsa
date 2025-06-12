<?php

use App\Http\Controllers\Admin\Bitacora\BitacorasController;
use App\Http\Controllers\Admin\Brigada\BrigadasController;
use App\Http\Controllers\Admin\Doctor\DoctorsController;
use App\Http\Controllers\Admin\Doctor\SpecialityController;
use App\Http\Controllers\Admin\Lideres\LideresController;
use App\Http\Controllers\Admin\Rol\RolesController;
use App\Http\Controllers\Admin\Site\SitesController;
use App\Http\Controllers\Admin\UnidadMovil\ColorController;
use App\Http\Controllers\Admin\UnidadMovil\MarcaController;
use App\Http\Controllers\Admin\UnidadMovil\ModeloController;
use App\Http\Controllers\Admin\UnidadMovil\UnidadMovilController;
use App\Http\Controllers\Admin\Usuarios\UsuariosController;
use App\Http\Controllers\Admin\Zona\ZonasController;
use App\Http\Controllers\AuthController;
use App\Models\UnidadMovil\Modelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([

    //'middleware' => 'auth:api', no son necesarias par acceso publico
    'prefix' => 'auth',
    //'middleware' =>['auth:api','role:Super-Admin'],
    //'middleware' =>['permission:publish articles'],
    //'middleware' =>['role_or_permission:Super-Admin | edit articles',
], function ($router) {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
    Route::post('/me', [AuthController::class, 'me'])->name('me');
    Route::post('/list', [AuthController::class, 'list']);
    Route::post('/reg', [AuthController::class, 'reg']);
});

Route::group([
    'middleware' => 'auth:api',
], function ($router) {
    Route::resource("roles",RolesController::class);

    $endpoint = "usuarios";
    // EXTRAS
    
    Route::post($endpoint."/asignar-zona",[UsuariosController::class,"asignarZona"]);
    Route::get($endpoint."/responsables/zona",[UsuariosController::class,"usuariosResponsablesPorZona"]);
    Route::get($endpoint."/tecnicos/zona/{zona_id}",[UsuariosController::class,"usuariosTecnicosPorZona"]);
    Route::resource($endpoint,UsuariosController::class);//all

    $endpoint = "lideres";
    // EXTRAS
    
    Route::resource($endpoint,LideresController::class);//all

    $endpoint = "sites";
    // EXTRAS
    Route::get($endpoint."/autocomplete",[SitesController::class,"autocomplete"]);
    Route::get($endpoint."/municipalidad/distrito/{distrito_id}",[SitesController::class,"municipalidadPorDistrito"]);
    Route::get($endpoint."/distritos/provincia/{provincia_id}",[SitesController::class,"distritosPorProvincia"]);
    Route::get($endpoint."/provincias/depto/{depto_id}",[SitesController::class,"provinciasPorDepto"]);
    Route::resource($endpoint,SitesController::class);//all

    $endpoint = "brigadas";
    // extras
    Route::get($endpoint."/activas",[BrigadasController::class,"activas"]);
    Route::resource($endpoint,BrigadasController::class);//all

    $endpoint = "bitacoras";
    // extras
    Route::get($endpoint."/group-whastApp/{bitacora_id}",[BitacorasController::class,"groupWhatsApp"]);
    Route::get($endpoint."/exportaBitacoras",[BitacorasController::class,"exportaBitacoras"]);
    Route::get($endpoint."/atencion/{bitacora_id}",[BitacorasController::class,"listarAtenciones"]);
    Route::get($endpoint."/demoras/{bitacora_id}",[BitacorasController::class,"listarDemoras"]);
    Route::post($endpoint."/atenciones",[BitacorasController::class,"addAtencion"]);
    Route::post($endpoint."/finalizar",[BitacorasController::class,"updateFinal"]);
    Route::post($endpoint."/demoras",[BitacorasController::class,"addDemora"]);
    Route::post($endpoint."/localizacion",[BitacorasController::class,"updateLocation"]);
    Route::patch($endpoint."/closed-sot/{bitacora_id}",[BitacorasController::class,"closedSot"]);
    Route::resource($endpoint,BitacorasController::class);//all
    //

    $endpoint = "unidades-moviles";
    // extras

    Route::post($endpoint."/asignar",[UnidadMovilController::class,"asignar"]);
    Route::resource($endpoint,UnidadMovilController::class);//all
    
    $endpoint = "marcas";
    // extras
    //Route::get($endpoint."/atencion/{bitacora_id}",[BitacorasController::class,"listarAtenciones"]);
    Route::resource($endpoint,MarcaController::class);//all

    $endpoint = "modelos";
    // extras
    //Route::get($endpoint."/atencion/{bitacora_id}",[BitacorasController::class,"listarAtenciones"]);
    Route::resource($endpoint,ModeloController::class);//all

    $endpoint = "colores";
    // extras
    //Route::get($endpoint."/atencion/{bitacora_id}",[BitacorasController::class,"listarAtenciones"]);
    Route::resource($endpoint,ColorController::class);//all

    $endpoint = "zonas";
    // extras
    //Route::get($endpoint."/atencion/{bitacora_id}",[BitacorasController::class,"listarAtenciones"]);
    Route::resource($endpoint,ZonasController::class);//all

    ////////////////
    // configs   //
    //////////////
    $endpoint = "config";
    Route::get($endpoint."/usuarios",[UsuariosController::class,"config"]);
    Route::get($endpoint."/lideres",[LideresController::class,"config"]);
    Route::get($endpoint."/sites",[SitesController::class,"config"]);
    Route::get($endpoint."/brigadas",[BrigadasController::class,"config"]);
    Route::get($endpoint."/bitacoras/start",[BitacorasController::class,"config"]);
    Route::get($endpoint."/bitacoras/end",[BitacorasController::class,"endConfig"]);
    Route::get($endpoint."/bitacoras/demoras",[BitacorasController::class,"demorasConfig"]);
    Route::get($endpoint."/unidades-moviles",[UnidadMovilController::class,"config"]);
});
