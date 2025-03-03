<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GrPropiedadModel;
use Illuminate\Http\Request;

class GrPropiedadController extends Controller
{
    /**
     * Get List Gr Propiedad by id sede
     * Get list of all GrPropiedad related with id
     * 
	 * @group  v 1.0.0
     * 
     * @urlParam idSede integer required Id de la sede.
     * 
     * @authenticated
     * 
     * 
	 */
    public function getList(Request $request){
        $grupos = GrPropiedadModel::select("gr_propiedad.*","tgr.nombre as tipo_gr")
            ->join("tipo_gr_propiedad as tgr","tgr.id","=","gr_propiedad.fk_tipo_gr_propiedad")
            ->where("fk_sede","=",$request->input("idSede"))
            ->orderBy("nombre")
            ->get();
        return response()->json([
            "grupos" => $grupos
        ]);
    }
}
