<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CursoProfesorRequest extends FormRequest
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
            'curso_ciclo_id' => 'required|exists:curso_ciclo,id',
            'profesor_id' => 'required|exists:profesores,id',
        ];
    }

    public function attributes()
    {
        return [
            'curso_ciclo_id' => 'Curso y Ciclo',
            'profesor_id' => 'Profesor',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es requerido',
           'exists' => 'El campo :attribute no existe'
        ];
    }
}
