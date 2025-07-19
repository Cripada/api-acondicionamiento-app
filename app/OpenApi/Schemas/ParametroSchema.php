<?php

namespace App\OpenApi\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="ParametroSchema",
 *     type="object",
 *     required={"clave", "valor"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="clave", type="string", example="IVA"),
 *     @OA\Property(property="valor", type="string", example="15%"),
 *     @OA\Property(property="descripcion", type="string", example="Impuesto al Valor Agregado"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-06-18T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-06-18T12:30:00Z")
 * )
 */
class ParametroSchema
{
    // Clase vacía, solo sirve para documentar el esquema en OpenAPI
}
