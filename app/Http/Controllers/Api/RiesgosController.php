<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ActualizarRiesgoRequest;
use App\Http\Requests\Api\RiesgosRequest;
use App\Http\Utils\Funciones;
use App\Models\FotoModel;
use App\Models\RiesgoLogModel;
use App\Models\RiesgoModel;
use App\Models\UserSedeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RiesgosController extends Controller
{
    /**
     * Create riesgo
     * Permite crear un nuevo registro de riesgo
     * 
	 * @group  v 1.0.0
     * 
     * 
     * @bodyParam descripcion string required Descripcion del riesgo potencial
     * @bodyParam probabilidad integer required Valor de 1 a 10 indicando la probabilidad de que el riesgo se materialice
     * @bodyParam sede string required id de la sede donde se encontró el riesgo
     * @bodyParam images array required Imagenes del riesgo
     *
     * @authenticated
     * 
     * 
	 */
    public function create(RiesgosRequest $request){   
        $usuario = Auth::user();

        $riesgo = new RiesgoModel();
        $riesgo->descripcion = $request->input("descripcion");
        $riesgo->probabilidad = $request->input("probabilidad");
        $riesgo->fk_sede = $request->input("sede");
        $riesgo->save();

        $riesgo_log = new RiesgoLogModel();
        $riesgo_log->descripcion = $request->input("descripcion");
        $riesgo_log->probabilidad = $request->input("probabilidad");
        $riesgo_log->fk_riesgo = $riesgo->id;
        $riesgo_log->fk_user = $usuario->id;
        $riesgo_log->save();      

        
        //Subir fotos
        $images = $request->input('images');
        foreach($images as $base64Image){
            $folder = "riesgos/";
            $file_name =  uniqid() . "_rie_" . $riesgo->id. "_".$riesgo_log->id.".png";
            Funciones::subirBase64($base64Image, $folder.$file_name);
            Funciones::resizeImage($folder, $file_name, "min", 100, 100);
            Funciones::resizeImage($folder, $file_name, "max", 1000, 1000);
            $fileFinal = $folder . $file_name;
            Storage::delete($fileFinal);
            $foto = new FotoModel();
            $foto->fk_riesgo_log = $riesgo_log->id;
            $foto->ruta = $file_name;
            $foto->save();
        }

        return response()->json([
            "success" => true,
            "message" =>  "Riesgo registrado correctamente"
        ]);
    }


    /**
     * Ver riesgos de la sede
     * Permite ver los riesgos activos de la sede
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
    public function show(Request $request){

        $limit = $request->input("limit") ?? 10;
        $offset = $request->input("offset") ?? 0;
        $usuario = Auth::user();

        $sedes_user = UserSedeModel::select("fk_sede")->where("fk_user","=",$usuario->id)->get()->toArray();
        $sedes_user = array_map(function ($a) { return $a['fk_sede']; }, $sedes_user);
        
        $riesgos = RiesgoModel::whereIn("fk_sede",$sedes_user)
                    ->where("estado","=",1)
                    ->skip($offset)
                    ->take($limit)
                    ->get();
        
        $total = RiesgoModel::whereIn("fk_sede",$sedes_user)
        ->where("estado","=",1)
        ->count();

        return response()->json([
            "success" => true,
            "message" =>  "Riesgos consultados correctamente",
            "riesgos" => $riesgos,
            "total" => $total
        ]);     
    }


    /**
     * Ver riesgos de la sede
     * Permite ver los riesgos activos de la sede
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
    public function update($id, ActualizarRiesgoRequest $request){

        $usuario = Auth::user();

        
        $riesgo = RiesgoModel::find($id);
        $riesgo->descripcion = $request->input("descripcion");
        $riesgo->probabilidad = $request->input("probabilidad");
        $riesgo->save();


        $riesgo_log = new RiesgoLogModel();
        $riesgo_log->descripcion = $request->input("descripcion");
        $riesgo_log->probabilidad = $request->input("probabilidad");
        $riesgo_log->fk_user = $usuario->id;
        $riesgo_log->fk_riesgo = $id;
        $riesgo_log->save();      

        
        //Subir fotos
        $images = $request->input('images') ?? [];
        foreach($images as $base64Image){
            $folder = "riesgos/";
            $file_name =  uniqid() . "_rie_" . $riesgo->id. "_".$riesgo_log->id.".png";
            Funciones::subirBase64($base64Image, $folder.$file_name);
            Funciones::resizeImage($folder, $file_name, "min", 100, 100);
            Funciones::resizeImage($folder, $file_name, "max", 1000, 1000);
            $fileFinal = $folder . $file_name;
            Storage::delete($fileFinal);
            $foto = new FotoModel();
            $foto->fk_riesgo_log = $riesgo_log->id;
            $foto->ruta = $file_name;
            $foto->save();
        }


        return response()->json([
            "success" => true,
            "message" =>  "Riesgo actualizado correctamente"
        ]);     
    }
}
