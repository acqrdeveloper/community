<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistorialComprobante extends Model
{
    protected $table = "historial_comprobante";
    public $timestamps = false;
    protected $fillable = [
        "id",
        "id_comprobante",
        "id_auth",
        "observacion",
        "tipo",
        "fecha",
    ];
}
