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
}
