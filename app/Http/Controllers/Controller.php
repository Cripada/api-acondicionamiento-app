<?php

namespace App\Http\Controllers;


/**
 * @OA\Info(
 *     title="API sistema de 'SERVICIOS DE ACONDICIONAMIENTO'",
 *     version="1.0.0",
 *     description="La acondicionamiento API - servicio de ACONDICIONAMIENTO permite a los usuarios gestionar y acceder de manera eficiente a la información relacionada con los procesos de acondicionamiento. Proporciona endpoints seguros y escalables para realizar operaciones y consultas sobre productos, etapas del acondicionamiento y recursos involucrados. Con una estructura bien definida y soporte para paginación, la API facilita la integración con aplicaciones externas y mejora la visibilidad y control de los servicios de acondicionamiento en tiempo real.",
 * ),
 *     @OA\Tag(
 *         name="Usuarios",
 *         description="Operaciones relacionadas con los Proceso de Usuarios."
 *     ),
 *     @OA\Tag(
 *         name="Auditoria",
 *         description="Lleva el control de las operaciones realizadas por los usuarios en la base de datos."
 *     ),
 *     @OA\Tag(
 *         name="Procesos",
 *         description="Operaciones relacionadas con los Proceso de Bodegas"
 *     ),
 *     @OA\Tag(
 *         name="Roles",
 *         description="Operaciones relacionadas con los Roles de Usuario"
 *     ),
 *     @OA\Tag(
 *         name="Sedes",
 *         description="Operaciones relacionadas con las sedes de las bodegas de almacenamiento"
 *     ),
 *     @OA\Tag(
 *         name="Bodegas",
 *         description="Operaciones relacionadas con las bodegas de almacenamiento"
 *     ),
 *    @OA\Tag(
 *         name="Puertas",
 *         description="Operaciones relacionadas con las puertas de las bodegas de almacenamiento"
 *     ),
 *     @OA\Tag(
 *         name="Urgentes",
 *         description="Operaciones relacionadas con los Urgentes de despachos"
 *     ),
 *     @OA\Tag(
 *         name="Permisos",
 *         description="Operaciones relacionadas con los Permisos de usuarios"
 *     ),
 *     @OA\Tag(
 *         name="Vehiculos",
 *         description="Operaciones relacionadas con los Vehiculos"
 *     ),
 *     @OA\Tag(
 *         name="Transportistas",
 *         description="Operaciones relacionadas con los Transportistas"
 *     ),
 *     @OA\Tag(
 *         name="Tipo de transportes",
 *         description="Operaciones relacionadas con los Tipo de transporte"
 *     ),
 *     @OA\Tag(
 *         name="Tipo de unidad",
 *         description="Operaciones relacionadas con los Tipo de unidad"
 *     ),
 *     @OA\Tag(
 *         name="Envio de correo",
 *         description="Envía un correo con un archivo PDF adjunto."
 *     ),
 *     @OA\Tag(
 *         name="Tipo de facturación",
 *         description="El tipo de facturación es el método acordado con el cliente para emitir la proforma, especificando la forma, periodicidad y condiciones del cobro."
 *     ),
 *     @OA\Tag(
 *         name="Facturación", 
 *         description="Gestión de registros de facturación de proformas"
 *     ),
 *     @OA\Tag(
 *         name="Parámetros", 
 *         description="Gestión de parámetros del sistema"
 *     ),
 */
abstract class Controller
{
    //
}
