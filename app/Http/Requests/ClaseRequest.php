<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClaseRequest extends FormRequest
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
            'curso_gestion_id' => 'required|exists:curso_gestion,id',
            'numero_clase' => 'required|integer',
            'fecha_clase' => 'required|date',
            'tema' => 'nullable',
        ];
    }

    public function attributes()
    {
        return [
            'curso_gestion_id' => 'Curso y Gestión',
            'numero_clase' => 'Número de clase',
            'fecha_clase' => 'Fecha de clase',
            'tema' => 'Tema',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'exists' => 'El campo :attribute seleccionado no existe.',
            'integer' => 'El campo :attribute debe ser un número entero.',
            'date' => 'El campo :attribute debe ser una fecha válida.',
        ];
    }
}
