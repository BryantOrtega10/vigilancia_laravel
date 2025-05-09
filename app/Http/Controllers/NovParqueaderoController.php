<?php

namespace App\Http\Controllers;

use App\Models\FotoModel;
use App\Models\NovedadVehModel;
use App\Models\SedeModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NovParqueaderoController extends Controller
{
    public function mostrarTabla()
    {
        $usuario = Auth::user();
        if ($usuario->rol == "admin") {
            $novedades = NovedadVehModel::orderBy("fecha_hora","DESC")->get();
        }
        else{
            $novedades = NovedadVehModel::select("novedad_veh.*")
                                        ->leftJoin("vehiculo","vehiculo.id","=","novedad_veh.fk_vehiculo")
                                        ->leftJoin("propiedad","propiedad.id","=","vehiculo.fk_propiedad")
                                        ->leftJoin("gr_propiedad","gr_propiedad.id","=","propiedad.fk_gr_propiedad")
                                        ->leftJoin("users_sede as us1", "us1.fk_sede", "=", "gr_propiedad.fk_sede")
                                        
                                        ->leftJoin("visita","visita.id","=","novedad_veh.fk_visita")
                                        ->leftJoin("propiedad as propiedad2","propiedad2.id","=","visita.fk_propiedad")
                                        ->leftJoin("gr_propiedad as gr_propiedad2","gr_propiedad2.id","=","propiedad2.fk_gr_propiedad")
                                        ->leftJoin("users_sede as us2", "us2.fk_sede", "=", "gr_propiedad2.fk_sede")

                                        ->where(function($query) use($usuario) {
                                            $query->where("us1.fk_user", "=", $usuario->id)
                                                  ->orWhere("us2.fk_user", "=", $usuario->id);
                                        })
                                        ->orderBy("novedad_veh.fecha_hora","DESC")->get();
        }
        return view('novedades.tabla', [
            'novedades' => $novedades
        ]);
    }
    
    public function verDetalles($id){
        if(!$this->validarSede($id)){
            return redirect(route('propiedad.tabla'))->with('error', 'Esta sede no esta asignada a tu usuario');
        }
        $novedad = NovedadVehModel::findOrFail($id);        
        $fotos = FotoModel::where("fk_novedad_veh","=",$id)->get();
        $html = view('novedades.detalle',[
            'novedad' => $novedad,
            'fotos' => $fotos
        ])->render();
        return response()->json([
            "success" => true,
            "html" => $html
        ]);
    }

    public function generarPdf($id){
        
        if(!$this->validarSede($id)){
            return redirect(route('propiedad.tabla'))->with('error', 'Esta sede no esta asignada a tu usuario');
        }
        $novedad = NovedadVehModel::findOrFail($id);        
        $fotos = FotoModel::where("fk_novedad_veh","=",$id)->get();

        foreach($fotos as $foto){
            $path = 'novedades/max_'.$foto->ruta;
            if (!Storage::disk('public')->exists($path)) {
                return response()->json(['error' => 'Archivo no encontrado'], 404);
            }
            $imagen = Storage::disk('public')->get($path);
            $base64Img = base64_encode($imagen);
            $foto->img_base64 = $base64Img;
        }

        $pdf = Pdf::loadView('novedades.pdf', [
            'novedad' => $novedad,
            'fotos' => $fotos
        ])
        ->setPaper('A4');
        return $pdf->download("Novedad ".$novedad->id." en ".$novedad->sede_txt().".pdf");
    }

    private function validarSede($id)
    {
        $usuario = Auth::user();
        if ($usuario->rol != "admin") {
            $novedad = NovedadVehModel::findOrFail($id);        
            if($novedad->fk_vehiculo != null){
                $propiedad = $novedad->vehiculo->propiedad;            
                
            }
            else if($novedad->fk_visita != null){
                $propiedad = $novedad->visita->propiedad;
            }
            
            $sede = SedeModel::select("sede.*")
            ->join("users_sede as us", "us.fk_sede", "=", "sede.id")
            ->where("us.fk_user", "=", $usuario->id)
            ->where("sede.id", "=", $propiedad->gr_propiedad->fk_sede)
            ->orderBy("sede.nombre")
            ->first();
            
            if (!isset($sede)) {
                return false;
            }

        }
        return true;
    }
}
