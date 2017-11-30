<?php
/**
 * Created by PhpStorm.
 * User: aquispe
 * Date: 31/10/2017
 * Time: 05:01 PM
 */

namespace App\Http\Services;


use App\Http\Controllers\Utility;
use Illuminate\Support\Facades\DB;
use Exception;

class TablasService
{
    use Utility;

    function all($request = null, $options = null)
    {
        try {
            $data = DB::table($request->tabla);

            if (isset($options["fields"])) {
                $data = $data->select($options["fields"]);
            }

            if (!empty($request)) {
                if (!empty($request->estado)) $data = $data->where("estado", $request->estado);
            }

            if (isset($options["isPaginate"]))
                $data = $data->paginate($options["page"]);
            else
                $data = $data->get();

            $this->fnSuccess($data);

        } catch (Exception $e) {
            $this->fnErrorException($e);
        }
        return $this->rpta;
    }

    function store($tabla, $request)
    {
        try {

            DB::table($tabla)->insert($request->only(['descripcion','nombre', 'valor']));
            $this->fnSuccess($request->all(), 'creado correctamente');

        } catch (Exception $e) {
            $this->fnErrorException($e);
        }
        return $this->rpta;
    }

    function update($tabla, $id, $request)
    {
        try {

            DB::table($tabla)->where("id", $id)->update($request->only(['descripcion','nombre', 'valor', 'estado']));
            $this->fnSuccess($request->all(), 'actualizado correctamente');

        } catch (Exception $e) {
            $this->fnErrorException($e);
        }
        return $this->rpta;
    }

}