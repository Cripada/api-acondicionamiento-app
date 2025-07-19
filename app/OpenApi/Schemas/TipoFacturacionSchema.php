<?php

namespace App\OpenApi\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 * schema="TipoFacturacionSchema",
 * type="object",
 * required={"idTipoFacturacion", "nombre", "descripcion", "estado"},
 * @OA\Property(property="idTipoFacturacion", type="integer", example=1),
 * @OA\Property(property="nombre", type="string", example="A final del mes"),
 * @OA\Property(property="descripcion", type="string", example="Descripcion de que el pago es a final del mes"),
 * @OA\Property(property="estado", type="boolean", example=true),
 * @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-27T12:00:00Z"),
 * @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-27T12:00:00Z")
 * )
 */
class TipoFacturacionSchema
{
    // Clase vacía, solo sirve para documentar el esquema en OpenAPI
}
