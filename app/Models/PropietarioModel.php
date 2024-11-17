<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropietarioModel extends Model
{
    protected $table = "propietario";

    protected $fillable = [
        'nombres',
        'apellidos',
        'celular_p',
        'celular_s',
        'email',     
    ];    

}
