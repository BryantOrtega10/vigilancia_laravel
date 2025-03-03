<?php

namespace App\Http\Controllers;

use App\Http\Requests\Propiedad\GrupoPropiedadRequest;
use App\Http\Requests\Propiedad\ItemRequest;
use App\Http\Requests\Propiedad\PropiedadRequest;
use App\Http\Utils\Funciones;
use App\Models\GrPropiedadModel;
use App\Models\PaqueteModel;
use App\Models\PropiedadModel;
use App\Models\PropietarioModel;
use App\Models\SedeModel;
use App\Models\TipoGrPropiedadModel;
use App\Models\TipoSedeModel;
use App\Models\VehiculoModel;
use App\Models\VisitaModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;

class PropiedadesController extends Controller
{
    public function mostrarTabla()
    {
        $sedes = SedeModel::orderBy("nombre")->get();
        return view('propiedad.tabla', [
            'sedes' => $sedes
        ]);
    }
    public function mostrarAgregar()
    {
        $tipos_propiedad = TipoSedeModel::orderBy("nombre")->get();
        return view('propiedad.agregar', [
            'tipos_propiedad' => $tipos_propiedad
        ]);
    }
    public function agregar(PropiedadRequest $request)
    {
        $sede = new SedeModel();
        $sede->nombre = $request->input("nombre");
        $sede->direccion = $request->input("direccion");
        $sede->telefono = $request->input("telefono");
        $sede->contacto = $request->input("contacto");
        $sede->correo = $request->input("correo");
        $sede->fk_tipo_sede = $request->input("tipo_propiedad");
        $sede->save();

        return redirect(route('propiedad.tabla'))->with('mensaje', 'Propiedad agregada correctamente');
    }

    public function mostrarModificar($id)
    {

        $sede = SedeModel::findOrFail($id);
        $tipos_propiedad = TipoSedeModel::orderBy("nombre")->get();

        return view('propiedad.modificar', [
            'sede' => $sede,
            'tipos_propiedad' => $tipos_propiedad
        ]);
    }
    public function modificar($id, PropiedadRequest $request)
    {

        $sede = SedeModel::find($id);
        $sede->nombre = $request->input("nombre");
        $sede->direccion = $request->input("direccion");
        $sede->telefono = $request->input("telefono");
        $sede->contacto = $request->input("contacto");
        $sede->correo = $request->input("correo");
        $sede->fk_tipo_sede = $request->input("tipo_propiedad");
        $sede->save();

        return redirect(route('propiedad.tabla'))->with('mensaje', 'Propiedad modificada correctamente');
    }

    public function eliminar($id)
    {
        $sede = SedeModel::findOrFail($id);
        $sedePropiedad = GrPropiedadModel::where("fk_sede", "=", $sede->id)->count();
        if ($sedePropiedad > 0) {
            return redirect(route('propiedad.tabla'))->with('error', 'Esta propiedad ya tiene grupos asignados');
        }

        $sede->delete();

        return redirect(route('propiedad.tabla'))->with('mensaje', 'Propiedad eliminada correctamente');
    }

    public function mostrarConfig($id)
    {

        $sede = SedeModel::findOrFail($id);
        $grupos = GrPropiedadModel::where("fk_sede", "=", $id)->orderBy("nombre")->get();
        return view('propiedad.config', [
            'sede' => $sede,
            'grupos' => $grupos
        ]);
    }

    public function mostrarAgregarGrupo($id)
    {
        $sede = SedeModel::findOrFail($id);
        $tipos_grupo = TipoGrPropiedadModel::orderBy("nombre")->get();

        return view('propiedad.grupo.agregar', [
            'sede' => $sede,
            'tipos_grupo' => $tipos_grupo
        ]);
    }

