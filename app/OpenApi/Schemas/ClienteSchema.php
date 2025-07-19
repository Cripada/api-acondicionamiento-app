<?php

namespace App\OpenApi\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="ClienteSchema",
 *     type="object",
 *     description="Esquema de datos del cliente",
 *     required={"idcliente", "ruc_cedula", "nombre_comercial", "direccion", "telefono", "email", "estado"},
 *     @OA\Property(property="idcliente", type="integer", example=1),
 *     @OA\Property(property="ruc_cedula", type="string", example="0912345678"),
 *     @OA\Property(property="nombre_comercial", type="string", example="Distribuidora El Buen Precio"),
 *     @OA\Property(property="direccion", type="string", example="Av. 9 de Octubre y García Moreno, Guayaquil"),
 *     @OA\Property(property="telefono", type="string", example="0987654321"),
 *     @OA\Property(property="email", type="string", format="email", example="contacto@cliente.com"),
 *     @OA\Property(property="estado", type="boolean", example=true),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-27T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-27T12:00:00Z")
 * )
 */
class ClienteSchema
{
    // Clase vacía solo para documentación OpenAPI
}
