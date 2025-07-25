<?php

namespace App\Http\Requests\Usuarios;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUsuarioRequest extends FormRequest
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
        $idusuario = $this->route('usuario'); // Asegúrate que el parámetro de ruta se llame así

        return [
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'correo' => 'required|email|unique:users,correo,' . $idusuario,
            'telefono' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6',
            'estado' => 'sometimes|boolean',
            'idrol' => 'required|exists:roles,idrol',
            'foto' => 'nullable|image|max:2048',
        ];
    }
}
