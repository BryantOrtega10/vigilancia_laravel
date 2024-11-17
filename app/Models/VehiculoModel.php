<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehiculoModel extends Model
{
    protected $table = "vehiculo";

    protected $fillable = [
        "placa",
        "fk_propiedad",
        "fk_tipo_vehiculo",
    ];

    public function propiedad(){
        return $this->belongsTo(PropiedadModel::class,'fk_propiedad','id');
    }

    public function tipo_vehiculo(){
        return $this->belongsTo(TipoVehiculoModel::class,'fk_tipo_vehiculo','id');
    }
}
