<?php

namespace App\OpenApi\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="DetalleOrdenTrabajoSchema",
 *     type="object",
 *     required={"iddetalle", "idorden", "idservicio", "cantidad", "produccionHora", "estado"},
 *     @OA\Property(property="iddetalle", type="integer", example=1),
 *     @OA\Property(property="idorden", type="integer", example=10),
 *     @OA\Property(property="idservicio", type="integer", example=5),
 *     @OA\Property(property="descripcion", type="string", example="Servicio especializado"),
 *     @OA\Property(property="cantidad", type="number", format="float", example=2.00),
 *     @OA\Property(property="produccionHora", type="number", format="float", example=2.00),
 *     @OA\Property(property="observacion", type="string", example="Se requiere orden de compra adicional", nullable=true),
 *     @OA\Property(property="avance", type="number", format="float", example=50.00),
 *     @OA\Property(property="estado", type="string", example="Pendiente", enum={"Pendiente", "En progreso", "Finalizado", "Cancelado"}),
 *     @OA\Property(property="created_at", type="string", format="date-time", nullable=true),
 *     @OA\Property(property="updated_at", type="string", format="date-time", nullable=true),
 *     @OA\Property(property="deleted_at", type="string", format="date-time", nullable=true)
 * )
 */
class DetalleOrdenTrabajoSchema
{
    // Clase vacía, solo para documentación OpenAPI
}