    public function agregarGrupo($id, GrupoPropiedadRequest $request)
    {
        $grupo = new GrPropiedadModel();
        $grupo->nombre = $request->input("nombre");
        $grupo->fk_tipo_gr_propiedad = $request->input("tipo_grupo");
        $grupo->fk_sede = $id;
        $grupo->save();

        return redirect(route('propiedad.config', ['id' => $id]))->with('mensaje', 'Grupo de propiedades agregado correctamente');
    }


    public function mostrarModificarGrupo($id)
    {
        $grupo = GrPropiedadModel::findOrFail($id);
        $sede = $grupo->sede;
        $tipos_grupo = TipoGrPropiedadModel::orderBy("nombre")->get();

        return view('propiedad.grupo.modificar', [
            'sede' => $sede,
            'tipos_grupo' => $tipos_grupo,
            'grupo' => $grupo
        ]);
    }

    public function modificarGrupo($id, GrupoPropiedadRequest $request)
    {
        $grupo = GrPropiedadModel::findOrFail($id);
        $grupo->nombre = $request->input("nombre");
        $grupo->fk_tipo_gr_propiedad = $request->input("tipo_grupo");
        $grupo->save();

        return redirect(route('propiedad.config', ['id' => $grupo->fk_sede]))->with('mensaje', 'Grupo de propiedades modificado correctamente');
    }
    
    public function eliminarGrupo($id)
    {
        $grupo = GrPropiedadModel::findOrFail($id);
        $propiedades = PropiedadModel::where("fk_gr_propiedad", "=", $grupo->id)->count();
        if ($propiedades > 0) {
            return redirect(route('propiedad.config'))->with('error', 'Grupo de propiedades ya tiene propiedades eliminalas para poder eliminar este grupo');
        }
        $fk_sede = $grupo->fk_sede;
        $grupo->delete();

        return redirect(route('propiedad.config', ['id' => $fk_sede]))->with('mensaje', 'Grupo de propiedades eliminada correctamente');
    }
    
    public function mostrarAgregarItem($id)
    {
        $grupo = GrPropiedadModel::findOrFail($id);
        $sede = $grupo->sede;

        $ultimaPropiedad = PropiedadModel::where("fk_gr_propiedad", "=", $id)->orderBy(DB::raw("CAST(nombre as signed)"), "desc")->first();
        if (!isset($ultimaPropiedad)) {
            $nombre_predeterminado = 1;
        } else {
            $nombre_predeterminado = $ultimaPropiedad->nombre + 1;
        }
        $errors = Session::get('errors');
        $vehiculos = 0;
        if (isset($errors)) {
            $olds = Session::getOldInput();
            $vehiculos = sizeof($olds['vehiculo']);
        }


        return view('propiedad.item.agregar', [
            'sede' => $sede,
            'grupo' => $grupo,
            'nombre_predeterminado' => $nombre_predeterminado,
            'vehiculos' => $vehiculos
        ]);
    }


    public function agregarItem($id, ItemRequest $request)
    {

        if ($request->input('nombres') != "" && $request->input('apellidos') != "") {
            $propietario = new PropietarioModel();
            $propietario->nombres = $request->input('nombres');
            $propietario->apellidos = $request->input('apellidos');
            $propietario->celular_p = $request->input('celular_p');
            $propietario->celular_s = $request->input('celular_s');
            $propietario->email = $request->input('email');
            $propietario->save();
        }


        $propiedad = new PropiedadModel();
        $propiedad->nombre = $request->input('nombre');
        if (isset($propietario)) {
            $propiedad->fk_propietario = $propietario->id;
        }
        $propiedad->fk_gr_propiedad = $id;
        $propiedad->save();
        if($request->input("vehiculo") != null){
            foreach ($request->input("vehiculo") as $row => $input_vehiculo) {
                if ($input_vehiculo != "") {
                    $vehiculo = new VehiculoModel();
                    $vehiculo->placa = $input_vehiculo;
                    $vehiculo->fk_propiedad = $propiedad->id;
                    $vehiculo->fk_tipo_vehiculo = $request->input("tipo_vehiculo")[$row];
                    $vehiculo->save();
                }
            }
        }
        $id_sede = $propiedad->gr_propiedad->fk_sede;
        return redirect(route('propiedad.config', ['id' => $id_sede]))->with('mensaje', 'Propiedad agregada correctamente');
    }

