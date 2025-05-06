<?php

use App\Http\Controllers\Api\CorrespondenciaController;
use App\Http\Controllers\Api\GrPropiedadController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\MinutaController;
use App\Http\Controllers\Api\NovVehiculosController;
use App\Http\Controllers\Api\PropiedadController;
use App\Http\Controllers\Api\RecorridoController;
use App\Http\Controllers\Api\RiesgosController;
use App\Http\Controllers\Api\SedeController;
use App\Http\Controllers\Api\TipoVehiculoController;
use App\Http\Controllers\Api\VisitaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get("/sede", [SedeController::class, 'getList'])->middleware('auth:sanctum');
Route::get("/grupo", [GrPropiedadController::class, 'getList'])->middleware('auth:sanctum');
Route::get("/propiedad", [PropiedadController::class, 'getList'])->middleware('auth:sanctum');
Route::get("/tipo-vehiculo", [TipoVehiculoController::class, 'getList'])->middleware('auth:sanctum');


Route::post("/recorrido", [RecorridoController::class, 'create'])->middleware('auth:sanctum');
Route::post("/visita", [VisitaController::class, 'create'])->middleware('auth:sanctum');
Route::get("/visita", [VisitaController::class, 'findVisita'])->middleware('auth:sanctum');
Route::put("/visita/{id}", [VisitaController::class, 'regitrarSalida'])->middleware('auth:sanctum');

Route::post("/novedad-vehiculo", [NovVehiculosController::class, 'create'])->middleware('auth:sanctum');

Route::post("/minuta", [MinutaController::class, 'create'])->middleware('auth:sanctum');
Route::get("/minuta/{id}", [MinutaController::class, 'show'])->middleware('auth:sanctum');

Route::post("/correspondencia", [CorrespondenciaController::class, 'create'])->middleware('auth:sanctum');
Route::get("/correspondencia/{id}", [CorrespondenciaController::class, 'show'])->middleware('auth:sanctum');
Route::put("/correspondencia/{id}", [CorrespondenciaController::class, 'update'])->middleware('auth:sanctum');

Route::prefix('riesgo')->middleware("auth:sanctum")->group(function () {
    Route::get("/", [RiesgosController::class, 'show']);
    Route::post("/", [RiesgosController::class, 'create']);
    Route::put("/{id}", [RiesgosController::class, 'update']);    
});