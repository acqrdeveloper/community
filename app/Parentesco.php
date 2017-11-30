<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parentesco extends Model
{
    protected $table = "parentesco";
    protected $fillable = [
        "id",
        "id_persona",
        "id_tipo_parentesco",
        "estado",
    ];
}
