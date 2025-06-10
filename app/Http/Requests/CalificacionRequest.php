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
            'tipo' => 'required',
            'nota' => 'required|numeric',
            'inscripcion_id' => 'required|exists:inscripciones,id'
        ];
    }

    public function attributes()
    {
        return [
            'tipo' => 'Tipo',
            'nota' => 'Nota',
            'inscripcion_id' => 'Inscripción'
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
