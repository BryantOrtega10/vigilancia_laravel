<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoModel extends Model
{
    protected $table = "foto";

    protected $fillable = [
        "ruta",
        "fk_minuta",
        "fk_paquete",
        "fk_novedad_veh",
        "fk_riesgo_log",
    ];

    public function minuta(){
        return $this->belongsTo(User::class,'fk_minuta','id');
    }

    public function paquete(){
        return $this->belongsTo(User::class,'fk_paquete','id');
    }

    public function novedad_veh(){
        return $this->belongsTo(User::class,'fk_novedad_veh','id');
    }

    public function riesgo_log(){
        return $this->belongsTo(RiesgoLogModel::class,'fk_riesgo_log','id');
    }
        
}
