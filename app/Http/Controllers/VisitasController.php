<?php

namespace App\Http\Controllers;

use App\Models\SedeModel;
use App\Models\VisitaModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Storage;

class VisitasController extends Controller
{
    public function mostrarTabla()
    {
        $usuario = Auth::user();
        if ($usuario->rol == "admin") {
            $visitas = VisitaModel::orderBy("fecha_entrada","DESC")->get();
        }
        else{
            $visitas = VisitaModel::select("visita.*")
                                  ->join("propiedad","propiedad.id","=","visita.fk_propiedad")
                                  ->join("gr_propiedad","gr_propiedad.id","=","propiedad.fk_gr_propiedad")
                                  ->join("users_sede as us", "us.fk_sede", "=", "gr_propiedad.fk_sede")
                                  ->where("us.fk_user", "=", $usuario->id)
                                  ->orderBy("visita.fecha_entrada","DESC")
                                  ->get();
        }

        return view('visitas.tabla', [
            'visitas' => $visitas
        ]);
    }
    
    public function verDetalles($id){
        $visita = VisitaModel::findOrFail($id);        
        $grupo = $visita->propiedad->gr_propiedad;
        if(!$this->validarSede($grupo->fk_sede)){
            return redirect(route('propiedad.tabla'))->with('error', 'Esta sede no esta asignada a tu usuario');
        }

        $html = view('visitas.detalle',[
            'visita' => $visita
        ])->render();
        return response()->json([
            "success" => true,
            "html" => $html
        ]);
    }

    public function generarPdf($id){
        
        $visita = VisitaModel::findOrFail($id);        
        $grupo = $visita->propiedad->gr_propiedad;
        if(!$this->validarSede($grupo->fk_sede)){
            return redirect(route('propiedad.tabla'))->with('error', 'Esta sede no esta asignada a tu usuario');
        }

        foreach($visita->fotos as $foto){
            $path = 'visitas/max_'.$foto->ruta;
            if (!Storage::disk('public')->exists($path)) {
                return response()->json(['error' => 'Archivo no encontrado'], 404);
            }
            $imagen = Storage::disk('public')->get($path);
            $base64Img = base64_encode($imagen);
            $foto->img_base64 = $base64Img;
        }

        $pdf = Pdf::loadView('visitas.pdf', [
            'visita' => $visita
        ])->setOption('chroot', [dirname(__DIR__,3)])
        ->setPaper('A4');
        
        return $pdf->download("Entrada - Salida ".$visita->id." en ".$visita->propiedad->gr_propiedad->sede->nombre.".pdf");
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
