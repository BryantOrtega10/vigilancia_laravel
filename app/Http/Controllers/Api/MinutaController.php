<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\MinutaRequest;
use App\Http\Utils\Funciones;
use App\Models\FotoModel;
use App\Models\MinutaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Storage;

class MinutaController extends Controller
{
    /**
     * Create minuta
     * Permite crear un nuevo registro de minuta
     * 
	 * @group  v 1.0.0
     * 
     * @bodyParam fecha string required Fecha del reporte
     * @bodyParam hora string required Hora del reporte
     * @bodyParam sede string required id de la sede del reporte
     * @bodyParam observacion string required observacion
     * @bodyParam images array required Imagenes de la novedad
     *
     * @authenticated
     * 
     * 
	 */
    public function create(MinutaRequest $request){   
        $usuario = Auth::user();

        $minuta = new MinutaModel();
        $minuta->fecha_reporte = $request->input("fecha")." ".$request->input("hora");
        $minuta->observacion = $request->input("observacion");
        $minuta->fk_sede = $request->input("sede");
        $minuta->fk_user = $usuario->id;
        $minuta->save();

        
        //Subir fotos
        $images = $request->input('images');
        foreach($images as $base64Image){
            $folder = "minutas/";
            $file_name =  uniqid() . "_min_" . $minuta->id. ".png";
            Funciones::subirBase64($base64Image, $folder.$file_name);
            Funciones::resizeImage($folder, $file_name, "min", 100, 100);
            Funciones::resizeImage($folder, $file_name, "max", 1000, 1000);
            $fileFinal = $folder . $file_name;
            Storage::delete($fileFinal);
            $foto = new FotoModel();
            $foto->fk_minuta = $minuta->id;
            $foto->ruta = $file_name;
            $foto->save();
        }



        return response()->json([
            "success" => true,
            "message" =>  "Minuta registrada correctamente"
        ]);
    }

    /**
     * Ver minuta de la sede
     * Permite ver la minuta de la sede
     * 
	 * @group  v 1.0.0
     * 
     * 
     * @bodyParam offset integer optional desde donde muestra los datos
     * @bodyParam limit integer optional cuanto trae por petición
     *
     * @authenticated
     * 
     * 
	 */
    public function show($id, Request $request){

        $limit = $request->input("limit") ?? 10;
        $offset = $request->input("offset") ?? 0;
        
        $minutas = MinutaModel::selectRaw("minuta.id, DATE_FORMAT(minuta.fecha_reporte,'%d/%m/%Y') as fecha_reporte, DATE_FORMAT(minuta.fecha_reporte,'%H:%i') as hora_reporte, minuta.observacion, users.name as usuario")
                    ->join("users","users.id","=","minuta.fk_user")
                    ->where("minuta.fk_sede","=",$id)
                    ->orderBy("minuta.fecha_reporte","DESC")
                    ->skip($offset)
                    ->take($limit)
                    ->get();
                    
       
        $total = MinutaModel::where("fk_sede","=",$id)->count();

        return response()->json([
            "success" => true,
            "message" =>  "Minutas consultadas correctamente",
            "minutas" => $minutas,
            "total" => $total
        ]);     
    }

}