    public function mostrarModificarItem($id)
    {
        $propiedad = PropiedadModel::findOrFail($id);
        $grupo = $propiedad->gr_propiedad;
        $sede = $grupo->sede;
        $propietario = $propiedad->propietario;
        $vehiculos = VehiculoModel::where("fk_propiedad","=",$id)->get();

        return view('propiedad.item.modificar', [
            'sede' => $sede,
            'grupo' => $grupo,
            'propiedad' => $propiedad,
            'propietario' => $propietario,
            'vehiculos' => $vehiculos
        ]);
    }

    public function modificarItem($id, ItemRequest $request)
    {
        $propiedad = PropiedadModel::findOrFail($id);
        
        if ($request->input('nombres') != "" && $request->input('apellidos') != "") {
            if(isset($propiedad->propietario)){
                $propietario = $propiedad->propietario;
            }
            else{
                $propietario = new PropietarioModel();
            }
            
            $propietario->nombres = $request->input('nombres');
            $propietario->apellidos = $request->input('apellidos');
            $propietario->celular_p = $request->input('celular_p');
            $propietario->celular_s = $request->input('celular_s');
            $propietario->email = $request->input('email');
            $propietario->save();
        }
        $propiedad->nombre = $request->input('nombre');
        if (isset($propietario)) {
            $propiedad->fk_propietario = $propietario->id;
        }
        $propiedad->save();


        //Verificar vehiculos eliminados
        if($request->input("vehiculo") != null){
            VehiculoModel::where("fk_propiedad","=",$id)
                ->whereNotIn("placa",$request->input("vehiculo"))
                ->delete();
        }
        else{
            VehiculoModel::where("fk_propiedad","=",$id)
                ->delete();
        }

        if($request->input("vehiculo") != null){
            foreach ($request->input("vehiculo") as $row => $input_vehiculo) {
                if ($input_vehiculo != "") {
                    $vehiculo = VehiculoModel::where("fk_propiedad","=",$id)->where("placa","=",$input_vehiculo)->first();
                    if(!isset($vehiculo)){
                        $vehiculo = new VehiculoModel();
                    }
                    $vehiculo->placa = $input_vehiculo;
                    $vehiculo->fk_propiedad = $propiedad->id;
                    $vehiculo->fk_tipo_vehiculo = $request->input("tipo_vehiculo")[$row];
                    $vehiculo->save();
                }
            }
        }
        
        $id_sede = $propiedad->gr_propiedad->fk_sede;
        return redirect(route('propiedad.config', ['id' => $id_sede]))->with('mensaje', 'Propiedad modificada correctamente');
    }

    public function eliminarItem($id)
    {
        $propiedad = PropiedadModel::findOrFail($id);

        $visitas = VisitaModel::where("fk_propiedad", "=", $propiedad->id)->count();
        if ($visitas > 0) {
            return redirect(route('propiedad.config'))->with('error', 'La propiedad ya tiene datos asociados, si desea eliminarla contacte con el administrador');
        }
        $paquetes = PaqueteModel::where("fk_propiedad", "=", $propiedad->id)->count();
        if ($paquetes > 0) {
            return redirect(route('propiedad.config'))->with('error', 'La propiedad ya tiene datos asociados, si desea eliminarla contacte con el administrador');
        }        
        $fk_sede = $propiedad->gr_propiedad->fk_sede;
        PropietarioModel::where("id","=",$propiedad->fk_propietario)->delete();
        $propiedad->delete();

        return redirect(route('propiedad.config', ['id' => $fk_sede]))->with('mensaje', 'Propiedad eliminada correctamente');
    }

