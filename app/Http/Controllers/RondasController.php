<?php

namespace App\Http\Controllers;

use App\Http\Requests\Rondas\RondasRequest;
use App\Models\RecorridoModel;
use App\Models\RondaModel;
use App\Models\SedeModel;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Illuminate\Http\Request;

class RondasController extends Controller
{
    public function mostrarTablaRecorridos()
    {
        $recorridos = RecorridoModel::orderBy("fecha_hora","DESC")->get();
        return view('rondas.tabla', [
            'recorridos' => $recorridos
        ]);
    }
    
    public function verRecorrido($idRecorrido)
    {
        $recorrido = RecorridoModel::findOrFail($idRecorrido);
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
        $recorrido->delete();

        return redirect(route('rondas.tablaRecorridos'))->with('mensaje', 'Recorrido eliminado correctamente');
    }


    public function mostrarQRs(Request $request)
    {
        $rondas = RondaModel::select("ronda.*");
        if($request->input("sede") != null){
            $rondas->where("fk_sede","=",$request->input("sede"));
        }
        $rondas = $rondas->orderBy("nombre","ASC")->get();

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
        $sedes = SedeModel::orderBy("nombre","ASC")->get();
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
        $sedes = SedeModel::orderBy("nombre","ASC")->get();

        return view('rondas.modificar', [
            'sedes' => $sedes,
            'ronda' => $ronda
        ]);
    }
    public function modificar($idRonda, RondasRequest $request)
    {

        $ronda = RondaModel::findOrFail($idRonda);
        $ronda->nombre = $request->input("nombre");
        $ronda->save();

        return redirect(route('rondas.vistaQRs'))->with('mensaje', 'Ronda modificada correctamente');
    }

    public function eliminar($idRonda)
    {
        $ronda = RondaModel::findOrFail($idRonda);
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

}
