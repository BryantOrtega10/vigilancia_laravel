<?php

namespace App\Http\Controllers;

use App\Models\FotoModel;
use App\Models\NovedadVehModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NovParqueaderoController extends Controller
{
    public function mostrarTabla()
    {
        $novedades = NovedadVehModel::orderBy("fecha_hora","DESC")->get();
        return view('novedades.tabla', [
            'novedades' => $novedades
        ]);
    }
    
    public function verDetalles($id){
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
    
}
