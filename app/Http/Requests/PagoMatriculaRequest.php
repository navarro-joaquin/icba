<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PagoMatriculaRequest extends FormRequest
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
            'matricula_id' => 'required|exists:matriculas,id',
            'fecha_pago' => 'required|date',
            'monto' => 'required|numeric',
            'forma_pago' => 'required|string',
            'descripcion' => 'nullable'
        ];
    }

    public function attributes(): array
    {
        return [
            'alumno_id' => 'Alumno',
            'inscripcion_id' => 'Inscripción',
            'fecha_pago' => 'Fecha de pago',
            'monto' => 'Monto',
            'forma_pago' => 'Forma de pago',
            'descripcion' => 'Descripción'
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio',
            'exists' => 'El campo :attribute seleccionado no existe',
            'date' => 'El campo :attribute debe ser una fecha válida',
            'numeric' => 'El campo :attribute debe ser un número',
            'string' => 'El campo :attribute debe ser una cadena de texto',
        ];
    }
}
