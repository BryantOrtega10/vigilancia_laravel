<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PropiedadesController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes(['register' => false, 'login' => false]);

Route::get('/', function () {

    if (Auth::check()){
        switch(strtolower(Auth::user()->rol)){
            case 'admin':
                return redirect(route('propiedad.tabla'));
                break;
        }
    }
    return view('auth.login');
})->name('login');

Route::post('/login', [LoginController::class, 'login']);


Route::get("storage-link", function () {
	File::link(
		storage_path('app/public'),
		public_path('storage')
	);
});

Route::group([
    'prefix' => 'propiedad',
    'middleware' => ['auth', 'user-role:admin']
], function () {
    Route::get("/", [PropiedadesController::class, 'mostrarTabla'])->name("propiedad.tabla");
    Route::get("/agregar", [PropiedadesController::class, 'mostrarAgregar'])->name("propiedad.agregar");
    Route::post("/agregar", [PropiedadesController::class, 'agregar']);
    Route::get("/modificar/{id}", [PropiedadesController::class, 'mostrarModificar'])->name("propiedad.modificar");
    Route::post("/modificar/{id}", [PropiedadesController::class, 'modificar']);
    Route::post("/eliminar/{id}", [PropiedadesController::class, 'eliminar'])->name("propiedad.eliminar");
    
    
    Route::get("/configurar/{id}", [PropiedadesController::class, 'mostrarConfig'])->name("propiedad.config");
        
    Route::get("/grupo/agregar/{id}", [PropiedadesController::class, 'mostrarAgregarGrupo'])->name("propiedad.grupo.agregar");
    Route::post("/grupo/agregar/{id}", [PropiedadesController::class, 'agregarGrupo']);
    Route::get("/grupo/modificar/{id}", [PropiedadesController::class, 'mostrarModificarGrupo'])->name("propiedad.grupo.modificar");
    Route::post("/grupo/modificar/{id}", [PropiedadesController::class, 'modificarGrupo']);
    Route::post("/grupo/eliminar/{id}", [PropiedadesController::class, 'eliminarGrupo'])->name("propiedad.grupo.eliminar");
    
    Route::get("/grupo/item/agregar/{id}", [PropiedadesController::class, 'mostrarAgregarItem'])->name("propiedad.grupo.item.agregar");
    Route::post("/grupo/item/agregar/{id}", [PropiedadesController::class, 'agregarItem']);
    Route::get("/grupo/item/modificar/{id}", [PropiedadesController::class, 'mostrarModificarItem'])->name("propiedad.grupo.item.modificar");
    Route::post("/grupo/item/modificar/{id}", [PropiedadesController::class, 'modificarItem']);
    Route::post("/grupo/item/eliminar/{id}", [PropiedadesController::class, 'eliminarItem'])->name("propiedad.grupo.item.eliminar");
});