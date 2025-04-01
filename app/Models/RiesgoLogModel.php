<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class RiesgoLogModel extends Model
{
    protected $table = "riesgo_log";
        
    protected $fillable = [
        "descripcion",
        "probabilidad",
        "impacto",
        "estado",
        "fk_riesgo",
        "fk_user",
    ];

    public function riesgo(){
        return $this->belongsTo(RiesgoModel::class,'fk_riesgo','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'fk_user','id');
    }

    public function fotos(){
        return $this->hasMany(FotoModel::class, "fk_riesgo_log","id");
    }

    public function txtEstado(): Attribute {
        return Attribute::make(
            get: fn () => [0 => "Oculto", 1 => "Visible"][$this->estado]
        );
    }

    public function txtImpacto(): Attribute {
        return Attribute::make(
            get: function () {
                if(!isset($value)){
                    return "No configurado";
                }
                return ["No configurado", "Bajo", "Medio", "Alto"][$this->impacto];
            }
        );
    }
}
