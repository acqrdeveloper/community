<?php
/**
 * Created by PhpStorm.
 * User: aquispe
 * Date: 24/10/2017
 * Time: 01:53 PM
 */

namespace App\Http\Services;

use App\Empresa;
use App\Http\Controllers\Utility;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Exception;

class PersonaService
{
    use Utility;

    function all($request = null, $option = null)
    {
        try {

            $data = new User();

            if (isset($option["fields"])) $data = $data->select($option["fields"]);

            if (!empty($request)) {
                if (!empty($request->estado)) $data = $data->where("estado", $request->estado);
                if (!empty($request->filtro)) switch ($request->filtro) {
                    case "nombre":
                        if (!empty($request->buscar)) $data = $data->where("nombres", "like", "%" . $request->buscar . "%");
                        break;
                    case "apellido":
                        if (!empty($request->buscar)) $data = $data->where(function ($query) use ($request) {
                            $query->orWhere("apellido_paterno", "like", "%" . $request->buscar . "%")->orWhere("apellido_materno", "like", "%" . $request->buscar . "%");
                        });
                        break;
                    default:// dni
                        if (!empty($request->buscar)) $data = $data->where("dni", "like", "%" . $request->buscar . "%");
                        break;
                }
            }

            if (isset($option["paginate"])) {
                $data = $data->paginate($option["page"]);
            } else {
                $data = $data->get();
            }

            $this->fnSuccess($data);

        } catch (Exception $e) {
            $this->fnErrorException($e);
        }
        return $this->rpta;
    }

    function store($request)
    {
        try {

            $persona = (new User())->fill($request->all());
            // Encriptar
            if ($request->has('password')) {
                $persona->decrypt = $request->password;
                $persona->password = bcrypt($request->password);
            }
            // Validar
            if ($request->has('imagen')) {
                $exploded = explode(',', $request->imagen);
                if (str_contains($exploded[1], 'jpeg')) $ext = "jpg"; else $ext = "png";
                $filename = str_random() . "." . $ext;
                Image::make($request->imagen)->save(PATH_USERS . $filename);
                $persona->imagen = $filename;
            }
            // Setear
            $persona->fecha_nacimiento = Carbon::create($request->anio, $request->mes, $request->dia)->format("Y-m-d");
            // Validar
            if ($request->es_empresa) {
                $idPersona = $persona->insertGetId($persona->toArray());
                if ($idPersona <= 0) {
                    throw new Exception("Error al crear persona.");
                }
                $empresa = (new Empresa())->insert(array_merge($request->empresa, ["id_usuario" => $idPersona]));
                if (!$empresa) {
                    throw new Exception("Error al crear empresa.");
                }
            } else {
                $persona->save();
            }

            $this->fnSuccess($request->all(), 'registrado correctamente');

        } catch (Exception $e) {
            $this->fnErrorException($e);
        }
        return $this->rpta;
    }

    function edit($id)
    {
        try {

            $persona = (new User())->findOrFail($id);
            // Validar
            if ($persona->es_empresa) {
                $empresa = (new Empresa())->select(["empresa.*"])->where("empresa.id_usuario", $id)->first();
                $this->fnSuccess(compact('persona', 'empresa'));
            } else {
                $this->fnSuccess(compact('persona'));
            }

        } catch (Exception $e) {
            $this->fnErrorException($e);
        }
        return $this->rpta;
    }

    function update($id, $request)
    {
        try {

            $persona = (new User())->findOrFail($id);
            // Modelo
            $temp_imagen = $persona->imagen;
            // Fusionar
            $newPersona = $persona->fill($request->all());
            // Encriptar
            if ($request->has('password')) {
                $persona->decrypt = $request->password;
                $persona->password = bcrypt($request->password);
            }
            // Validar
            if ($request->has('imagen')) {
                if ($temp_imagen == $request->imagen) {
                    $newPersona->imagen = $temp_imagen;
                } else {
                    $exploded = explode(',', $request->imagen);
                    if (str_contains($exploded[1], 'jpeg')) $ext = "jpg"; else $ext = "png";
                    $filename = str_random() . "." . $ext;
                    if (!empty($request->imagen)) File::delete(PATH_USERS . $newPersona->imagen);
                    Image::make($request->imagen)->save(PATH_USERS . $filename);
                    $newPersona->imagen = $filename;
                }
            }
            // Setear
            $newPersona->fecha_nacimiento = Carbon::create($request->anio, $request->mes, $request->dia)->format("Y-m-d");
            // Validar
            if ($request->es_empresa) {
                (new Empresa())->where("empresa.id_usuario", $id)->first()->fill($request->empresa)->save();
                $persona->save();
            } else {
                $persona->save();
            }

            $this->fnSuccess($request->all(), 'actualizado correctamente');

        } catch (Exception $e) {
            $this->fnErrorException($e);
        }
        return $this->rpta;
    }

    function changeStatus($id, $request)
    {
        try {

            if (!empty($request->estado)) {
                (new User())->where("id", $id)->update(["estado" => $request->estado]);
                $this->fnSuccess($request->all(), 'actualizado correctamente');
            } else {
                throw new Exception("El valor del estado es NULL.", 412);
            }

        } catch (Exception $e) {
            $this->fnErrorException($e);
        }
        return $this->rpta;
    }

}