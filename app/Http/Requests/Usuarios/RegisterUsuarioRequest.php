<?php

namespace App\Http\Requests\Usuarios;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUsuarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    
    protected function prepareForValidation()
    {
        // ✅ Convertir "estado" a booleano si viene como texto
        if ($this->has('estado')) {
            $this->merge([
                'estado' => filter_var($this->input('estado'), FILTER_VALIDATE_BOOLEAN),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'correo' => 'required|email|unique:users,correo',
            'telefono' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
            'estado' => 'sometimes|boolean',
            'idrol' => 'required|exists:roles,idrol',
            'foto' => 'nullable|image|max:2048',
        ];
    }
}
