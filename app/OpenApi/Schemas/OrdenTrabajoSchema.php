<?php

namespace App\OpenApi\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="OrdenTrabajoSchema",
 *     type="object",
 *     required={"idorden", "idproforma", "responsable", "estado"},
 *     @OA\Property(property="idorden", type="integer", example=1),
 *     @OA\Property(property="idproforma", type="integer", example=1),
 *     @OA\Property(property="fecha_inicio", type="string", format="date", example="2025-07-05", nullable=true),
 *     @OA\Property(property="fecha_fin", type="string", format="date", example="2025-07-10", nullable=true),
 *     @OA\Property(property="idusuario_responsable", type="integer", example=1),
 *     @OA\Property(property="estado", type="string", example="Pendiente", enum={"Pendiente", "En progreso", "Finalizada", "Cancelada"}),
 *     @OA\Property(property="comentario", type="string", example="Trabajo urgente", nullable=true),
 *     @OA\Property(property="avance_general", type="number", format="float", example=75.50),
 *     @OA\Property(property="aprobada", type="boolean", example=false),
 *     @OA\Property(property="fecha_aprobacion", type="string", format="date", example="2025-07-06", nullable=true),
 *     @OA\Property(property="idusuario_aprueba", type="integer", example=3, nullable=true),
 *     @OA\Property(property="prioridad", type="string", example="Normal", enum={"Alta", "Media", "Baja", "Normal"}),
 *     @OA\Property(property="created_at", type="string", format="date-time", nullable=true),
 *     @OA\Property(property="updated_at", type="string", format="date-time", nullable=true),
 *     @OA\Property(property="deleted_at", type="string", format="date-time", nullable=true)
 * )
 */
class OrdenTrabajoSchema
{
    // Clase vacía, solo para documentación OpenAPI
}
