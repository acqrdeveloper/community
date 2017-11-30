<?php
/**
 * Created by PhpStorm.
 * User: aquispe
 * Date: 14/11/2017
 * Time: 12:48 AM
 */

namespace App\Http\Services;


use App\Empresa;
use App\Http\Controllers\Utility;
use Exception;

class EmpresaService
{

    use Utility;

    function all($request = null, $options = null)
    {
        try {

            $data = new Empresa();

            if (isset($options["fields"])) $data = $data->select($options["fields"]);

            if (!empty($request)) {

                if (isset($request->estado)) $data = $data->where("estado", $request->estado);

                if (isset($request->filtro)) switch ($request->filtro) {
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

            if (isset($options["isPaginate"])) {
                $data = $data->paginate($options["page"]);
            } else {
                $data = $data->get();
            }

            $this->fnSuccess($data);

        } catch (Exception $e) {
            $this->fnErrorException($e);
        }
        return $this->rpta;
    }

}