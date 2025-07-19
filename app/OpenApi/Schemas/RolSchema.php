<?php

namespace App\OpenApi\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="RolSchema",
 *     type="object",
 *     title="Rol",
 *     description="Rol asignado a un usuario del sistema",
 *     @OA\Property(property="idrol", type="integer", example=1),
 *     @OA\Property(property="nombre", type="string", maxLength=150, example="Administrador"),
 *     @OA\Property(property="descripcion", type="string", maxLength=255, nullable=true, example="Rol con todos los permisos del sistema"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-06-25T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-06-25T14:30:00Z")
 * )
 */
class RolSchema
{
    // Clase vacía solo para documentación OpenAPI
}
