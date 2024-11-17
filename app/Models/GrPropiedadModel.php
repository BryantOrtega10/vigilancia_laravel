<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrPropiedadModel extends Model
{
    protected $table = "gr_propiedad";

    protected $fillable = [
        "nombre",
        "fk_tipo_gr_propiedad",
        "fk_sede"
    ];

    public function sede(){
        return $this->belongsTo(SedeModel::class,'fk_sede','id');
    }

    public function tipo_gr_propiedad(){
        return $this->belongsTo(TipoGrPropiedadModel::class,'fk_tipo_gr_propiedad','id');
    }

    public function propiedades(){
        return $this->hasMany(PropiedadModel::class,'fk_gr_propiedad','id');
    }
    
}
