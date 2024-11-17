<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RondaModel extends Model
{
    protected $table = "ronda";

    protected $fillable = [
        "nombre",
        "codigo_qr",
        "fk_sede",
    ];

    public function sede(){
        return $this->belongsTo(SedeModel::class,'fk_sede','id');
    }
}
