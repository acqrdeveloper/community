<?php

namespace App\Http\Controllers;

use App\Http\Requests\TablasRequest;
use App\Http\Services\TablasService;
use Illuminate\Http\Request;

class TablasController extends Controller
{

    public function __construct(TablasService $tablasService)
    {
        $this->service = $tablasService;
    }

    function load()
    {
        $rpta = $this->fnGetTable("tablas");
        if ($rpta["load"]) {
            return response()->json($rpta, 200);
        } else {
            return response()->json($rpta, 412);
        }
    }

    function all(TablasRequest $request)
    {
        $rpta = $this->service->all($request, null);
        if ($rpta["load"]) {
            return response()->json($rpta, 200);
        } else {
            return response()->json($rpta, 412);
        }
    }

    function store($tabla, TablasRequest $request)
    {
        $rpta = $this->service->store($tabla, $request);
        if ($rpta["load"]) {
            return response()->json($rpta, 200);
        } else {
            return response()->json($rpta, 412);
        }
    }

    function update($tabla, $id, TablasRequest $request)
    {

        $rpta = $this->service->update($tabla, $id, $request);

        if ($rpta["load"]) {
            return response()->json($rpta, 200);
        } else {
            return response()->json($rpta, 412);
        }
    }

}