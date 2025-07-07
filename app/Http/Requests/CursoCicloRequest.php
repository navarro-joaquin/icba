<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CursoCicloRequest extends FormRequest
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
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'curso_id' => 'required|exists:cursos,id',
            'ciclo_id' =>'required|exists:ciclos,id',
        ];
    }

    public function attributes()
    {
        return [
            'fecha_inicio' => 'Fecha de inicio',
            'fecha_fin' => 'Fecha de fin',
            'curso_id' => 'Curso',
            'ciclo_id' => 'Ciclo',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'string' => 'El campo :attribute debe ser una cadena de caracteres.',
            'exists' => 'El campo :attribute seleccionado no existe.',
            'date' => 'El campo :attribute debe ser una fecha válida.',
        ];
    }
}
