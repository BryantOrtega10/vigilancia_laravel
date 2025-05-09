<?php

namespace App\Http\Controllers;

use App\Http\Requests\Buzon\ValidarRequest;
use App\Models\FotoModel;
use App\Models\PaqueteModel;
use App\Models\SedeModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class BuzonController extends Controller
{
    public function mostrarTabla()
    {
        $usuario = Auth::user();
        if ($usuario->rol == "admin") {
            $paquetes = PaqueteModel::orderBy("entregado","ASC")->orderBy("fecha_recepcion","DESC")->get();
        }
        else{
            $paquetes = PaqueteModel::select("paquete.*")
                                  ->join("propiedad","propiedad.id","=","paquete.fk_propiedad")
                                  ->join("gr_propiedad","gr_propiedad.id","=","propiedad.fk_gr_propiedad")
                                  ->join("users_sede as us", "us.fk_sede", "=", "gr_propiedad.fk_sede")
                                  ->where("us.fk_user", "=", $usuario->id)
                                  ->orderBy("paquete.fecha_recepcion","DESC")
                                  ->get();
        }

        return view('paquetes.tabla', [
            'paquetes' => $paquetes
        ]);
    }
    
    public function verDetalles($id){
        $paquete = PaqueteModel::findOrFail($id);  
        $grupo = $paquete->propiedad->gr_propiedad;
        if(!$this->validarSede($grupo->fk_sede)){
            return redirect(route('propiedad.tabla'))->with('error', 'Esta sede no esta asignada a tu usuario');
        }
        $fotos = FotoModel::where("fk_paquete","=",$id)->get();
        $html = view('paquetes.detalle',[
            'paquete' => $paquete,
            'fotos' => $fotos
        ])->render();
        return response()->json([
            "success" => true,
            "html" => $html
        ]);
    }

    public function generarPdf($id){
        $paquete = PaqueteModel::findOrFail($id);
        $grupo = $paquete->propiedad->gr_propiedad;
        if(!$this->validarSede($grupo->fk_sede)){
            return redirect(route('propiedad.tabla'))->with('error', 'Esta sede no esta asignada a tu usuario');
        }

        $fotos = FotoModel::where("fk_paquete","=",$id)->get();

        foreach($fotos as $foto){
            $path = 'paquetes/max_'.$foto->ruta;
            if (!Storage::disk('public')->exists($path)) {
                return response()->json(['error' => 'Archivo no encontrado'], 404);
            }
            $imagen = Storage::disk('public')->get($path);
            $base64Img = base64_encode($imagen);
            $foto->img_base64 = $base64Img;
        }

        $pdf = Pdf::loadView('paquetes.pdf', [
            'paquete' => $paquete,
            'fotos' => $fotos
        ])
        ->setPaper('A4');
        
        return $pdf->download("Paquete ".$paquete->id." en ".$paquete->propiedad->gr_propiedad->sede->nombre.".pdf");
    }

    public function mostrarValidar($id){
        $paquete = PaqueteModel::findOrFail($id);
        $grupo = $paquete->propiedad->gr_propiedad;
        if(!$this->validarSede($grupo->fk_sede)){
            return redirect(route('propiedad.tabla'))->with('error', 'Esta sede no esta asignada a tu usuario');
        }
        return view('paquetes.validar', [
            'paquete' => $paquete
        ]);
    }

    public function validar($id, ValidarRequest $request){
        $paquete = PaqueteModel::findOrFail($id);
        $grupo = $paquete->propiedad->gr_propiedad;
        if(!$this->validarSede($grupo->fk_sede)){
            return redirect(route('propiedad.tabla'))->with('error', 'Esta sede no esta asignada a tu usuario');
        }
        
        if(trim($request->input("codigo")) != $paquete->codigo){
            return throw ValidationException::withMessages(['codigo' => 'El codigo no coincide con el enviado']);
        }

        $paquete->fecha_entrega = $request->input("fecha_entrega")." ".$request->input("hora_entrega");
        $paquete->entregado = 1;
        $paquete->fk_user_entrega = Auth::user()->id;
        $paquete->save();

        return redirect(route('paquetes.tabla'))->with('mensaje', 'La entrega ha sido validada correctamente');
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
