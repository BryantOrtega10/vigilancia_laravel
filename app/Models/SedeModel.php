<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SedeModel extends Model
{
    protected $table = "sede";

    protected $fillable = [
        "nombre",
        "direccion",
        "telefono",
        "contacto",
        "correo",
        "fk_tipo_sede"
    ];

    public function tipo_sede(){
        return $this->belongsTo(TipoSedeModel::class,'fk_tipo_sede','id');
    }

}
