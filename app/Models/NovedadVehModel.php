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
    
}
