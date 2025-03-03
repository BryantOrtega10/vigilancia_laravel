<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class NovVehiculosRequest extends FormRequest
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
            "fecha" => 'required',
            "hora" => 'required',
            "placa" => 'required',
            "tipo_vehiculo" => 'required',
            "observacion" => 'required',
            "images.*" => 'required|string',
        ];
    }
}
