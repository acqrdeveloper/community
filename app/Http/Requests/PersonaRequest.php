<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->getMethod()) {
            case "POST":
                $rules = [
                    'nombres' => 'required',
                    'apellido_paterno' => 'required',
                    'apellido_materno' => 'required',
                    'direccion' => 'required',
                    'imagen' => 'required',
                    'edad' => 'required',
                    'dni' => 'required|numeric|unique:users,dni',
                    'dia' => 'required',
                    'mes' => 'required',
                    'anio' => 'required',
                    'sexo' => 'required',
                    'estado_civil' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required',
                ];
                return $rules;
            case "PUT":
                $rules = [
                    'nombres' => 'required',
                    'apellido_paterno' => 'required',
                    'apellido_materno' => 'required',
                    'direccion' => 'required',
                    'imagen' => 'sometimes|min:1',
                    'edad' => 'required',
                    'dni' => 'required|numeric',
                    'dia' => 'required',
                    'mes' => 'required',
                    'anio' => 'required',
                    'sexo' => 'required',
                    'estado_civil' => 'required',
                    'email' => 'required|email',
                    'password' => 'sometimes',
                    'estado' => 'sometimes',
                ];
                if ($this->request->get("es_empresa")) {
                    $addrules = [
                        "empresa.nombre_comercial" => "required",
                        "empresa.razon_social" => "required",
                        "empresa.ruc" => "required",
                        "empresa.direccion" => "required",
                        "empresa.estado" => "required",
                    ];
                    return array_merge($rules, $addrules);
                } else {
                    return $rules;
                }
            case "DELETE":
                return [];
            default:
                return [];
        }
    }
}
