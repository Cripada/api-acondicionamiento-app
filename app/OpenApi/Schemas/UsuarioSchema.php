<?php

namespace App\OpenApi\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="UsuarioSchema",
 *     type="object",
 *     title="Usuario",
 *     description="Información del usuario del sistema",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nombre", type="string", maxLength=50, example="Juan"),
 *     @OA\Property(property="apellido", type="string", maxLength=50, example="Pérez"),
 *     @OA\Property(property="correo", type="string", format="email", maxLength=50, example="juan.perez@dominio.com"),
 *     @OA\Property(property="telefono", type="string", maxLength=20, nullable=true, example="0991234567"),
 *     @OA\Property(property="usuario", type="string", maxLength=50, example="jperez"),
 *     @OA\Property(property="foto", type="string", nullable=true, example="usuarios/juan.jpg"),
 *     @OA\Property(property="estado", type="boolean", example=true),
 *     @OA\Property(property="email_verified_at", type="string", format="date-time", nullable=true, example="2025-06-10T15:34:00Z"),
 *     @OA\Property(property="idrol", type="integer", example=2, description="ID del rol asignado al usuario"),
 *     
 *     @OA\Property(
 *         property="Rol",
 *         ref="#/components/schemas/RolSchema",
 *         description="Objeto opcional con información del rol"
 *     ),
 *     
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-06-10T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-06-10T13:30:00Z"),
 *     @OA\Property(property="remember_token", type="string", nullable=true, example="a1b2c3d4e5f6g7h8")
 * )
 *
 * @OA\Schema(
 *     schema="UsuarioUpdateSchema",
 *     type="object",
 *     required={"nombre", "apellido", "correo", "idrol"},
 *     @OA\Property(property="nombre", type="string", example="Juan"),
 *     @OA\Property(property="apellido", type="string", example="Pérez"),
 *     @OA\Property(property="correo", type="string", example="juan@correo.com"),
 *     @OA\Property(property="telefono", type="string", example="0991234567"),
 *     @OA\Property(property="idrol", type="integer", example=2),
 *     @OA\Property(property="estado", type="boolean", example=true)
 * )
 *
 * @OA\Schema(
 *     schema="UsuarioUpdateFormSchema",
 *     type="object",
 *     required={"nombre", "apellido", "correo", "idrol"},
 *     @OA\Property(property="nombre", type="string", example="Juan"),
 *     @OA\Property(property="apellido", type="string", example="Pérez"),
 *     @OA\Property(property="correo", type="string", example="juan@correo.com"),
 *     @OA\Property(property="telefono", type="string", example="0991234567"),
 *     @OA\Property(property="idrol", type="integer", example=2),
 *     @OA\Property(property="estado", type="boolean", example=true),
 *     @OA\Property(property="foto", type="string", format="binary")
 * )
 */

class UsuarioSchema
{
    // Clase vacía solo para documentación OpenAPI
}
