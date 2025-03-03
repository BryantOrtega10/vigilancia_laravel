<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TipoVehiculoModel;
use Illuminate\Http\Request;

class TipoVehiculoController extends Controller
{
    /**
     * Get List of all Tipos Vehiculo
     * Get list of all Tipos Vehiculo related with id
     * 
	 * @group  v 1.0.0
     * 
     * 
     * @authenticated
     * 
     * 
	 */
    public function getList(){
        $tipos_vehiculo = TipoVehiculoModel::orderBy("nombre")->get();
        return response()->json([
            "tipos_vehiculo" => $tipos_vehiculo
        ]);
    }
}
