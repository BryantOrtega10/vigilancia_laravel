<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\VisitaRequest;
use App\Http\Requests\Api\VisitaSalidaRequest;
use App\Http\Utils\Funciones;
use App\Models\FotoModel;
use App\Models\VisitaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Storage;

class VisitaController extends Controller
{
    /**
     * Create Visita
     * Permite crear una visita
     * 
     * @group  v 1.0.0
     * 
     * @bodyParam documento string required Documento de la persona que ingresa
     * @bodyParam nombre string required Nombre de la persona que ingresa
     * @bodyParam observacion string required
     * @bodyParam responsable string required Responsable que dejo entrar a la persona
     * @bodyParam manejo_datos integer required 1 si autoriza el manejo de datos 0 si no
     * @bodyParam placa string nullable Placa del vehiculo si la visita ingresa con vehiculo 
     * @bodyParam tipo_vehiculo_id string nullable Id del tipo de vehiculo si la visita ingresa con vehiculo
     * @bodyParam propiedad_id string required Id de la propiedad a donde ingresa la visita
     * 
     * @authenticated
     * 
     * 
     */
    public function create(VisitaRequest $request)
    {
        $usuario = Auth::user();
        $visita = new VisitaModel();
        $visita->fecha_entrada = date("Y-m-d H:i:s");
        $visita->documento = $request->input("documento");
        $visita->nombre = $request->input("nombre");
        $visita->observacion = $request->input("observacion");
        $visita->responsable = $request->input("responsable");
        $visita->manejo_datos = $request->input("manejo_datos");
        if ($request->has("placa") && !empty($request->input("placa")) && $request->has("tipo_vehiculo_id") && !empty($request->input("tipo_vehiculo_id"))) {
            $visita->placa = $request->input("placa");
            $visita->fk_tipo_vehiculo = $request->input("tipo_vehiculo_id");
        }
        $visita->fk_propiedad = $request->input("propiedad_id");
        $visita->fk_user_entrada = $usuario->id;
        $visita->save();

         //Subir fotos
        $images = $request->input('images');
        foreach($images as $base64Image){
            $folder = "visitas/";
            $file_name =  uniqid() . "_visita_" . $visita->id. ".png";
            Funciones::subirBase64($base64Image, $folder.$file_name);
            Funciones::resizeImage($folder, $file_name, "min", 100, 100);
            Funciones::resizeImage($folder, $file_name, "max", 1000, 1000);
            $fileFinal = $folder . $file_name;
            Storage::delete($fileFinal);
            $foto = new FotoModel();
            $foto->fk_visita = $visita->id;
            $foto->ruta = $file_name;
            $foto->save();
        }

        return response()->json([
            "success" => true,
            "message" =>  "Entrada de una visita registrada correctamente"
        ]);
    }

    /**
     * Get visita activa by id Propiedad
     * Get visita related with Id de Propiedad
     * 
     * @group  v 1.0.0
     * 
     * @urlParam idPropiedad integer required Id de Propiedad.
     * 
     * @authenticated
     * 
     * 
     */
    public function findVisita(Request $request)
    {
        $visitas = VisitaModel::with("tipo_vehiculo")->with("fotos")->where("fk_propiedad", "=", $request->input("idPropiedad"))
                        ->whereNull("fecha_salida")
                        ->orderBy("fecha_entrada")
                        ->get();
        if(sizeof($visitas) == 0){
            return response()->json([
                "success" => false,
                "message" => "No hay visitas para esta propiedad"
            ],404); 
        }


        return response()->json([
            "visitas" => $visitas
        ]);
    }


     /**
     * Get visita activa by id Propiedad
     * Get visita related with Id de Propiedad
     * 
     * @group  v 1.0.0
     * 
     * @urlParam idPropiedad integer required Id de Propiedad.
     * 
     * @authenticated
     * 
     * 
     */
    public function regitrarSalida($id, VisitaSalidaRequest $request)
    {
        $visita = VisitaModel::find($id);
        if(!isset($visita)){
            return response()->json([
                "success" => false,
                "message" => "Visita no encontrada"
            ],404); 
        }
        $usuario = Auth::user();
        $visita->observacion_salida = $request->input("observacion_salida");
        $visita->fecha_salida = date("Y-m-d H:i:s");
        $visita->fk_user_salida = $usuario->id;
        $visita->save();
        

        return response()->json([
            "success" => true,
            "message" => "Salida registrada correctamente"
        ]);
    }
}
