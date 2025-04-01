<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResidenteModel extends Model
{
    protected $table = "residente";

    protected $fillable = [
        "nombre",
        "celular",
        "fk_propiedad",
    ];

    public function propiedad(){
        return $this->belongsTo(PropiedadModel::class,'fk_propiedad','id');
    }

}
