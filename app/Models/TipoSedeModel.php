<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoSedeModel extends Model
{
    protected $table = "tipo_sede";

    protected $fillable = [
        'nombre',        
    ];
}
