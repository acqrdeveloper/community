<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoUsuario extends Model
{
    protected $table = "tipo_usuario";
    protected $fillable = [
        "id",
        "nombre",
        "campo",
        "estado",
    ];
}
