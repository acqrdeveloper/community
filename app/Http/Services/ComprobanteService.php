<?php
/**
 * Created by PhpStorm.
 * User: aquispe
 * Date: 09/11/2017
 * Time: 05:14 PM
 */

namespace App\Http\Services;


use App\Comprobante;
use App\HistorialComprobante;
use App\Http\Controllers\Utility;
use Exception;
use Illuminate\Support\Facades\DB;

class ComprobanteService
{
    use Utility;

    function all($request = null, $option = null)
    {
        try {
            $data = new Comprobante();
            if (!empty($request)) {
                if (isset($request->estado)) $data->where("estado", $request->estado);
                if (isset($request->id_usuario)) $data->where("id_usuario", $request->id_usuario);
                if (isset($request->numero)) $data->where("numero", $request->numero);
            }
            if (!empty($option["paginate"]) == true) {
                $data->paginate($option["page"]);
            } else {
                $data->get();
            }
            $this->fnSuccess($data);

        } catch (Exception $e) {
            $this->fnErrorException($e);
        }
        return $this->rpta;
    }

    function store($request)
    {
        DB::beginTransaction();
        try {

            $comprobante = new Comprobante();
            $request->merge(["comprobante.id" => $this->fnGetAutoIncrement("comprobante")]);

            if (is_array($request->id_usuario)) {
                foreach ($request->id_usuario as $item) {
                    $request->merge(["id_usuario" => $item]);
                    $comprobante->fill($request->all());
                    $id_comprobante = $comprobante->insertGetId($comprobante->toArray());
                    $request->merge([
                        "historial_comprobante.id" => $this->fnGetAutoIncrement("historial_comprobante"),
                        "id_comprobante" => $id_comprobante,
                        "id_auth" => auth()->user()->id,
                        "observacion" => "creado muchos",
                        "tipo" => "ACTUALIZADO",
                        "fecha" => FORMAT_TIMESTAMP,
                    ]);
                    $this->storeHistory($request);
                }
            } else {
                $comprobante->fill($request->all());
                $id_comprobante = $comprobante->insertGetId($comprobante->toArray());
                $request->merge([
                    "historial_comprobante.id" => $this->fnGetAutoIncrement("historial_comprobante"),
                    "id_comprobante" => $id_comprobante,
                    "id_auth" => auth()->user()->id,
                    "observacion" => "creado uno",
                    "tipo" => "CREADO",
                    "fecha" => FORMAT_TIMESTAMP]);
                $this->storeHistory($request);
            }
            $this->fnSuccess($request->all());

        } catch (Exception $e) {
            DB::rollBack();
            $this->fnErrorException($e);
        }
        DB::commit();
        return $this->rpta;
    }

    function update($id, $request)
    {
        DB::beginTransaction();
        try {

            if (is_array($request->id_usuario)) {
                foreach ($request->id_usuario as $item) {
                    $data = (new Comprobante())->find($id);
                    $request->merge(["id_usuario" => $item]);
                    $data->fill($request->all());
                    $data->save();
                }
            } else {
                $data = (new Comprobante())->find($request->id_usuario);
                $data->fill($request->all());
                $data->save();
            }

            $request->merge([
                "historial_comprobante.id" => $this->fnGetAutoIncrement("historial_comprobante"),
                "id_comprobante" => $id,
                "id_auth" => auth()->user()->id,
                "observacion" => "mi editado.................................",
                "tipo" => "EDITADO",
                "fecha" => FORMAT_TIMESTAMP]);
            $this->storeHistory($request);
            $this->fnSuccess($request->all());

        } catch (Exception $e) {
            DB::rollBack();
            $this->fnErrorException($e);
        }
        DB::commit();
        return $this->rpta;
    }

    function storeHistory($request)
    {
        (new HistorialComprobante())->fill($request->all())->save();
    }

    function pay($request)
    {
        try {
            $data = (new Comprobante())->select()->get();
            if ($data) {
                $this->fnSuccess($data);
            } else {
                throw new Exception("Error al filtrar");
            }
        } catch (Exception $e) {
            $this->fnErrorException($e);
        }
        return $this->rpta;
    }

}