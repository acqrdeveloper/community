<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "id_tipo_usuario",
        "id_parentesco",
        "nombres",
        "apellido_paterno",
        "apellido_materno",
        "imagen",
        "dni",
        "direccion",
        "telefono",
        "fecha_nacimiento",
        "fecha_fallecimiento",
        "edad",
        "es_empresa",
        "email",
        "sexo",
        "estado_civil",
        "estado",
        "remember_token",
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','decrypt',
    ];
}
