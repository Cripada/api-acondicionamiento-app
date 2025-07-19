<?php

namespace App\Http\Controllers;

use App\Models\Proforma;
use App\Models\ProformaAprobada;
use App\Services\AuditoriaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

use OpenApi\Annotations as OA;

class ProformaAprobadaController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/proformas-aprobadas",
     *     tags={"Proformas Aprobadas"},
     *     summary="Obtiene la lista de proformas aprobadas",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de proformas aprobadas",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/ProformaAprobadaSchema")
     *             )
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json(ProformaAprobada::all());
    }

    /**
     * @OA\Get(
     *     path="/api/proformas-aprobadas/{idaprobada}",
     *     tags={"Proformas Aprobadas"},
     *     summary="Obtiene una proforma aprobada específica",
     *     @OA\Parameter(
     *         name="idaprobada",
     *         in="path",
     *         required=true,
     *         description="ID de la proforma Aprobada",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Proformas Aprobadas encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/ProformaAprobadaSchema")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Proformas Aprobadas no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Proformas Aprobadas no encontrada.")
     *         )
     *     )
     * )
     */
    public function show($idaprobada): JsonResponse
    {
        $proformaAprobada = ProformaAprobada::find($idaprobada);

        if (!$proformaAprobada) {
            return response()->json(
                [
                    'message' => 'Proforma Aprobada no encontrada.',
                ],
                404,
            );
        }

        return response()->json(
            [
                'data' => $proformaAprobada,
            ],
            200,
        );
    }

    /**
     * @OA\Post(
     *     path="/api/proformas-aprobadas",
     *     summary="Crear un nuevo proforma Aprobada",
     *     description="Esta ruta permite crear una nueva proforma Aprobada con los datos proporcionados en la solicitud.",
     *     tags={"Proformas Aprobadas"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ProformaAprobadaSchema")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="proforma Aprobada creada con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="proforma Aprobada creada con éxito."),
     *             @OA\Property(property="data", ref="#/components/schemas/ProformaAprobadaSchema")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Datos de entrada no válidos",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Los datos proporcionados no son válidos.")
     *         )
     *     )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        // Configurar información de auditoría en el contexto SQL para la tabla "proformas Aprobadas"
        AuditoriaService::setContextInfo('ProcesosdeBodega');

        // Validación de datos
        $validated = $request->validate([
            'idproforma' => 'required|integer|exists:proformas,idproforma',
            'idusuario' => 'required|integer|exists:users,id',
            'idsede' => 'required|integer|exists:sedes,idsede',
            'fechaAutorizacion' => 'required|date',
            'comentario' => 'required|string|max:255',
        ]);

        $fecha = date('Y-m-d', strtotime($request->fechaAutorizacion));

        // Crear un nuevo Proformas Aprobadas
        $proformaAprobada = ProformaAprobada::create([
            'idproforma' => $validated['idproforma'],
            'idusuario' => $validated['idusuario'],
            'idsede' => $validated['idsede'],
            'fechaAutorizacion' => $fecha,
            'comentario' => $validated['comentario'],
        ]);

                // Buscar la proforma
        $proforma = Proforma::find($validated['idproforma']);
        if (!$proforma) {
            return response()->json(['message' => 'Proforma no encontrada'], 404);
        }
        $proforma->status = 'Autorizada'; // si quieres actualizar el estado, puedes cambiarlo o comentarlo
        $proforma->save();
        // Devolver una respuesta JSON con el nuevo recurso creado
        return response()->json(
            [
                'message' => 'Proforma Aprobada creada con éxito.',
                'data' => $proformaAprobada,
            ],
            201,
        ); // Código de respuesta 201 - Creado
    }

    /**
     * @OA\Put(
     *     path="/api/proformas-aprobadas/{idaprobada}",
     *     summary="Actualizar un proforma Aprobada",
     *     description="Esta ruta permite actualizar un proforma Aprobada existente.",
     *     tags={"Proformas Aprobadas"},
     *     @OA\Parameter(
     *         name="idaprobada",
     *         in="path",
     *         required=true,
     *         description="ID del proforma Aprobada",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ProformaAprobadaSchema")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="proforma Aprobada actualizada con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="proforma Aprobada actualizada con éxito."),
     *             @OA\Property(property="data", ref="#/components/schemas/ProformaAprobadaSchema")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="proforma Aprobada no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="proforma Aprobada no encontrada.")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $idaprobada): JsonResponse
    {
        // Configurar información de auditoría en el contexto SQL para la tabla "proformas Aprobadas"
        AuditoriaService::setContextInfo('ProcesosdeBodega');

        $proformaAprobada = ProformaAprobada::find($idaprobada);

        if (!$proformaAprobada) {
            return response()->json(
                [
                    'message' => 'Proforma Aprobada no encontrado.',
                ],
                404,
            );
        }

        // Validación de los datos
        $validated = $request->validate([
            'nombre' => 'required|string|max:150',
            'ubicacion' => 'required|string|max:255',
            'num_sucursal' => 'required|string|max:150',
            'num_actual_ot' => 'required|number',
            'num_actual_proforma' => 'required|number',
            'estado' => 'required|boolean',
        ]);

        // Actualizar el Proformas Aprobadas
        $proformaAprobada->update([
            'nombre' => $validated['nombre'],
            'ubicacion' => $validated['ubicacion'],
            'num_sucursal' => $validated['num_sucursal'],
            'num_actual_ot' => $validated['num_actual_ot'],
            'num_actual_proforma' => $validated['num_actual_proforma'],
            'estado' => $validated['estado'],
        ]);

        return response()->json([
            'message' => 'Proforma Aprobada actualizada con éxito.',
            'data' => $proformaAprobada,
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/proformas-aprobadas/{idaprobada}",
     *     summary="Eliminar un Proformas Aprobadas",
     *     description="Esta ruta permite eliminar una Proformas Aprobadas existente.",
     *     tags={"Proformas"},
     *     @OA\Parameter(
     *         name="idaprobada",
     *         in="path",
     *         required=true,
     *         description="ID del Proformas Aprobadas",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Proformas Aprobadas eliminada con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Proformas Aprobadas eliminada con éxito.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Proformas Aprobadas no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Proformas Aprobadas no encontrada.")
     *         )
     *     )
     * )
     */
    public function destroy($idaprobada): JsonResponse
    {
        // Configurar información de auditoría en el contexto SQL para la tabla "proformas Aprobadas"
        AuditoriaService::setContextInfo('ProcesosdeBodega');

        $proformaAprobada = ProformaAprobada::find($idaprobada);

        if (!$proformaAprobada) {
            return response()->json(
                [
                    'message' => 'Proforma Aprobada no encontrada.',
                ],
                404,
            );
        }

        $proformaAprobada->delete();

        return response()->json([
            'message' => 'Proforma Aprobada eliminada con éxito.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/proformas-aprobadas/paginated",
     *     tags={"Proformas Aprobadas"},
     *     summary="Obtiene la lista paginada de las proformas Aprobadas con búsqueda",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         description="Número de página",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         required=false,
     *         description="Cantidad de resultados por página",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         required=false,
     *         description="Texto a buscar en el nombre de la proforma Aprobada",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista paginada de las proformas Aprobadas",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/ProformaAprobadaSchema")),
     *             @OA\Property(property="total", type="integer", example=100),
     *             @OA\Property(property="per_page", type="integer", example=10),
     *             @OA\Property(property="current_page", type="integer", example=1),
     *             @OA\Property(property="last_page", type="integer", example=10)
     *         )
     *     )
     * )
     */
    public function paginated(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $search = $request->query('search');
        $query = ProformaAprobada::query();
        if ($search) {
            $query->where('nombre', 'like', '%' . $search . '%');
        }
        $proformaAprobada = $query->orderBy('idaprobada', 'asc')->paginate($perPage);
        return response()->json($proformaAprobada);
    }
}
