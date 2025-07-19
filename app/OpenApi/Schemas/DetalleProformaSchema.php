<?php

namespace App\OpenApi\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 * schema="DetalleProformaSchema",
 * type="object",
 * required={"iddetalle", "idproforma", "idservicio", "cantidad", "urgente"},
 * @OA\Property(property="iddetalle", type="integer", example=1),
 * @OA\Property(property="idproforma", type="integer", example=7),
 * @OA\Property(property="idservicio", type="integer", example=14),
 * @OA\Property(property="descripcion", type="string", example="Servicio especializado"),
 * @OA\Property(property="cantidad", type="string", example="10.00"),
 * @OA\Property(property="precio", type="string", example="10.00"),
 * @OA\Property(property="urgente", type="string", example="1")
 * )
 */
class DetalleProformaSchema
{
    // Clase vacía, solo sirve para documentar el esquema en OpenAPI
}
