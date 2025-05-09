<?php

namespace App\Http\Controllers;

use App\Http\Requests\Rondas\RondasRequest;
use App\Models\RecorridoModel;
use App\Models\RondaModel;
use App\Models\SedeModel;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RondasController extends Controller
{
    public function mostrarTablaRecorridos()
    {
        $usuario = Auth::user();
        if ($usuario->rol == "admin") {
            $recorridos = RecorridoModel::orderBy("fecha_hora","DESC")->get();
        }
        else{
            $recorridos = RecorridoModel::select("recorrido.*")
                                        ->join("ronda", "ronda.id", "=", "recorrido.fk_ronda")
                                        ->join("sede", "sede.id", "=", "ronda.fk_sede")
                                        ->join("users_sede as us", "us.fk_sede", "=", "sede.id")
                                        ->where("us.fk_user", "=", $usuario->id)
                                        ->orderBy("recorrido.fecha_hora","DESC")
                                        ->get();
        }
        return view('rondas.tabla', [
            'recorridos' => $recorridos
        ]);
    }
    
    public function verRecorrido($idRecorrido)
    {
        $recorrido = RecorridoModel::findOrFail($idRecorrido);
        if(!$this->validarSede($recorrido->ronda->fk_sede)){
            return redirect(route('propiedad.tabla'))->with('error', 'Esta sede no esta asignada a tu usuario');
        }
        $builder = new Builder(
            data: $recorrido->ronda->codigo_qr,
            encoding: new Encoding('UTF-8'),
        );
        $result = $builder->build();
        $qrImage = $result->getString();
        $base64Qr = base64_encode($qrImage);

        return response()->json([
            "success" => true,
            "qrBase64" => $base64Qr
        ]);
    }

    public function eliminarRecorrido($idRecorrido)
    {
        $recorrido = RecorridoModel::findOrFail($idRecorrido);
        if(!$this->validarSede($recorrido->ronda->fk_sede)){
            return redirect(route('propiedad.tabla'))->with('error', 'Esta sede no esta asignada a tu usuario');
        }
        $recorrido->delete();

        return redirect(route('rondas.tablaRecorridos'))->with('mensaje', 'Recorrido eliminado correctamente');
    }


    public function mostrarQRs(Request $request)
    {
        $usuario = Auth::user();
        if ($usuario->rol == "admin") {
            $rondas = RondaModel::select("ronda.*");
            if($request->input("sede") != null){
                $rondas->where("fk_sede","=",$request->input("sede"));
            }
            $rondas = $rondas->orderBy("nombre","ASC")->get();
        }
        else{
            $rondas = RondaModel::select("ronda.*")
                                ->join("sede", "sede.id", "=", "ronda.fk_sede")
                                ->join("users_sede as us", "us.fk_sede", "=", "sede.id")
                                ->where("us.fk_user", "=", $usuario->id);

            if($request->input("sede") != null){
                $rondas->where("fk_sede","=",$request->input("sede"));
            }
            $rondas = $rondas->orderBy("nombre","ASC")->get();
        }

        

        foreach($rondas as $ronda){
            $builder = new Builder(
                data: $ronda->codigo_qr,
                encoding: new Encoding('UTF-8'),
            );
            $result = $builder->build();
            $qrImage = $result->getString();
            $base64Qr = base64_encode($qrImage);
            $ronda->img_qr = $base64Qr;
        }


        $sedes = SedeModel::orderBy("nombre","ASC")->get();
        return view('rondas.verQRs', [
            'rondas' => $rondas,
            "sedes" => $sedes
        ]);
    }
    public function mostrarAgregar()
    {
        $usuario = Auth::user();
        if ($usuario->rol == "admin") {
            $sedes = SedeModel::orderBy("nombre")->get();
        }
        else{
            $sedes = SedeModel::select("sede.*")
            ->join("users_sede as us", "us.fk_sede", "=", "sede.id")
            ->where("us.fk_user", "=", $usuario->id)
            ->orderBy("sede.nombre")
            ->get();
        }

        return view('rondas.agregar', [
            'sedes' => $sedes
        ]);
    }
    public function agregar(RondasRequest $request)
    {
        $ronda = new RondaModel();
        $ronda->nombre = $request->input("nombre");
        $ronda->codigo_qr = password_hash(uniqid($request->input("sede")."_", true), PASSWORD_BCRYPT);
        $ronda->fk_sede = $request->input("sede");
        $ronda->save();

        return redirect(route('rondas.vistaQRs'))->with('mensaje', 'Ronda agregada correctamente');
    }

    public function mostrarModificar($idRonda)
    {
        $ronda = RondaModel::findOrFail($idRonda);
        if(!$this->validarSede($ronda->fk_sede)){
            return redirect(route('propiedad.tabla'))->with('error', 'Esta sede no esta asignada a tu usuario');
        }
        $usuario = Auth::user();
        if ($usuario->rol == "admin") {
            $sedes = SedeModel::orderBy("nombre")->get();
        }
        else{
            $sedes = SedeModel::select("sede.*")
            ->join("users_sede as us", "us.fk_sede", "=", "sede.id")
            ->where("us.fk_user", "=", $usuario->id)
            ->orderBy("sede.nombre")
            ->get();
        }

        return view('rondas.modificar', [
            'sedes' => $sedes,
            'ronda' => $ronda
        ]);
    }
    public function modificar($idRonda, RondasRequest $request)
    {

        $ronda = RondaModel::findOrFail($idRonda);
        if(!$this->validarSede($ronda->fk_sede)){
            return redirect(route('propiedad.tabla'))->with('error', 'Esta sede no esta asignada a tu usuario');
        }
        $ronda->nombre = $request->input("nombre");
        $ronda->save();

        return redirect(route('rondas.vistaQRs'))->with('mensaje', 'Ronda modificada correctamente');
    }

    public function eliminar($idRonda)
    {
        $ronda = RondaModel::findOrFail($idRonda);
        if(!$this->validarSede($ronda->fk_sede)){
            return redirect(route('propiedad.tabla'))->with('error', 'Esta sede no esta asignada a tu usuario');
        }
        $recorridosRonda = RecorridoModel::where("fk_ronda", "=", $ronda->id)->count();
        if ($recorridosRonda > 0) {
            return redirect(route('rondas.vistaQRs'))->with('error', 'Ronda no puede ser eliminada ya tiene recorridos relacionados');
        }

        $ronda->delete();
        return redirect(route('rondas.vistaQRs'))->with('mensaje', 'Ronda eliminada correctamente');
    }
    
    public function descargarQR($idRonda)
    {
        $ronda = RondaModel::findOrFail($idRonda);
        if(!$this->validarSede($ronda->fk_sede)){
            return redirect(route('propiedad.tabla'))->with('error', 'Esta sede no esta asignada a tu usuario');
        }
        $builder = new Builder(
            data: $ronda->codigo_qr,
            encoding: new Encoding('UTF-8'),
        );

        $result = $builder->build();
        $qrImage = $result->getString();
        $fileName = "QR-".$ronda->nombre.".png";

        return response()->streamDownload(function () use ($qrImage) {
            echo $qrImage;
        }, $fileName, [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
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
