<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NovedadVehModel extends Model
{
    protected $table = "novedad_veh";

    protected $fillable = [
        "fecha_hora",
        "observacion",
        "fk_vehiculo",
        "fk_visita",
        "fk_user",
    ];

    public function vehiculo(){
        return $this->belongsTo(VehiculoModel::class,'fk_vehiculo','id');
    }

    public function visita(){
        return $this->belongsTo(VisitaModel::class,'fk_visita','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'fk_user','id');
    }

    public function sede_txt(){
        if($this->fk_vehiculo != null){
            $propiedad = $this->vehiculo->propiedad;            
        }
        else{
            $propiedad = $this->visita->propiedad;
        }
        return $propiedad->gr_propiedad->sede->nombre;
    }

    public function tipo_veh_txt(){
        if($this->fk_vehiculo != null){
            return $this->vehiculo->tipo_vehiculo->nombre;
        }
        else{
            return $this->visita->tipo_vehiculo->nombre;
        }        
    }

    public function placa_txt(){
        if($this->fk_vehiculo != null){
            return $this->vehiculo->placa;
        }
        else{
            return $this->visita->placa;
        }        
    }
}
