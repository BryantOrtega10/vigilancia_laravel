<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecorridoModel extends Model
{
    protected $table = "recorrido";

    protected $fillable = [
        "fecha_hora",
        "fk_user",
        "fk_ronda",
    ];

    public function user(){
        return $this->belongsTo(User::class,'fk_user','id');
    }

    public function ronda(){
        return $this->belongsTo(RondaModel::class,'fk_ronda','id');
    }



    
}
