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
        "placa",
        "fk_tipo_vehiculo",
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

    public function tipo_vehiculo(){
        return $this->belongsTo(TipoVehiculoModel::class,'fk_tipo_vehiculo','id');
    }

    public function sede_txt(){
        if($this->fk_vehiculo != null){
            $propiedad = $this->vehiculo->propiedad;            
            return $propiedad->gr_propiedad->sede->nombre;
        }
        else if($this->fk_visita != null){
            $propiedad = $this->visita->propiedad;
            return $propiedad->gr_propiedad->sede->nombre;
        }
        else{
            return "";
        }
    }

    public function tipo_veh_txt(){
        if($this->fk_vehiculo != null){
            return $this->vehiculo->tipo_vehiculo->nombre;
        }
        else if($this->fk_visita != null){
            return $this->visita->tipo_vehiculo->nombre;
        }       
        else {
            return $this->tipo_vehiculo->nombre;
        }       
    }

    public function placa_txt(){
        if($this->fk_vehiculo != null){
            return $this->vehiculo->placa;
        }
        else if($this->fk_visita != null){
            return $this->visita->placa;
        }  
        else{
            return $this->placa;
        }        
    }
}
