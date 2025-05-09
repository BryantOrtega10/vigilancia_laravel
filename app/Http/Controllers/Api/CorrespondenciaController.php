<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CorrespondenciaRequest;
use App\Http\Utils\Funciones;
use App\Models\FotoModel;
use App\Models\PaqueteModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Storage;

class CorrespondenciaController extends Controller
{
    /**
     * Create correspondencia
     * Permite crear un nuevo registro de correspondencia
     * 
	 * @group  v 1.0.0
     * 
     * @bodyParam propiedad string required id de la propiedad del reporte
     * @bodyParam observacion string required observacion
     * @bodyParam images array required Imagenes de la novedad
     *
     * @authenticated
     * 
     * 
	 */
    public function create(CorrespondenciaRequest $request){   
        $usuario = Auth::user();

        $paquete = new PaqueteModel();
        $paquete->observacion = $request->input("observacion");
        $paquete->codigo = substr(md5(uniqid()), 0,4);
        $paquete->entregado = 0;
        $paquete->fk_propiedad = $request->input("propiedad");
        $paquete->fk_user_recibe = $usuario->id;
        $paquete->fecha_recepcion = date("Y-m-d H:i:s");
        $paquete->save();

        
        //Subir fotos
        $images = $request->input('images');
        foreach($images as $base64Image){
            $folder = "paquetes/";
            $file_name =  uniqid() . "_paq_" . $paquete->id. ".png";
            Funciones::subirBase64($base64Image, $folder.$file_name);
            Funciones::resizeImage($folder, $file_name, "min", 100, 100);
            Funciones::resizeImage($folder, $file_name, "max", 1000, 1000);
            $fileFinal = $folder . $file_name;
            Storage::delete($fileFinal);
            $foto = new FotoModel();
            $foto->fk_paquete = $paquete->id;
            $foto->ruta = $file_name;
            $foto->save();
        }



        return response()->json([
            "success" => true,
            "message" =>  "Paquete registrado correctamente",
            "codigo" => $paquete->codigo
        ]);
    }


     /**
     * Ver paquetes de la propiedad
     * Permite ver los paquetes no entregados de la propiedad
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
        
        $paquetes = PaqueteModel::with('fotos')
                                ->selectRaw("paquete.id, DATE_FORMAT(paquete.fecha_recepcion,'%d/%m/%Y') as fecha_recepcion, 
                                            DATE_FORMAT(paquete.fecha_recepcion,'%H:%i') as hora_recepcion, paquete.observacion, 
                                            users.name as usuario_recibe")
                    ->join("users","users.id","=","paquete.fk_user_recibe")
                    ->where("paquete.fk_propiedad","=",$id)
                    ->where("paquete.entregado","=",0)
                    ->orderBy("paquete.fecha_recepcion","DESC")
                    ->skip($offset)
                    ->take($limit)
                    ->get();
                    
       
        $total = PaqueteModel::where("paquete.fk_propiedad","=",$id)->where("paquete.entregado","=",0)->count();

        return response()->json([
            "success" => true,
            "message" =>  "Paquetes consultados correctamente",
            "paquetes" => $paquetes,
            "total" => $total
        ]);     
    }


    public function update($id, Request $request){

        $paquete = PaqueteModel::findOrFail($id);
        if(trim($request->input("codigo")) != $paquete->codigo){
            return response()->json([
                "success" => false,
                "message" => "El código no coincide con el paquete"
            ], 401);
        }

        $paquete->fecha_entrega = date("Y-m-d H:i:s");
        $paquete->entregado = 1;
        $paquete->fk_user_entrega = Auth::user()->id;
        $paquete->save();
        return response()->json([
            "success" => true,
            "message" => "La entrega ha sido validada correctamente"
        ]);

    }
    
}
