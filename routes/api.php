<?php

use App\Http\Controllers\Admin\Bitacora\BitacorasController;
use App\Http\Controllers\Admin\Brigada\BrigadasController;
use App\Http\Controllers\Admin\Doctor\DoctorsController;
use App\Http\Controllers\Admin\Doctor\SpecialityController;
use App\Http\Controllers\Admin\Rol\RolesController;
use App\Http\Controllers\Admin\Site\SitesController;
use App\Http\Controllers\Admin\Staff\StaffsController;
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

    
    Route::get("usuariozonaclaro/{id}",[StaffsController::class,"usuariozonaclaro"]);
    Route::get("usuariozonaresponsables/{id}",[StaffsController::class,"usuariozonaresponsables"]);
    Route::get("usuariozonatecnico/{id}",[StaffsController::class,"usuariozonatecnico"]);
    Route::get("staffs/config",[StaffsController::class,"config"]);
    Route::post("staffs/{id}",[StaffsController::class,"update"]);
    Route::resource("staffs",StaffsController::class);
    //
    Route::resource("specialities",SpecialityController::class);
    //
    Route::get("doctors/config",[DoctorsController::class,"config"]);
    Route::post("doctors/{id}",[DoctorsController::class,"update"]);
    Route::resource("doctors",DoctorsController::class);


    //

    Route::get("sitesautocomplete",[SitesController::class,"sitesautocomplete"]);
    Route::get("distritoprov/{id}",[SitesController::class,"distritoprov"]);
    Route::get("provinciasdep/{id}",[SitesController::class,"provinciadep"]);
    Route::get("sites/config",[SitesController::class,"config"]);
    Route::post("sites/{id}",[SitesController::class,"update"]);
    Route::resource("sites",SitesController::class);
    
    //brigadas
    
    Route::get("brigadas/brigadaactiva",[BrigadasController::class,"brigadaactiva"]);
    Route::get("brigadas/config",[BrigadasController::class,"config"]);
    Route::resource("brigadas",BrigadasController::class);

    
    Route::get("bitacoras/viewBitacora/{id}",[BitacorasController::class,"viewBitacora"]);
    Route::get("bitacoras/atencion/{id}",[BitacorasController::class,"listAtencion"]);
    Route::get("bitacoras/config",[BitacorasController::class,"config"]);
    Route::get("bitacoras/endConfig",[BitacorasController::class,"endConfig"]);
    Route::post("bitacoras/addAtencionBitacora",[BitacorasController::class,"addAtencionBitacora"]);
    Route::post("bitacoras/endBitacora",[BitacorasController::class,"endBitacora"]);
    
    Route::resource("bitacoras",BitacorasController::class);

});
