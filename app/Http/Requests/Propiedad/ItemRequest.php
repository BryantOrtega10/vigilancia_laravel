<?php

namespace App\Http\Requests\Propiedad;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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
            'nombres' => 'required_with:apellidos,celular_p,celular_s,email',
            'apellidos' => 'required_with:nombres,celular_p,celular_s,email',
            'celular_p' => 'required_with:nombres,apellidos,celular_s,email',
            'celular_s' => 'required_with:nombres,apellidos,celular_p,email',
            'email' => 'required_with:nombres,apellidos,celular_p,celular_s',
        ];
    }
}
