<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoVehiculoModel extends Model
{
    protected $table = "tipo_vehiculo";

    protected $fillable = [
        'nombre',        
    ];
}