    public function subirCSV(Request $request){
        $errors = array();
        $folder = "csv/";
        $file_name =  time() . "_.csv";
        Funciones::subirBase64($request->file64, $folder . $file_name);
        $contents = Storage::disk('public')->get($folder . $file_name);
        $reader = Reader::createFromString($contents);
        $reader->setDelimiter(',');
        $cuentaSubidos = 0;
        foreach ($reader as $index => $row) {
            try {
                // Verificar si tiene puntos y coma para que re haga la columna
                if (strpos($row[0], ";") !== false) {
                    $row = explode(";", $row[0]);
                }

                if ($index == 0 && strtolower($row[0]) !== "sede") {
                    /* Validamos que tenga las cabeceras */
                    return response()->json([
                        "success" => false,
                        "message" => "Agrege los titulos al archivo"
                    ]);
                } else if ($index == 0) {
                    /* Si tiene cabeceras las omitimos y continuamos con la data */
                    continue;
                }
                $tiene_texto = false;
                foreach ($row as $key => $valor) {
                    if ($valor == "") {
                        $row[$key] = null;
                    } else {
                        $tiene_texto = true;
                        $row[$key] = trim(utf8_encode($row[$key]));
                    }
                }

                if (!$tiene_texto) {
                    continue;
                }

                //0 = sede
                //1 = grupo
                //2 = propiedad
                //3 = nombres propietario
                //4 = apellidos propietario
                //5 = celular principal
                //6 = celular secundario
                //7 = email
                //8 = tipo_vehiculo1
                //9 = vehiculo1

                //Buscar Sede
                $sede = SedeModel::where("nombre","like",trim($row[0]))->first();
                if(!isset($sede)){
                    array_push($errors, "Sede no encontrada en la linea " . ($index + 1));
                    continue;
                }

                $grupo = GrPropiedadModel::where("nombre","like",trim($row[1]))->where("fk_sede","=",$sede->id)->first();
                if(!isset($grupo)){
                    $grupo = new GrPropiedadModel();
                    $grupo->nombre = trim($row[1]);
                    $grupo->fk_sede = $sede->id;
                    $grupo->save();
                }

                $propiedadVerif = PropiedadModel::where("nombre","like",trim($row[2]))->where("fk_gr_propiedad","=",$grupo->id)->first();
                if(isset($propiedadVerif)){
                    array_push($errors, "Ya existe la propiedad ".$row[2]." en la linea " . ($index + 1));
                    continue;
                }

                $propietario = new PropietarioModel();
                $propietario->nombres = trim($row[3]);
                $propietario->apellidos = trim($row[4]);
                $propietario->celular_p = trim($row[5]);
                $propietario->celular_s = trim($row[6]);
                $propietario->email = trim($row[7]);
                $propietario->save();
                
                
                $propiedad = new PropiedadModel();
                $propiedad->nombre = trim($row[2]);
                $propiedad->fk_propietario = $propietario->id;
                $propiedad->fk_gr_propiedad = $grupo->id;
                $propiedad->save();

                
                for($i=8; $i<=100; $i=$i+2){
                    if(!isset($row[$i]) || !isset($row[$i + 1])){
                        break;
                    }

                    $tipo_vehiculo = $row[$i];
                    $placa = $row[$i + 1];
                    $vehiculo = new VehiculoModel();
                    $vehiculo->placa = $placa;
                    $vehiculo->fk_propiedad = $propiedad->id;
                    $vehiculo->fk_tipo_vehiculo = $tipo_vehiculo;
                    $vehiculo->save();
                }
                $cuentaSubidos++;
                //Cargar propiedades
                

            }
            catch (Exception $e) {
                array_push($errors, "Error " . $e->getMessage() . ", line: " . $e->getLine() . " on row " . ($index + 1));
            }
        }
        if (sizeof($errors) > 0) {
            return response()->json([
                "success" => false,
                "message" => implode("<br>", $errors)
            ]);
        } else {
            return response()->json([
                "success" => true,
                "message" => "Propiedades agregadas!, ".$cuentaSubidos." registros agregados"
            ]);
        }
        
    }
}
