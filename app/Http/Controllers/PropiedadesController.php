<?php

namespace App\Http\Controllers;

use App\Http\Requests\Propiedad\GrupoPropiedadRequest;
use App\Http\Requests\Propiedad\ItemRequest;
use App\Http\Requests\Propiedad\PropiedadRequest;
use App\Models\GrPropiedadModel;
use App\Models\PaqueteModel;
use App\Models\PropiedadModel;
use App\Models\PropietarioModel;
use App\Models\SedeModel;
use App\Models\TipoGrPropiedadModel;
use App\Models\TipoSedeModel;
use App\Models\VehiculoModel;
use App\Models\VisitaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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
}
