<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comprobante extends Model
{
    protected $table = "comprobante";
    protected $fillable = [
        "id_usuario",
        "id_tipo_comprobante",
    ];
}
