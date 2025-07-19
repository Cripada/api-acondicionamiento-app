<?php

namespace App\Http\Controllers;

use App\Models\Sede;
use App\Services\AuditoriaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

use OpenApi\Annotations as OA;

class SedeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/sedes",
     *     tags={"Sedes"},
     *     summary="Obtiene la lista de sedes",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de sedes",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/SedeSchema")
     *             )
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json(Sede::all());
    }

    /**
     * @OA\Get(
     *     path="/api/sedes/{idsede}",
     *     tags={"Sedes"},
     *     summary="Obtiene una sede específica",
     *     @OA\Parameter(
     *         name="idsede",
     *         in="path",
     *         required=true,
     *         description="ID de la sede",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sede encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/SedeSchema")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Sede no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Sede no encontrada.")
     *         )
     *     )
     * )
     */
    public function show($idsede): JsonResponse
    {
        $sede = Sede::find($idsede);

        if (!$sede) {
            return response()->json(
                [
                    'message' => 'Sede no encontrada.',
                ],
                404,
            );
        }

        return response()->json(
            [
                'data' => $sede,
            ],
            200,
        );
    }

    /**
     * @OA\Post(
     *     path="/api/sedes",
     *     summary="Crear un nuevo sede",
     *     description="Esta ruta permite crear una nueva sede con los datos proporcionados en la solicitud.",
     *     tags={"Sedes"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SedeSchema")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="sede creada con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="sede creada con éxito."),
     *             @OA\Property(property="data", ref="#/components/schemas/SedeSchema")
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
        // Configurar información de auditoría en el contexto SQL para la tabla "sedes"
        AuditoriaService::setContextInfo('ProcesosdeBodega');

        // Validación de datos
        $validated = $request->validate([
            'nombre' => 'required|string|max:150',
            'ubicacion' => 'required|string|max:255',
            'num_sucursal' => 'required|string|max:150',
            'num_actual_ot' => 'required|numeric',
            'num_actual_proforma' => 'required|numeric',
            'estado' => 'required|boolean',
        ]);

        // Crear un nuevo Sede
        $Sede = Sede::create([
            'nombre' => $validated['nombre'],
            'ubicacion' => $validated['ubicacion'],
            'num_sucursal' => $validated['num_sucursal'],
            'num_actual_ot' => $validated['num_actual_ot'],
            'num_actual_proforma' => $validated['num_actual_proforma'],
            'estado' => $validated['estado'],
        ]);

        // Devolver una respuesta JSON con el nuevo recurso creado
        return response()->json(
            [
                'message' => 'Sede creado con éxito.',
                'data' => $Sede,
            ],
            201,
        ); // Código de respuesta 201 - Creado
    }

    /**
     * @OA\Put(
     *     path="/api/sedes/{idcliente}",
     *     summary="Actualizar un sede",
     *     description="Esta ruta permite actualizar un sede existente.",
     *     tags={"Sedes"},
     *     @OA\Parameter(
     *         name="idcliente",
     *         in="path",
     *         required=true,
     *         description="ID del sede",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SedeSchema")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="sede actualizada con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="sede actualizada con éxito."),
     *             @OA\Property(property="data", ref="#/components/schemas/SedeSchema")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="sede no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="sede no encontrada.")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $idsede): JsonResponse
    {
        // Configurar información de auditoría en el contexto SQL para la tabla "sedes"
        AuditoriaService::setContextInfo('ProcesosdeBodega');

        $Sede = Sede::find($idsede);

        if (!$Sede) {
            return response()->json(
                [
                    'message' => 'Sede no encontrado.',
                ],
                404,
            );
        }

        // Validación de los datos
        $validated = $request->validate([
            'nombre' => 'required|string|max:150',
            'ubicacion' => 'required|string|max:255',
            'num_sucursal' => 'required|string|max:150',
            'num_actual_ot' => 'required|numeric',
            'num_actual_proforma' => 'required|numeric',
            'estado' => 'required|boolean',
        ]);

        // Actualizar el Sede
        $Sede->update([
            'nombre' => $validated['nombre'],
            'ubicacion' => $validated['ubicacion'],
            'num_sucursal' => $validated['num_sucursal'],
            'num_actual_ot' => $validated['num_actual_ot'],
            'num_actual_proforma' => $validated['num_actual_proforma'],
            'estado' => $validated['estado'],
        ]);

        return response()->json([
            'message' => 'Sede actualizado con éxito.',
            'data' => $Sede,
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/sedes/{idsede}",
     *     summary="Eliminar un Sede",
     *     description="Esta ruta permite eliminar una Sede existente.",
     *     tags={"Sedes"},
     *     @OA\Parameter(
     *         name="idsede",
     *         in="path",
     *         required=true,
     *         description="ID del Sede",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sede eliminada con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Sede eliminada con éxito.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Sede no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Sede no encontrada.")
     *         )
     *     )
     * )
     */
    public function destroy($idsede): JsonResponse
    {
        // Configurar información de auditoría en el contexto SQL para la tabla "sedes"
        AuditoriaService::setContextInfo('ProcesosdeBodega');

        $Sede = Sede::find($idsede);

        if (!$Sede) {
            return response()->json(
                [
                    'message' => 'Sede no encontrada.',
                ],
                404,
            );
        }

        $Sede->delete();

        return response()->json([
            'message' => 'Sede eliminada con éxito.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/sedes/paginated",
     *     tags={"Sedes"},
     *     summary="Obtiene la lista paginada de las sedes con búsqueda",
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
     *         description="Texto a buscar en el nombre de la sede",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista paginada de las sedes",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/SedeSchema")),
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
        $query = Sede::query();
        if ($search) {
            $query->where('nombre', 'like', '%' . $search . '%');
        }
        $sedes = $query->orderBy('idsede', 'asc')->paginate($perPage);
        return response()->json($sedes);
    }

    /**
     * @OA\Get(
     *     path="/api/sedes/app/select",
     *     tags={"Sedes"},
     *     summary="Obtiene la lista completa de las sedes para select",
     *     @OA\Response(
     *         response=200,
     *         description="Lista completa de las sedes",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/SedeSchema")
     *         )
     *     )
     * )
     */
    public function getSedesSelect(): JsonResponse
    {
        // Obtienes todos las sedes activos ordenados por nombre
        $sedes = Sede::select('idsede','nombre')
        ->where('estado', 1)
        ->orderBy('nombre', 'asc')
        ->get();

        return response()->json($sedes);
    }
}
