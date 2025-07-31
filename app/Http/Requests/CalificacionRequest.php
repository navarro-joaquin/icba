<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalificacionRequest extends FormRequest
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
            'inscripcion_id' => 'required|exists:inscripciones,id',
            'examen_1' => 'nullable|numeric',
            'examen_2' => 'nullable|numeric',
            'nota_final' => 'nullable|numeric',
        ];
    }

    public function attributes()
    {
        return [
            'inscripcion_id' => 'Inscripción',
            'examen_1' => 'Examen 1',
            'examen_2' => 'Examen 2',
            'nota_final' => 'Nota Final',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es obligatorio',
            'exists' => 'El campo :attribute seleccionado no existe',
            'numeric' => 'El campo :attribute debe ser un número'
        ];
    }
}
