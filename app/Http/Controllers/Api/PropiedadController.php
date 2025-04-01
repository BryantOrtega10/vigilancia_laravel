<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PropiedadModel;
use Illuminate\Http\Request;

class PropiedadController extends Controller
{
    /**
     * Get List Propiedad by id Grupo
     * Get list of all Propiedad related with id of GrPropiedad
     * 
	 * @group  v 1.0.0
     * 
     * @urlParam idGrupo integer required Id de GrPropiedad.
     * 
     * @authenticated
     * 
     * 
	 */
    public function getList(Request $request){
        $propiedades = PropiedadModel::with('propietario')->with("residentes")->where("fk_gr_propiedad","=",$request->input("idGrupo"))->orderBy("nombre")->get();
        

        return response()->json([
            "propiedades" => $propiedades
        ]);
    }
}
