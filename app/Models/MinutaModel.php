<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MinutaModel extends Model
{
    protected $table = "minuta";

    protected $fillable = [
        "fecha_reporte",
        "observacion",
        "fk_sede",
        "fk_user",
    ];

    public function sede(){
        return $this->belongsTo(SedeModel::class,'fk_sede','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'fk_user','id');
    }
}
