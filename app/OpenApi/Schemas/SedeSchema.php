<?php

namespace App\OpenApi\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 * schema="SedeSchema",
 * type="object",
 * required={"idsede", "ubicacion"},
 * @OA\Property(property="idsede", type="integer", example=14),
 * @OA\Property(property="nombre", type="string", example="QUITO"),
 * @OA\Property(property="ubicacion", type="string", example="Panamericana Norte km 12.5 y el Arenal"),
 * @OA\Property(property="num_sucursal", type="string", example="001"),
 * @OA\Property(property="num_actual_ot", type="integer", example=0),
 * @OA\Property(property="num_actual_proforma", type="integer", example=0),
 * @OA\Property(property="estado", type="string", example="1"),
 * @OA\Property(property="created_at", type="string", format="date-time", nullable=true),
 * @OA\Property(property="updated_at", type="string", format="date-time", nullable=true)
 * )
 */
class SedeSchema
{
    // Clase vacía, solo sirve para documentar el esquema en OpenAPI
}
