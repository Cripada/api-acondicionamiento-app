<?php

namespace App\OpenApi\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="AvanceOrdenTrabajoSchema",
 *     type="object",
 *     required={"idavance", "iddetalle", "idusuario", "fecha", "estado", "aprobado", "porcentaje_avance"},
 *     @OA\Property(property="idavance", type="integer", example=1),
 *     @OA\Property(property="iddetalle", type="integer", example=10),
 *     @OA\Property(property="idusuario", type="integer", example=5),
 *     @OA\Property(property="cantidad", type="number", format="float", example=1),
 *     @OA\Property(property="tiempo", type="string", format="time", nullable=true, example="02:30:00"),
 *     @OA\Property(property="fecha", type="string", format="date", example="2025-07-05"),
 *     @OA\Property(property="descripcion", type="string", nullable=true, example="Avance en la instalación eléctrica"),
 *     @OA\Property(property="estado", type="string", example="pendiente", enum={"pendiente", "en_progreso", "completado", "pausado"}),
 *     @OA\Property(property="aprobado", type="boolean", example=false),
 *     @OA\Property(property="observaciones", type="string", nullable=true, example="Esperando aprobación del supervisor"),
 *     @OA\Property(property="archivo_adjunto", type="string", nullable=true, example="documentos/foto123.jpg"),
 *     @OA\Property(property="porcentaje_avance", type="number", format="float", example=45.25),
 *     @OA\Property(property="created_at", type="string", format="date-time", nullable=true),
 *     @OA\Property(property="updated_at", type="string", format="date-time", nullable=true),
 *     @OA\Property(property="deleted_at", type="string", format="date-time", nullable=true)
 * )
 */
class AvanceOrdenTrabajoSchema
{
    // Clase vacía, solo para documentación OpenAPI
}