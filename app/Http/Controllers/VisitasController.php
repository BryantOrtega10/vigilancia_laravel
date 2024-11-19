<?php

namespace App\Http\Controllers;

use App\Models\VisitaModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class VisitasController extends Controller
{
    public function mostrarTabla()
    {
        $visitas = VisitaModel::orderBy("fecha_entrada","DESC")->get();
        return view('visitas.tabla', [
            'visitas' => $visitas
        ]);
    }
    
    public function verDetalles($id){
        $visita = VisitaModel::findOrFail($id);        

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

        $pdf = Pdf::loadView('visitas.pdf', [
            'visita' => $visita
        ])
        ->setPaper('A4');
        
        return $pdf->download("Entrada - Salida ".$visita->id." en ".$visita->propiedad->gr_propiedad->sede->nombre.".pdf");
    }
}
