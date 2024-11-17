<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoGrPropiedadModel extends Model
{
    protected $table = "tipo_gr_propiedad";

    protected $fillable = [
        'nombre',        
    ];
}
