<?php

namespace App\OpenApi\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 * schema="ServicioSchema",
 * type="object",
 * required={"idservicio", "nombre", "descripcion"},
 * @OA\Property(property="idservicio", type="integer", example=14),
 * @OA\Property(property="nombre", type="string", example="BORRADO CS - TAMBOR"),
 * @OA\Property(property="descripcion", type="string", example="BORRADO CS - TAMBOR"),
 * @OA\Property(property="produccionHora", type="string", example="36.00"),
 * @OA\Property(property="estado", type="string", example="1"),
 * @OA\Property(property="created_at", type="string", format="date-time", nullable=true),
 * @OA\Property(property="updated_at", type="string", format="date-time", nullable=true)
 * )
 */
class ServicioSchema
{
    // Clase vacía, solo sirve para documentar el esquema en OpenAPI
}
