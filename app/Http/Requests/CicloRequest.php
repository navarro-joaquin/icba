<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CicloRequest extends FormRequest
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
            'nombre' => 'required|string|max:50',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date'
        ];
    }

    public function attributes()
    {
        return [
            'nombre' => 'Nombre del ciclo',
            'fecha_inicio' => 'Fecha de inicio',
            'fecha_fin' => 'Fecha de finalización'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es obligatorio',
            'string' => 'El campo :attribute debe ser una cadena de texto',
            'max' => 'El campo :attribute no debe tener más de :max caracteres',
            'date' => 'El campo :attribute debe ser una fecha válida'
        ];
    }
}
