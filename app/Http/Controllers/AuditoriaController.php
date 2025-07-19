<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

use OpenApi\Annotations as OA;

class AuditoriaController extends Controller
{
        /**
     * @OA\Get(
     *     path="/api/auditorias",
     *     summary="Obtiene la lista de las operaciones realizadas por los usuarios en la base de datos.",
     *     description="Esta ruta permite consultar todas las operaciones realizadas por los usuarios en la base de datos.",
     *     tags={"Auditoria"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de las operaciones realizadas por los usuarios",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="idauditoria", type="integer", example=1),
     *                 @OA\Property(property="tablaafectada", type="string", example="Roles"),
     *                 @OA\Property(property="operacion", type="string", example="Descripción de la operacion"),
     *                 @OA\Property(property="idregistro", type="integer", example=1),
     *                 @OA\Property(property="datosprevios", type="string", example="datos previos"),
     *                 @OA\Property(property="datosnuevos", type="string", example="datos nuevos"),
     *                 @OA\Property(property="usuario", type="string", example="usuario"),
     *                 @OA\Property(property="direccionip", type="string", example="direccion ip de la cual se realiza la operacion"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-27T12:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-27T12:00:00Z")
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        // Paginación
        $page = $request->query('page', 1);
        $limit = 100; // Limite de registros por página
        $offset = ($page - 1) * $limit;

        // Consulta paginada
        $auditorias = DB::select("SELECT * FROM [dbo].[auditorias] ORDER BY idauditoria OFFSET ? ROWS FETCH NEXT ? ROWS ONLY", [$offset, $limit]);
        return response()->json($auditorias);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Auditoria $auditoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Auditoria $auditoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Auditoria $auditoria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Auditoria $auditoria)
    {
        //
    }
}
