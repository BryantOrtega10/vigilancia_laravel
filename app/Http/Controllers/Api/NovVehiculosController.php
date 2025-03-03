<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\NovVehiculosRequest;
use App\Http\Utils\Funciones;
use App\Models\FotoModel;
use App\Models\NovedadVehModel;
use App\Models\VehiculoModel;
use App\Models\VisitaModel;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NovVehiculosController extends Controller
{
    /**
     * Create novedad vehiculo
     * Permite crear un nuevo registro de novedad vehiculo
     * 
	 * @group  v 1.0.0
     * 
     * @bodyParam fecha string required Fecha del reporte
     * @bodyParam hora string required Hora del reporte
     * @bodyParam placa string required placa en mayuscula
     * @bodyParam tipo_vehiculo string required id del tipo_vehiculo
     * @bodyParam observacion string required observacion
     * @bodyParam images array required Imagenes de la novedad
     *
     * @authenticated
     * 
     * 
	 */
    public function create(NovVehiculosRequest $request){   
        $usuario = Auth::user();

        $vehiculo = VehiculoModel::where("placa","=",$request->input("placa"))
                                 ->where("fk_tipo_vehiculo","=",$request->input("tipo_vehiculo"))
                                 ->first();
        $visita = VisitaModel::where("placa","=",$request->input("placa"))
                                 ->where("fk_tipo_vehiculo","=",$request->input("tipo_vehiculo"))
                                 ->first();


        $novedadVeh = new NovedadVehModel();
        $novedadVeh->fecha_hora = $request->input("fecha")." ".$request->input("hora");
        $novedadVeh->observacion = $request->input("observacion");
        if(isset($vehiculo)){
            $novedadVeh->fk_vehiculo = $vehiculo->id;
        }
        else if(isset($visita)){
            $novedadVeh->fk_visita = $visita->id;
        }
        else {
            $novedadVeh->placa = $request->input("placa");
            $novedadVeh->fk_tipo_vehiculo = $request->input("tipo_vehiculo");            
        }
        $novedadVeh->fk_user = $usuario->id;
        $novedadVeh->save();

        //Subir fotos
        $images = $request->input('images');
        foreach($images as $base64Image){
            $folder = "novedades/";
            $file_name =  uniqid() . "_nov_" . $novedadVeh->id. ".png";
            Funciones::subirBase64($base64Image, $folder.$file_name);
            Funciones::resizeImage($folder, $file_name, "min", 100, 100);
            Funciones::resizeImage($folder, $file_name, "max", 1000, 1000);
            $fileFinal = $folder . $file_name;
            Storage::delete($fileFinal);

            $foto = new FotoModel();
            $foto->fk_novedad_veh = $novedadVeh->id;
            $foto->ruta = $file_name;
            $foto->save();

        }



        return response()->json([
            "success" => true,
            "message" =>  "Novedad registrada correctamente"
        ]);
    }
}
