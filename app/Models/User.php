<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function user_sede(){
        return $this->hasMany(UserSedeModel::class, "fk_user","id");
    }

    public function txtRol() :Attribute {
        return Attribute::make(
            get: fn () => [
                "admin" => "Superadministrador",
                "vigilante" => "Vigilante",
                "admin_sede" => "Administrador de sede"
            ][$this->rol]
        );
    }

    public function sedes_txt(){
        $arr = array();
        if($this->user_sede == null){
            return '';
        }

        foreach($this->user_sede as $user_sede){
            array_push($arr, $user_sede->sede->nombre);
        }
        return implode(",",$arr);
    }
}
