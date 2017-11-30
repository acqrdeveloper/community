<?php
/**
 * Created by PhpStorm.
 * User: aquispe
 * Date: 14/11/2017
 * Time: 12:47 AM
 */

namespace App\Http\Controllers;


use App\Http\Services\EmpresaService;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{

    function __construct(EmpresaService $service)
    {
        $this->service = $service;
    }

    function all(Request $request)
    {
        $request->merge(["estado" => "A"]);
        $rpta = $this->service->all($request, null);
        if ($rpta['load']) {
            return response()->json($rpta, 200);
        } else {
            return response()->json($rpta, 412);
        }
    }

}