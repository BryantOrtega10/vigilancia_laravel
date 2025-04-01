<?php

namespace App\Http\Controllers;

use App\Http\Requests\Riesgos\ActualizarRiesgoRequest;
use App\Http\Requests\Riesgos\MatrizRequest;
use App\Models\RiesgoLogModel;
use App\Models\RiesgoModel;
use App\Models\SedeModel;
use Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class RiesgosController extends Controller
{
    public function mostrarTabla(Request $request)
    {        
        $riesgos = RiesgoModel::select("riesgo.*");
        if($request->has("inactivos") && $request->input("inactivos") == 1){
            $riesgos = $riesgos->whereIn("estado",[1,0]);
        }
        else{
            $riesgos = $riesgos->where("estado","=",1);
        }
        $riesgos = $riesgos->orderBy("updated_at","DESC")->get();

        return view('riesgos.tabla', [
            'riesgos' => $riesgos
        ]);
    }

    public function verDetalles($id){
        $riesgo = RiesgoModel::find($id);
        $logs = RiesgoLogModel::where("fk_riesgo","=",$id)->take(5)->orderBy("id","desc")->get();
        return view('riesgos.verDetalle', [
            'logs' => $logs,
            'riesgo' => $riesgo
        ]);
    }

    public function actualizar($id, ActualizarRiesgoRequest $request){
        $usuario = Auth::user();

        $riesgo = RiesgoModel::find($id);
        $descripcion = "";
        if($riesgo->descripcion != $request->input("descripcion")){
            $descripcion = $request->input("descripcion");
            $riesgo->descripcion = $descripcion;
        } 
        $riesgo->probabilidad = $request->input("probabilidad");
        $riesgo->impacto = $request->input("impacto");
        $riesgo->estado = $request->input("estado");
        $riesgo->save();


        $riesgo_log = new RiesgoLogModel();
        $riesgo_log->descripcion =  $descripcion;
        $riesgo_log->probabilidad = $request->input("probabilidad");
        $riesgo_log->impacto = $request->input("impacto");
        $riesgo_log->estado = $request->input("estado");
        $riesgo_log->fk_user = $usuario->id;
        $riesgo_log->fk_riesgo = $id;        
        $riesgo_log->save();      

        return redirect(route('riesgos.tabla'))->with('mensaje', 'Actualización del riesgo registrada correctamente');
    }
    
    public function mostrarFormMatriz(){
        $sedes = SedeModel::orderBy("nombre")->get();

        return view('riesgos.matriz', [
            'sedes' => $sedes
        ]);
    }


    public function generarPdfMatriz(MatrizRequest $request){
        $riesgos = RiesgoModel::where('fk_sede',"=",$request->input("sede"))->orderBy("impacto","desc")->get();
        $sede = SedeModel::find($request->input("sede"));

        $pdf = Pdf::loadView('riesgos.pdf', [
            'riesgos' => $riesgos,
            'sede' => $sede
        ])
        ->setPaper('A4');
        //$pdf->render();
        return $pdf->download("Matriz riesgos ".$sede->nombre." - ".date("Y_m_d H_i").".pdf");
    }
    
}
