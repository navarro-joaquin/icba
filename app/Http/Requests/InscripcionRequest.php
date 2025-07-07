<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InscripcionRequest extends FormRequest
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
            'alumno_id' => 'required|exists:alumnos,id',
            'curso_ciclo_id' => 'required|exists:curso_ciclo,id',
            'fecha_inscripcion' => 'required|date',
            'monto_total' => 'required|numeric'
        ];
    }

    public function attributes()
    {
        return [
            'alumno_id' => 'Alumno',
            'curso_ciclo_id' => 'Curso y Ciclo',
            'fecha_inscripcion' => 'Fecha de inscripción',
            'monto_total' => 'Monto Total'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es obligatorio',
            'exists' => 'El campo :attribute seleccionado no existe',
            'date' => 'El campo :attribute debe ser una fecha válida',
            'numeric' => 'El campo :attribute debe ser un número'
        ];
    }
}
