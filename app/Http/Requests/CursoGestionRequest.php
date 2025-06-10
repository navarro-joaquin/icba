<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CursoGestionRequest extends FormRequest
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
            'curso_id' => 'required|exists:cursos,id',
            'gestion_id' =>'required|exists:gestiones,id',
        ];
    }

    public function attributes()
    {
        return [
            'curso_id' => 'Curso',
            'gestion_id' => 'Gestión',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'string' => 'El campo :attribute debe ser una cadena de caracteres.',
            'exists' => 'El campo :attribute seleccionado no existe.',
        ];
    }
}
