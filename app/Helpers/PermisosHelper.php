<?php

namespace App\Helpers;

// app/Helpers/PermisosHelper.php
class PermisosHelper
{
    public static function tienePermiso($usuario, $tabla, $accion): bool
    {
 // Validar usuario y parámetros
    if (!$usuario || !$usuario->idrol || empty($tabla) || empty($accion)) {
        return false;
    }

    // Cargar relaciones si no están cargadas
    if (!$usuario->relationLoaded('rol') || !$usuario->rol?->relationLoaded('permisos')) {
        $usuario->load('rol.permisos');
    }

    // Verificar que el usuario tiene permisos sobre la tabla y acción
    return $usuario->rol
        && $usuario->rol->permisos
        && $usuario->rol->permisos
            ->where('nombre_tabla', $tabla)
            ->where('accion', $accion)
            ->isNotEmpty();
    }
}
