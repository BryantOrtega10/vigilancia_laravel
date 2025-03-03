<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BuzonController;
use App\Http\Controllers\MinutaController;
use App\Http\Controllers\NovParqueaderoController;
use App\Http\Controllers\PropiedadesController;
use App\Http\Controllers\RondasController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\VisitasController;
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

Route::get('/cache', function () {
	$exitCode = Artisan::call('route:clear');
	$exitCode = Artisan::call('view:clear');
	$exitCode = Artisan::call('config:cache');
	$exitCode = Artisan::call('config:clear');

	return '<h3>Cache eliminado</h3>';
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

    Route::post("/subirCSV", [PropiedadesController::class, 'subirCSV'])->name("propiedad.subirCSV");
    
    Route::get("/configurar/{id}", [PropiedadesController::class, 'mostrarConfig'])->name("propiedad.config");
        
    Route::group([
        'prefix' => 'grupo'
    ], function () {
        Route::get("/agregar/{id}", [PropiedadesController::class, 'mostrarAgregarGrupo'])->name("propiedad.grupo.agregar");
        Route::post("/agregar/{id}", [PropiedadesController::class, 'agregarGrupo']);
        Route::get("/modificar/{id}", [PropiedadesController::class, 'mostrarModificarGrupo'])->name("propiedad.grupo.modificar");
        Route::post("/modificar/{id}", [PropiedadesController::class, 'modificarGrupo']);
        Route::post("/eliminar/{id}", [PropiedadesController::class, 'eliminarGrupo'])->name("propiedad.grupo.eliminar");
        Route::group([
            'prefix' => 'item'
        ], function () {
            Route::get("/agregar/{id}", [PropiedadesController::class, 'mostrarAgregarItem'])->name("propiedad.grupo.item.agregar");
            Route::post("/agregar/{id}", [PropiedadesController::class, 'agregarItem']);
            Route::get("/modificar/{id}", [PropiedadesController::class, 'mostrarModificarItem'])->name("propiedad.grupo.item.modificar");
            Route::post("/modificar/{id}", [PropiedadesController::class, 'modificarItem']);
            Route::post("/eliminar/{id}", [PropiedadesController::class, 'eliminarItem'])->name("propiedad.grupo.item.eliminar");
        });
    });
});


Route::group([
    'prefix' => 'rondas',
    'middleware' => ['auth', 'user-role:admin']
], function () {
    Route::get("/", [RondasController::class, 'mostrarTablaRecorridos'])->name("rondas.tablaRecorridos");
    Route::get("/ver/{idRecorrido}", [RondasController::class, 'verRecorrido'])->name("rondas.verRecorrido");
    Route::post("/eliminar/{idRecorrido}", [RondasController::class, 'eliminarRecorrido'])->name("rondas.eliminarRecorrido");

    Route::group([
        'prefix' => 'interna'
    ], function () {
        Route::get("/", [RondasController::class, 'mostrarQRs'])->name("rondas.vistaQRs");
        Route::get("/agregar", [RondasController::class, 'mostrarAgregar'])->name("rondas.agregar");
        Route::post("/agregar", [RondasController::class, 'agregar']);
        Route::get("/modificar/{idRonda}", [RondasController::class, 'mostrarModificar'])->name("rondas.modificar");
        Route::post("/modificar/{idRonda}", [RondasController::class, 'modificar']);
        Route::post("/eliminar/{idRonda}", [RondasController::class, 'eliminar'])->name("rondas.eliminar");
        Route::get("/descargar/{idRonda}", [RondasController::class, 'descargarQR'])->name("rondas.descargar");
    });
});

Route::group([
    'prefix' => 'novedades',
    'middleware' => ['auth', 'user-role:admin']
], function () {
    Route::get("/", [NovParqueaderoController::class, 'mostrarTabla'])->name("novedad.tabla");
    Route::get("/ver/{id}", [NovParqueaderoController::class, 'verDetalles'])->name("novedad.verDetalles");
    Route::get("/pdf/{id}", [NovParqueaderoController::class, 'generarPdf'])->name("novedad.pdf");
});

Route::group([
    'prefix' => 'minutas',
    'middleware' => ['auth', 'user-role:admin']
], function () {
    Route::get("/", [MinutaController::class, 'mostrarTabla'])->name("minuta.tabla");
    Route::get("/ver/{id}", [MinutaController::class, 'verDetalles'])->name("minuta.verDetalles");
    Route::get("/pdf/{id}", [MinutaController::class, 'generarPdf'])->name("minuta.pdf");
});


Route::group([
    'prefix' => 'paquetes',
    'middleware' => ['auth', 'user-role:admin']
], function () {
    Route::get("/", [BuzonController::class, 'mostrarTabla'])->name("paquetes.tabla");
    Route::get("/ver/{id}", [BuzonController::class, 'verDetalles'])->name("paquetes.verDetalles");
    Route::get("/pdf/{id}", [BuzonController::class, 'generarPdf'])->name("paquetes.pdf");
    Route::get("/validar/{id}", [BuzonController::class, 'mostrarValidar'])->name("paquetes.validar");
    Route::post("/validar/{id}", [BuzonController::class, 'validar']);
});


Route::group([
    'prefix' => 'visitas',
    'middleware' => ['auth', 'user-role:admin']
], function () {
    Route::get("/", [VisitasController::class, 'mostrarTabla'])->name("visitas.tabla");
    Route::get("/ver/{id}", [VisitasController::class, 'verDetalles'])->name("visitas.verDetalles");
    Route::get("/pdf/{id}", [VisitasController::class, 'generarPdf'])->name("visitas.pdf");
});


Route::group([
    'prefix' => 'usuarios',
    'middleware' => ['auth', 'user-role:admin']
], function () {
    Route::get("/", [UsuariosController::class, 'mostrarTabla'])->name("usuarios.tabla");
    Route::get("/agregar", [UsuariosController::class, 'mostrarAgregar'])->name("usuarios.agregar");
    Route::post("/agregar", [UsuariosController::class, 'agregar']);
    Route::get("/modificar/{id}", [UsuariosController::class, 'mostrarModificar'])->name("usuarios.modificar");
    Route::post("/modificar/{id}", [UsuariosController::class, 'modificar']);
    Route::post("/eliminar/{id}", [UsuariosController::class, 'eliminar'])->name("usuarios.eliminar");
});