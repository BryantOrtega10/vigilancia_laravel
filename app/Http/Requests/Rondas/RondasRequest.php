<?php

namespace App\Http\Requests\Rondas;

use Illuminate\Foundation\Http\FormRequest;

class RondasRequest extends FormRequest
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
        $rules = [
            'nombre' => 'required'
        ];

        if(!$this->route("idRonda")){
            $rules['sede'] = 'required';
        }

        return $rules;
    }
}
