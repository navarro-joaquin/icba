<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlumnoRequest extends FormRequest
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
            'nombre' => 'required|string',
            'fecha_nacimiento' => 'required|date',
            'user_id' => 'required|exists:users,id'
        ];
    }

    public function attributes()
    {
        return [
            'nombre' => 'Nombre',
            'fecha_nacimiento' => 'Fecha de nacimiento',
            'user_id' => 'Usuario'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es obligatorio',
            'date' => 'El campo :attribute debe ser una fecha válida',
            'exists' => 'El usuario seleccionado no existe'
        ];
    }
}
