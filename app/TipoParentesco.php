<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoParentesco extends Model
{
    protected $table = "tipo_parentesco";
    protected $fillable = [
        "nombre",
        "campo",
        "estado",
    ];
}
