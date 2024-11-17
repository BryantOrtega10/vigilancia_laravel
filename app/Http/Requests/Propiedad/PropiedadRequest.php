<?php

namespace App\Http\Requests\Propiedad;

use Illuminate\Foundation\Http\FormRequest;

class PropiedadRequest extends FormRequest
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
            'nombre' => 'required',
            'direccion' => 'nullable',
            'telefono' => 'nullable',
            'contacto' => 'nullable',
            'correo' => 'nullable',
            'tipo_propiedad' => 'required',
        ];
    }
}
