<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Helpers\PermisosHelper;

class CheckPermisos
{
    public function handle($request, Closure $next, $tabla, $accion)
    {
        /** @var \App\Models\Usuario $usuario */
        $usuario = Auth::user();

        // Parámetros incompletos
        if (empty($tabla) || empty($accion)) {
            return response()->json(['message' => 'Parámetros de permiso incompletos'], 400);
        }

        // Verifica que el usuario tenga un rol asignado
        if (!$usuario->rol) {
            return response()->json(['message' => 'El usuario no tiene un rol asignado'], 403);
        }

        // Verifica si tiene el permiso
        if (!PermisosHelper::tienePermiso($usuario, $tabla, $accion)) {
            return response()->json(['message' => 'No tienes permiso para esta acción'], 403);
        }

        return $next($request);
    }
}
