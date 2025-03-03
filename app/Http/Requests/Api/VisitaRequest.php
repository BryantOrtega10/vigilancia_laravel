<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class VisitaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'documento' => 'required',
            'nombre' => 'required',
            'observacion' => 'nullable',
            'responsable' => 'required',
            'manejo_datos' => 'required',
            'placa' => 'nullable',
            'tipo_vehiculo_id' => 'nullable',
            'propiedad_id' => 'required',

        ];
    }
}
