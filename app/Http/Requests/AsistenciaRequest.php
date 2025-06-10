<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AsistenciaRequest extends FormRequest
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
            'clase_id' => 'required|exists:clases,id',
            'presente' => 'boolean',
        ];
    }

    public function attributes()
    {
        return [
            'inscripcion_id' => 'Inscripcion',
            'clase_id' => 'Clase',
            'presente' => 'Presente',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'exists' => 'El campo :attribute seleccionado no existe.',
            'boolean' => 'El campo :attribute debe ser verdadero o falso.',
        ];
    }
}
