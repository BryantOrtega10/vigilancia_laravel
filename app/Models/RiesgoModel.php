<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class RiesgoModel extends Model
{
    protected $table = "riesgo";

    protected $fillable = [
        "probabilidad",
        "descripcion",
        "impacto",
        "estado",
        "fk_sede"
    ];

    public function sede(){
        return $this->belongsTo(SedeModel::class,'fk_sede','id');
    }

    public function logs(){
        return $this->hasMany(RiesgoLogModel::class, "fk_riesgo","id");
    }

    public function txtEstado(): Attribute {
        return Attribute::make(
            get: fn () => [0 => "Oculto", 1 => "Visible"][$this->estado]
        );
    }

    public function txtImpacto(): Attribute {
        return Attribute::make(
            get: function () {
                if(!isset($this->impacto)){
                    return "No configurado";
                }
                return ["No configurado", "Bajo", "Medio", "Alto"][$this->impacto];
            }
        );
    }

    protected $appends = ['txt_impacto','txt_estado'];
}
