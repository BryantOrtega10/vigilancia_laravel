<?php

namespace App\Http\Requests\Usuarios;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UsuariosRequest extends FormRequest
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
            'nombre' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'rol' => 'required',
            'repetir_password' => 'same:password',
        ];

        if($this->route("id") != null){
            $rules['email'] = ['required', Rule::unique('users','email')->ignore($this->route("id"))];
            $rules['password'] = 'nullable';
        }
        
        return $rules;

        
    }
}
