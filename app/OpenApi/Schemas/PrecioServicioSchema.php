<?php

namespace App\OpenApi\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="PrecioServicioSchema",
 *     type="object",
 *     required={"idservicio", "rangouno", "rangodos", "valor", "estado"},
 *     @OA\Property(property="idprecioservicio", type="integer", example=1),
 *     @OA\Property(property="idservicio", type="integer", example=2),
 *     @OA\Property(property="rangouno", type="string", example="1"),
 *     @OA\Property(property="rangodos", type="string", example="5"),
 *     @OA\Property(property="valor", type="number", format="float", example=13.46),
 *     @OA\Property(property="estado", type="boolean", example=true),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-06-01T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-06-13T08:30:00Z")
 * )
 */
class PrecioServicioSchema
{
    // Clase vacía, solo sirve para documentar el esquema en OpenAPI
}
