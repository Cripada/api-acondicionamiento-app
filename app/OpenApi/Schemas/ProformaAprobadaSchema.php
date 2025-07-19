<?php

namespace App\OpenApi\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="ProformaAprobadaSchema",
 *     type="object",
 *     title="Proforma",
 *     description="Estructura completa de una proforma con relaciones",
 *     @OA\Property(property="idaprobada", type="integer", example=1),
 *     @OA\Property(property="idproforma", type="integer", example=1),
 *     @OA\Property(property="idsede", type="integer", example=1),
 *     @OA\Property(property="idusuario", type="integer", example=1),
 *     @OA\Property(property="fechaAutorizacion", type="string", format="date", example="2025-06-11"),
 *     @OA\Property(property="comentario", type="string", example="Proforma autorizada sin novedades"),
 *     @OA\Property(
 *         property="usuario",
 *         ref="#/components/schemas/UsuarioSchema"
 *     ),
 *     @OA\Property(
 *         property="sede",
 *         ref="#/components/schemas/SedeSchema"
 *     )
 * )
 */
class ProformaAprobadaSchema
{
    // Clase vacía, solo sirve para documentar el esquema en OpenAPI
}
