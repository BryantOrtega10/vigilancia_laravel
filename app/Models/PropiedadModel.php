<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropiedadModel extends Model
{
    //
    protected $table = "propiedad";

    protected $fillable = [
        'nombre',
        'fk_propietario',
        'fk_gr_propiedad',   
    ];    
    
    public function propietario(){
        return $this->belongsTo(PropietarioModel::class,'fk_propietario','id');
    }

    public function gr_propiedad(){
        return $this->belongsTo(GrPropiedadModel::class,'fk_gr_propiedad','id');
    }


}
