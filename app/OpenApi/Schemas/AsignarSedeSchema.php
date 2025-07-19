<?php

namespace App\OpenApi\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="AsignarSedeSchema",
 *     required={"idusuario", "idsede", "estado"},
 *     @OA\Property(property="idasignarsede", type="integer", example=1),
 *     @OA\Property(property="idusuario", type="integer", example=3),
 *     @OA\Property(property="idsede", type="integer", example=1),
 *     @OA\Property(property="estado", type="boolean", example=true),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class AsignarSedeSchema
{
    // Clase vacía solo para documentación OpenAPI
}
