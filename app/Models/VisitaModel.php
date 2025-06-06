<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitaModel extends Model
{
    protected $table = "visita";

    protected $fillable = [
        "fecha_entrada",
        "fecha_salida",
        "documento",
        "nombre",
        "observacion",
        "observacion_salida",
        "responsable",
        "manejo_datos",
        "placa",
        "fk_tipo_vehiculo",
        "fk_propiedad",
        "fk_user_entrada",
        "fk_user_salida",   
    ];

    public function tipo_vehiculo(){
        return $this->belongsTo(TipoVehiculoModel::class,'fk_tipo_vehiculo','id');
    }

    public function propiedad(){
        return $this->belongsTo(PropiedadModel::class,'fk_propiedad','id');
    }

    public function user_entrada(){
        return $this->belongsTo(User::class,'fk_user_entrada','id');
    }

    public function user_salida(){
        return $this->belongsTo(User::class,'fk_user_salida','id');
    }

    public function fotos(){
        return $this->hasMany(FotoModel::class, "fk_visita","id");
    }
}
