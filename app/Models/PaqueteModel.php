<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaqueteModel extends Model
{
    protected $table = "paquete";

    protected $fillable = [
        "observacion",
        "codigo",
        "entregado",
        "fk_propiedad",
        "fk_user_recibe",
        "fk_user_entrega",
    ];

    public function propiedad(){
        return $this->belongsTo(PropiedadModel::class,'fk_propiedad','id');
    }

    public function user_recibe(){
        return $this->belongsTo(User::class,'fk_user_recibe','id');
    }

    public function user_entrega(){
        return $this->belongsTo(User::class,'fk_user_entrega','id');
    }
    






}
