<?php

namespace App\Http\Controllers;

use App\Http\Requests\Usuarios\UsuariosRequest;
use App\Models\MinutaModel;
use App\Models\NovedadVehModel;
use App\Models\PaqueteModel;
use App\Models\RecorridoModel;
use App\Models\SedeModel;
use App\Models\User;
use App\Models\UserSedeModel;
use App\Models\VisitaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{
    public function mostrarTabla()
    {
        $usuarios = User::where('rol',"<>",'admin')->orderBy("name","DESC")->get();
        return view('usuarios.tabla', [
            'usuarios' => $usuarios
        ]);
    }

    public function mostrarAgregar()
    {
        $sedes = SedeModel::orderBy("nombre")->get();
        return view('usuarios.agregar', [
            'sedes' => $sedes
        ]);
    }

    public function agregar(UsuariosRequest $request)
    {
        $usuario = new User();
        $usuario->name = $request->input("nombre");
        $usuario->email = $request->input("email");
        $usuario->password = Hash::make($request->input("password"));
        $usuario->rol = 'vigilante';
        $usuario->save();

        if($request->input("propiedad") != null){
            foreach($request->input("propiedad") as $propiedad){
                if($propiedad != ""){
                    $userSede = UserSedeModel::where("fk_user","=",$usuario->id)
                                ->where("fk_sede","=",$propiedad)
                                ->first();
                    if(!isset($userSede)){
                        $nUserSede = new UserSedeModel();
                        $nUserSede->fk_user = $usuario->id;
                        $nUserSede->fk_sede = $propiedad;
                        $nUserSede->save();
                    }
                }
            }

        }

        return redirect(route('usuarios.tabla'))->with('mensaje', 'Usuario agregado correctamente');
    }

    public function mostrarModificar($id)
    {
        $sedes = SedeModel::orderBy("nombre")->get();
        $usuario = User::findOrFail($id);
        $usuarioSede = UserSedeModel::where("fk_user","=",$id)->get();

        return view('usuarios.modificar', [
            'sedes' => $sedes,
            'usuario' => $usuario,
            'usuarioSede' => $usuarioSede
        ]);
    }
    public function modificar($id, UsuariosRequest $request)
    {
        $usuario = User::findOrFail($id);
        $usuario->name = $request->input("nombre");
        $usuario->email = $request->input("email");
        if($request->input("password") != ""){
            $usuario->password = Hash::make($request->input("password"));
        }
        $usuario->save();

        if($request->input("propiedad") != null){
            UserSedeModel::where("fk_user","=",$usuario->id)
                ->whereNotIn("fk_sede",$request->input("propiedad"))
                ->delete();
        }
        else{
            UserSedeModel::where("fk_user","=",$usuario->id)->delete();
        }


        if($request->input("propiedad") != null){
            foreach($request->input("propiedad") as $propiedad){
                if($propiedad != ""){
                    $userSede = UserSedeModel::where("fk_user","=",$usuario->id)
                                ->where("fk_sede","=",$propiedad)
                                ->first();
                    if(!isset($userSede)){
                        $nUserSede = new UserSedeModel();
                        $nUserSede->fk_user = $usuario->id;
                        $nUserSede->fk_sede = $propiedad;
                        $nUserSede->save();
                    }
                }
            }

        }
        return redirect(route('usuarios.tabla'))->with('mensaje', 'Usuario modificado correctamente');

    }

    public function eliminar($id)
    {
        $usuario = User::findOrFail($id);
        $minutas = MinutaModel::where("fk_user", "=", $id)->count();
        if ($minutas > 0) {
            return redirect(route('usuarios.tabla'))->with('error', 'El usuario ya tiene información relacionada, no es posible eliminarlo');
        }

        $paquetes = PaqueteModel::where("fk_user_recibe", "=", $id)->orWhere("fk_user_entrega", "=", $id)->count();
        if ($paquetes > 0) {
            return redirect(route('usuarios.tabla'))->with('error', 'El usuario ya tiene información relacionada, no es posible eliminarlo');
        }

        $novedades = NovedadVehModel::where("fk_user", "=", $id)->count();
        if ($novedades > 0) {
            return redirect(route('usuarios.tabla'))->with('error', 'El usuario ya tiene información relacionada, no es posible eliminarlo');
        }

        $recorridos = RecorridoModel::where("fk_user", "=", $id)->count();
        if ($recorridos > 0) {
            return redirect(route('usuarios.tabla'))->with('error', 'El usuario ya tiene información relacionada, no es posible eliminarlo');
        }

        $visitas = VisitaModel::where("fk_user_entrada", "=", $id)->orWhere("fk_user_salida", "=", $id)->count();
        if ($visitas > 0) {
            return redirect(route('usuarios.tabla'))->with('error', 'El usuario ya tiene información relacionada, no es posible eliminarlo');
        }
      

        
        $usuario->delete();

        return redirect(route('usuarios.tabla'))->with('mensaje', 'Usuario eliminado correctamente');
    }
    
}
