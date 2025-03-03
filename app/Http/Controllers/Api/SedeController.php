<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SedeModel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SedeController extends Controller
{
    /**
     * Get List Sede
     * Get list of all sedes related with user logged
     * 
	 * @group  v 1.0.0
     * 
     * @authenticated
     * 
     * 
	 */
    public function getList(){
        $usuario = Auth::user();
        $sedes = SedeModel::select("sede.*")
                    ->join("users_sede as us", "us.fk_sede","=", "sede.id")
                    ->where("us.fk_user","=",$usuario->id)
                    ->orderBy("sede.nombre")
                    ->get();
        return response()->json([
            "sedes" => $sedes
        ],200);
    }
}
