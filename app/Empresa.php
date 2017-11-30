<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table= "empresa";
    protected $fillable = [
      "id_usuario",
      "nombre_comercial",
      "razon_social",
      "ruc",
      "direccion",
      "estado",
    ];
}
