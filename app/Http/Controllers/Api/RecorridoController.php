<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RecorridoModel;
use App\Models\RondaModel;
use Auth;
use Illuminate\Http\Request;

class RecorridoController extends Controller
{
     /**
     * Create recorrido
     * Permite crear un nuevo registro de recorrido
     * 
	 * @group  v 1.0.0
     * 
     * @bodyParam qrCode string required Codigo QR
     *
     * @authenticated
     * 
     * 
	 */
    public function create(Request $request){       
        $usuario = Auth::user();
        $ronda = RondaModel::where("codigo_qr","=",$request->qrCode)->first();
        if(!isset($ronda)){
            return response()->json([
                "success" => false,
                "message" => "No se reconoce este codigo QR, intentelo nuevamente"
            ], 404);
        }

        $recorrido = new RecorridoModel();
        $recorrido->fecha_hora = date("Y-m-d H:i:s");
        $recorrido->fk_user = $usuario->id;
        $recorrido->fk_ronda = $ronda->id;
        $recorrido->save();

        return response()->json([
            "success" => true,
            "message" =>  "Recorrido registrado correctamente"
        ]);
    }
}
