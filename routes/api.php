<?php

use App\Http\Controllers\Admin\Bitacora\BitacorasController;
use App\Http\Controllers\Admin\Brigada\BrigadasController;
use App\Http\Controllers\Admin\Doctor\DoctorsController;
use App\Http\Controllers\Admin\Doctor\SpecialityController;
use App\Http\Controllers\Admin\Rol\RolesController;
use App\Http\Controllers\Admin\Site\SitesController;
use App\Http\Controllers\Admin\Usuarios\UsuariosController;
use App\Http\Controllers\AuthController;
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
    ///////////////
    // Usuarios //
    /////////////
    // CRUD controllers
    $endpoint = "usuarios";
    // Route::post($endpoint, [UsuariosController::class,"store"]);
    Route::resource($endpoint,UsuariosController::class);//all
    // Route::get($endpoint."/{id}",[UsuariosController::class,"show"]);//one
    // Route::post($endpoint."/{id}",[UsuariosController::class,"update"]);
    // Route::get($endpoint."/{id}",[UsuariosController::class,"destroy"]);
    // EXTRAS
    Route::get($endpoint."/responsables/zona/{zona_id}",[UsuariosController::class,"usuariosResponsablesPorZona"]);
    Route::get($endpoint."/tecnicos/zona/{zona_id}",[UsuariosController::class,"usuariosTecnicosPorZona"]);

    ///////////////
    // Sites    //
    /////////////
    // CRUD controllers
    $endpoint = "sites";
    // Route::post($endpoint, [SitesController::class,"store"]);
    Route::resource($endpoint,SitesController::class);//all
    // Route::get($endpoint."/{id}",[SitesController::class,"show"]);//one
    // Route::post($endpoint."/{id}",[SitesController::class,"update"]);
    // Route::get($endpoint."/{id}",[SitesController::class,"destroy"]);
    // EXTRAS
    Route::get($endpoint."/autocomplete",[SitesController::class,"autocomplete"]);
    Route::get($endpoint."/distritos/provincia/{provincia_id}",[SitesController::class,"distritosPorProvincia"]);
    Route::get($endpoint."/provincias/depto/{depto_id}",[SitesController::class,"provinciasPorDepto"]);

    /////////////////
    //  brigadas  //
    ///////////////
    // CRUD controllers
    $endpoint = "brigadas";
    // Route::post($endpoint, [BrigadasController::class,"store"]);
    Route::resource($endpoint,BrigadasController::class);//all
    // Route::get($endpoint."/{id}",[BrigadasController::class,"show"]);//one
    // Route::post($endpoint."/{id}",[BrigadasController::class,"update"]);
    // Route::get($endpoint."/{id}",[BrigadasController::class,"destroy"]);
    // extras
    Route::get($endpoint."/activas",[BrigadasController::class,"activas"]);

    ////////////////
    // bitacoras //
    //////////////
    // CRUD controllers
    $endpoint = "bitacoras";
    // Route::post($endpoint, [BitacorasController::class,"store"]);
    Route::resource($endpoint,BitacorasController::class);//all
    // Route::get($endpoint."/{id}",[BitacorasController::class,"show"]);//one
    // Route::post($endpoint."/{id}",[BitacorasController::class,"update"]);
    // update or patch
    // update es completa
    // patch es parcial
    // Route::get($endpoint."/{id}",[BitacorasController::class,"destroy"]);
    // extras
    Route::get($endpoint."/atenciones/bitacora/{bitacora_id}",[BitacorasController::class,"listarAtenciones"]);
    Route::post($endpoint."/atenciones/bitacora",[BitacorasController::class,"addAtencion"]);
    Route::post($endpoint."/finalizar",[BitacorasController::class,"updateFinal"]);
    Route::post($endpoint."/localizacion",[BitacorasController::class,"updateLocation"]);
    //


    ////////////////
    // configs   //
    //////////////
    $endpoint = "config";
    Route::get($endpoint."/usuarios",[UsuariosController::class,"config"]);
    Route::get($endpoint."/sites",[SitesController::class,"config"]);
    Route::get($endpoint."/brigadas",[BrigadasController::class,"config"]);
    Route::get($endpoint."/bitacoras/start",[BitacorasController::class,"config"]);
    Route::get($endpoint."/bitacoras/end",[BitacorasController::class,"endConfig"]);
});
