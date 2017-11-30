<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonaRequest;
use App\Http\Services\PersonaService;

class PersonaController extends Controller
{

    function __construct(PersonaService $service)
    {
        $this->service = $service;
    }

    function all(PersonaRequest $request)
    {
        $rpta = $this->service->all($request, ["paginate" => true, "page" => 5]);
        if ($rpta["load"]) {
            return response()->json($rpta, 200);
        } else {
            return response()->json($rpta, 412);
        }
    }

    function allClientes(PersonaRequest $request)
    {
        $request->merge(["estado" => "A"]);
        $rpta = $this->service->all($request, null);
        if ($rpta["load"]) {
            return response()->json($rpta, 200);
        } else {
            return response()->json($rpta, 412);
        }
    }

    function store(PersonaRequest $request)
    {
        $rpta = $this->service->store($request);
        if ($rpta["load"]) {
            return response()->json($rpta, 200);
        } else {
            return response()->json($rpta, 412);
        }
    }

    function edit($id, PersonaRequest $request)
    {
        $rpta = $this->service->edit($id);
        if ($rpta["load"]) {
            if ($request->ajax()) {
                return response()->json($rpta, 200);
            } else {
                return view("app");
            }
        } else {
            return response()->json($rpta, 412);
        }
    }

    function update($id, PersonaRequest $request)
    {
        if (!empty($request->password) && !empty($request->confirm_password)) {
            if ($request->password === $request->confirm_password) {
                $rpta = $this->service->update($id, $request);
            } else {
                return response()->json(["validate" => "Las contraseñas ingresadas son incorrectas."], 422);
            }
        } else {
            $rpta = $this->service->update($id, $request);
        }
        if ($rpta["load"]) {
            return response()->json($rpta, 200);
        } else {
            return response()->json($rpta, 412);
        }
    }

    function filter(PersonaRequest $request)
    {
        $rpta = $this->service->all($request, ["fields" => ["id", "nombres", "apellido_paterno", "apellido_materno", "dni"]]);
        if ($rpta["load"]) {
            $newdata = [];
            foreach ($rpta["data"] as $item) {
                array_push($newdata, ["id" => $item->id, "value" => $item->apellido_paterno . " " . $item->nombres . ", " . $item->nombres . " - " . $item->dni]);
            }
            $rpta["data"] = $newdata;
            return response()->json($rpta, 200);
        } else {
            return response()->json($rpta, 412);
        }
    }

    function changeStatus($id)
    {
        $rpta = $this->service->changeStatus($id, request());
        if ($rpta["load"]) {
            return response()->json($rpta, 200);
        } else {
            return response()->json($rpta, 412);
        }
    }

}