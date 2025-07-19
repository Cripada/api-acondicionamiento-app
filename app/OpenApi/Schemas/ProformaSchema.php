<?php

namespace App\OpenApi\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="ProformaSchema",
 *     type="object",
 *     title="Proforma",
 *     description="Estructura completa de una proforma con relaciones",
 *     @OA\Property(property="idproforma", type="integer", example=1),
 *     @OA\Property(property="num_proforma", type="string", example="-"),
 *     @OA\Property(property="num_ot", type="string", example="-"),
 *     @OA\Property(property="num_actualizacion", type="string", example="-"),
 *     @OA\Property(property="idsede", type="integer", example=1),
 *     @OA\Property(property="idcliente", type="integer", example=1),
 *     @OA\Property(property="idusuario", type="integer", example=1),
 *     @OA\Property(property="idTipoFacturacion", type="integer", example=2),
 *     @OA\Property(property="fechaEmision", type="string", format="date", example="2025-06-11"),
 *     @OA\Property(property="fechaEstimadaInicio", type="string", format="date", example="2025-06-15"),
 *     @OA\Property(property="fechaEstimadaFinalizacion", type="string", format="date", example="2025-06-18"),
 *     @OA\Property(property="horasEstimadas", type="string", example="10:59:59"),
 *     @OA\Property(property="correo", type="string", example="cliente@empresa.com"),
 *     @OA\Property(property="comentario", type="string", example="Observaciones generales"),
 *     @OA\Property(property="solicitante", type="string", example="Juan Pérez"),
 *     @OA\Property(property="status", type="string", example="Pendiente"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-06-11T10:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-06-11T12:34:56Z"),
 *     @OA\Property(
 *         property="usuario",
 *         ref="#/components/schemas/UsuarioSchema"
 *     ),
 *     @OA\Property(
 *         property="cliente",
 *         ref="#/components/schemas/ClienteSchema"
 *     ),
 *     @OA\Property(
 *         property="tipoFacturacion",
 *         ref="#/components/schemas/TipoFacturacionSchema"
 *     ),
 *     @OA\Property(
 *         property="detalles",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/DetalleProformaSchema")
 *     )
 * )
 */
class ProformaSchema
{
    // Clase vacía, solo sirve para documentar el esquema en OpenAPI
}
