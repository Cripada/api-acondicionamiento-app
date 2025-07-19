<?php

namespace App\OpenApi\Schemas;

use OpenApi\Annotations as OA;


/**
 * @OA\Schema(
 * schema="ServiciosCategoriaSchema",
 * type="object",
 * required={"idcategoria", "nombre"},
 * @OA\Property(property="idcategoria", type="integer", example=1),
 * @OA\Property(property="nombre", type="string", example="Acondicionamiento"),
 * @OA\Property(property="descripcion", type="string", example="Preparación, acondicionamiento y embalaje de productos para su transporte o almacenamiento."),
 * @OA\Property(property="estado", type="string", example="1"),
 * @OA\Property(property="created_at", type="string", format="date-time", nullable=true),
 * @OA\Property(property="updated_at", type="string", format="date-time", nullable=true)
 * )
 */
class ServiciosCategoriaSchema
{
    // Clase vacía solo para documentación OpenAPI
}
