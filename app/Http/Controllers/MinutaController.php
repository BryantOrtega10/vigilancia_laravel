<?php

namespace App\Http\Controllers;

use App\Models\FotoModel;
use App\Models\MinutaModel;
use App\Models\SedeModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MinutaController extends Controller
{
    public function mostrarTabla()
    {
        $usuario = Auth::user();
        if ($usuario->rol == "admin") {
            $minutas = MinutaModel::orderBy("fecha_reporte","DESC")->get();
        }
        else{
            $minutas = MinutaModel::select("minuta.*")
                                  ->join("sede", "sede.id", "=", "minuta.fk_sede")
                                  ->join("users_sede as us", "us.fk_sede", "=", "sede.id")
                                  ->where("us.fk_user", "=", $usuario->id)
                                  ->orderBy("minuta.fecha_reporte","DESC")
                                  ->get();
        }
        
        return view('minutas.tabla', [
            'minutas' => $minutas
        ]);
    }
    
    public function verDetalles($id){
        $minuta = MinutaModel::findOrFail($id);        
        if(!$this->validarSede($minuta->fk_sede)){
            return redirect(route('propiedad.tabla'))->with('error', 'Esta sede no esta asignada a tu usuario');
        }
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
        if(!$this->validarSede($minuta->fk_sede)){
            return redirect(route('propiedad.tabla'))->with('error', 'Esta sede no esta asignada a tu usuario');
        }         
        $fotos = FotoModel::where("fk_minuta","=",$id)->get();

        foreach($fotos as $foto){
            $path = 'minutas/max_'.$foto->ruta;
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

    private function validarSede($id)
    {
        $usuario = Auth::user();
        if ($usuario->rol != "admin") {
            $sede = SedeModel::select("sede.*")
                ->join("users_sede as us", "us.fk_sede", "=", "sede.id")
                ->where("us.fk_user", "=", $usuario->id)
                ->where("sede.id", "=", $id)
                ->orderBy("sede.nombre")
                ->first();
            if (!isset($sede)) {
                return false;
            }
        }
        return true;
    }
}
