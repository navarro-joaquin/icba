<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MatriculaRequest extends FormRequest
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
            'anio' => 'required|string|max:4',
            'monto_total' => 'required|numeric'
        ];
    }

    public function attributes(): array
    {
        return [
            'alumno_id' => 'Alumno',
            'anio' => 'Año',
            'monto_total' => 'Monto total'
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio',
            'exists' => 'El campo :attribute seleccionado no existe',
            'numeric' => 'El campo :attribute debe ser un número',
            'string' => 'El campo :attribute debe ser una cadena de texto',
            'max' => 'El campo :attribute no debe tener más de :max caracteres'
        ];
    }
}
