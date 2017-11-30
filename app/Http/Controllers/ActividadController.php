<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActividadRequest;
use App\Http\Services\ActividadService;

class ActividadController extends Controller
{

    function __construct(ActividadService $actividadService)
    {
        $this->service = $actividadService;
    }

    // LISTAR
    function getList(ActividadRequest $request)
    {
        $request->merge(["estado" => "A"]);
        $rpta = $this->service->getList($request, null);
        if ($rpta['load']) {
            return response()->json($rpta, 200);
        } else {
            return response()->json($rpta, 412);
        }
    }

    // METODO CREAR
    function createActividad()
    {}

    // METODO EDITAR
    function editActividad()
    {}

    // METODO ACTUALIZAR
    function updateActividad()
    {}

    // METODO CAMBIAR
    function changeActividad()
    {}

}
