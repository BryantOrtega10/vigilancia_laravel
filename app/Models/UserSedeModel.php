<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSedeModel extends Model
{
    protected $table = "users_sede";

    protected $fillable = [
        'fk_user',  
        'fk_sede'      
    ];

    public function user(){
        return $this->belongsTo(User::class,'fk_user','id');
    }

    public function sede(){
        return $this->belongsTo(SedeModel::class,'fk_sede','id');
    }

}
