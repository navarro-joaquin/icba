<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'username' => 'required|string|max:255',
            'email' =>'required|email|max:255|unique:users,email',
            'role' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            // Campos adicionales para el registro de alumnos y profesores
            'fecha_nacimiento' => 'nullable|date',
            'especialidad' => 'nullable|string|max:100'
        ];
    }

    public function attributes(): array
    {
        return [
            'username' => 'Nombre',
            'email' => 'Correo electrónico',
            'role' => 'Rol',
            'password' => 'Contraseña',
            'fecha_nacimiento' => 'Fecha de nacimiento',
            'especialidad' => 'Especialidad'
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'email' => 'El campo :attribute debe ser un correo electrónico válido.',
            'unique' => 'El campo :attribute ya está en uso.',
            'min' => 'El campo :attribute debe tener al menos :min caracteres.',
            'max' => 'El campo :attribute debe tener menos de :max caracteres.',
            'date' => 'El campo :attribute debe ser una fecha válida.',
        ];
    }
}
