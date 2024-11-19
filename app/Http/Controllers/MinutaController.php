<?php

namespace App\Http\Controllers;

use App\Models\FotoModel;
use App\Models\MinutaModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MinutaController extends Controller
{
    public function mostrarTabla()
    {
        $minutas = MinutaModel::orderBy("fecha_reporte","DESC")->get();
        return view('minutas.tabla', [
            'minutas' => $minutas
        ]);
    }
    
    public function verDetalles($id){
        $minuta = MinutaModel::findOrFail($id);        
        $fotos = FotoModel::where("fk_minuta","=",$id)->get();
        $html = view('minutas.detalle',[
            'minuta' => $minuta,
            'fotos' => $fotos
        ])->render();
        return response()->json([
            "success" => true,
            "html" => $html
        ]);
    }

    public function generarPdf($id){
        $minuta = MinutaModel::findOrFail($id);        
        $fotos = FotoModel::where("fk_minuta","=",$id)->get();

        foreach($fotos as $foto){
            $path = 'minutas/min_'.$foto->ruta;
            if (!Storage::disk('public')->exists($path)) {
                return response()->json(['error' => 'Archivo no encontrado'], 404);
            }
            $imagen = Storage::disk('public')->get($path);
            $base64Img = base64_encode($imagen);
            $foto->img_base64 = $base64Img;
        }

        $pdf = Pdf::loadView('minutas.pdf', [
            'minuta' => $minuta,
            'fotos' => $fotos
        ])
        ->setPaper('A4');
        
        return $pdf->download("Minuta ".$minuta->id." en ".$minuta->sede->nombre.".pdf");
    }
}
