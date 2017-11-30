<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComprobanteRequest;
use App\Http\Services\ComprobanteService;

class ComprobanteController extends Controller
{
    public function __construct(ComprobanteService $service)
    {
        $this->service = $service;
    }

    function all(ComprobanteRequest $request)
    {
        $rpta = $this->service->all($request);
        if ($rpta['load']) {
            return response()->json($rpta, 200);
        } else {
            return response()->json($rpta, 412);
        }
    }

    function store(ComprobanteRequest $request)
    {
        $rpta = $this->service->store($request);
        if ($rpta['load']) {
            return response()->json($rpta, 200);
        } else {
            return response()->json($rpta, 412);
        }
    }

    function update($id,ComprobanteRequest $request)
    {
        $rpta = $this->service->update($id,$request);
        if ($rpta['load']) {
            return response()->json($rpta, 200);
        } else {
            return response()->json($rpta, 412);
        }
    }

    function allByUsuario($id_usuario, ComprobanteRequest $request)
    {
        $request->merge(["id_usuario" => $id_usuario]);
        $request->merge(["estado" => "A"]);
        $rpta = $this->service->all($request);
        if ($rpta['load']) {
            return response()->json($rpta, 200);
        } else {
            return response()->json($rpta, 412);
        }
    }

    function pay($id_comprobante, ComprobanteRequest $request)
    {
        $request->merge(["id_comprobante" => $id_comprobante]);
        $rpta = $this->service->pay($request);
        if ($rpta['load']) {
            return response()->json($rpta, 200);
        } else {
            return response()->json($rpta, 412);
        }
    }

    function changeStatus(ComprobanteRequest $request)
    {
        $rpta = $this->service->changeStatus($request);
        if ($rpta['load']) {
            return response()->json($rpta, 200);
        } else {
            return response()->json($rpta, 412);
        }
    }

}
