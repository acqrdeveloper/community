<?php
/**
 * Created by PhpStorm.
 * User: aquispe
 * Date: 24/10/2017
 * Time: 01:53 PM
 */

namespace App\Http\Services;


use App\Actividad;
use App\Http\Controllers\Utility;
use Exception;

class ActividadService
{
    use Utility;

    // ALGORITMO LISTAR
    function getList($request, $options)
    {
        try {
            $data = new Actividad();

            if (!empty($request)) {

                if (!empty($request->estado))
                    $data = $data->where("estado", $request->estado);

                if (!empty($request->filtro))
                    switch ($request->filtro) {
                        case "nombre":
                            if (!empty($request->buscar))
                                $data = $data->where("nombres", "like", "%" . $request->buscar . "%");
                            break;
                        case "apellido":
                            if (!empty($request->buscar))
                                $data = $data->where(function ($query) use ($request) {
                                    $query->orWhere("apellido_paterno", "like", "%" . $request->buscar . "%")->orWhere("apellido_materno", "like", "%" . $request->buscar . "%");
                                });
                            break;
                        default:// dni
                            if (!empty($request->buscar))
                                $data = $data->where("dni", "like", "%" . $request->buscar . "%");
                            break;
                    }
            }

            if (isset($options["isPaginate"])) $data = $data->paginate($options["page"]); else $data = $data->get();

            $this->fnSuccess($request->all());

        } catch (Exception $e) {
            $this->fnErrorException($e);
        }
        return $this->rpta;
    }

    // ALGORITMO CREAR
    function create()
    {
    }

    // ALGORITMO EDITAR
    function edit()
    {
    }

    // ALGORITMO ACTUALIZAR
    function update()
    {
    }

    // ALGORITMO CAMBIAR
    function changeActivity()
    {
    }

    // ALGORITMO GENERAR COMPROBANTE
    function generateComprobante()
    {
    }

    // ALGORITMO CREAR PDF
    function createPDF()
    {
    }

    // ALGORITMO CREAR EXCEL
    function createEXCEL()
    {
    }

}