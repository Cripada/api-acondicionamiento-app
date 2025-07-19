<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Services\AuditoriaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

use OpenApi\Annotations as OA;

class ServiciosController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/servicios",
     *     tags={"Servicios"},
     *     summary="Obtiene la lista de servicios",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de servicios",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="idservicio", type="integer", example=1),
     *                 @OA\Property(property="nombre", type="string", example="Servicio A"),
     *                 @OA\Property(property="descripcion", type="string", example="Descripción del servicio A"),
     *                 @OA\Property(property="produccionHora", type="number", example=1),
     *                 @OA\Property(property="estado", type="boolean", example=true),
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
        $limit = 10; // Limite de registros por página
        $offset = ($page - 1) * $limit;

        // Consulta paginada
        //$servicios = DB::select("SELECT * FROM [dbo].[servicios] ORDER BY idservicio OFFSET ? ROWS FETCH NEXT ? ROWS ONLY", [$offset, $limit]);
        $servicios = DB::select('SELECT * FROM [dbo].[servicios]');
        return response()->json($servicios);
    }

    /**
     * @OA\Get(
     *     path="/api/servicios/paginated",
     *     tags={"Servicios"},
     *     summary="Obtiene la lista paginada de servicios con búsqueda",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer"),
     *         description="Número de página"
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer"),
     *         description="Cantidad de resultados por página"
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string"),
     *         description="Texto a buscar en el nombre del servicio"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista paginada de servicios",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/ServicioSchema")),
     *             @OA\Property(property="total", type="integer", example=100),
     *             @OA\Property(property="per_page", type="integer", example=10),
     *             @OA\Property(property="current_page", type="integer", example=1),
     *             @OA\Property(property="last_page", type="integer", example=10)
     *         )
     *     )
     * )
     */
    public function paginated(Request $request): JsonResponse
    {
        $perPage = $request->query('per_page', 10);
        $search = $request->query('search');

        $query = Servicio::query();

        $query->where(function ($q) use ($search) {
            $q->where('nombre', 'like', '%' . $search . '%')
              ->orWhere('descripcion', 'like', '%' . $search . '%');
        });

        $servicios = $query->orderBy('idservicio', 'asc')->paginate($perPage);

        return response()->json($servicios);
    }

    /**
     * @OA\Post(
     *     path="/api/servicios",
     *     summary="Crear un nuevo servicio",
     *     description="Esta ruta permite crear un nuevo servicio con los datos proporcionados en la solicitud.",
     *     tags={"Servicios"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre", "descripcion", "produccionHora", "estado"},
     *             @OA\Property(property="nombre", type="string", example="Nuevo Servicio", description="Nombre del servicio"),
     *             @OA\Property(property="descripcion", type="string", example="Descripción detallada del servicio", description="Descripción del servicio"),
     *             @OA\Property(property="produccionHora", type="number", example=1),
     *             @OA\Property(property="estado", type="boolean", example=true, description="Estado del servicio (activo o inactivo)")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Servicio creado con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Servicio creado con éxito."),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="idservicio", type="integer", example=1),
     *                 @OA\Property(property="nombre", type="string", example="Nuevo Servicio"),
     *                 @OA\Property(property="descripcion", type="string", example="Descripción detallada del servicio"),
     *                 @OA\Property(property="produccionHora", type="number", example=1),
     *                 @OA\Property(property="estado", type="boolean", example=true),
     *             )
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
        // Configurar información de auditoría en el contexto SQL para la tabla "servicios"
        AuditoriaService::setContextInfo('ProcesosdeServicios');

        // Validación de datos
        $validated = $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'required|string|max:255',
            'produccionHora' => 'required|numeric',
            'estado' => 'required|boolean',
        ]);

        // Crear un nuevo servicio
        $servicio = Servicio::create([
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'],
            'produccionHora' => $validated['produccionHora'],
            'estado' => $validated['estado'],
        ]);

        // Devolver una respuesta JSON con el nuevo recurso creado
        return response()->json(
            [
                'message' => 'Servicio creado con éxito.',
                'data' => $servicio,
            ],
            201,
        ); // Código de respuesta 201 - Creado
    }

    /**
     * @OA\Get(
     *     path="/api/servicios/{idservicio}",
     *     tags={"Servicios"},
     *     summary="Obtiene un servicio específico",
     *     @OA\Parameter(
     *         name="idservicio",
     *         in="path",
     *         required=true,
     *         description="ID del servicio",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Servicio encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="idservicio", type="integer", example=1),
     *             @OA\Property(property="nombre", type="string", example="Nuevo Servicio"),
     *             @OA\Property(property="descripcion", type="string", example="Descripción detallada del servicio"),
     *             @OA\Property(property="produccionHora", type="number", example=1),
     *             @OA\Property(property="estado", type="boolean", example=true),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-27T12:00:00Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-27T12:00:00Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Servicio no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Servicio no encontrado.")
     *         )
     *     )
     * )
     */
    public function show($idservicio): JsonResponse
    {
        $servicio = Servicio::find($idservicio);

        if (!$servicio) {
            return response()->json(
                [
                    'message' => 'Servicio no encontrado.',
                ],
                404,
            );
        }

        return response()->json($servicio);
    }

    /**
     * @OA\Put(
     *     path="/api/servicios/{idservicio}",
     *     summary="Actualizar un servicio",
     *     description="Esta ruta permite actualizar un servicio existente.",
     *     tags={"Servicios"},
     *     @OA\Parameter(
     *         name="idservicio",
     *         in="path",
     *         required=true,
     *         description="ID del servicio",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre", "descripcion", "produccionHora", "estado"},
     *             @OA\Property(property="nombre", type="string", example="Servicio Actualizado", description="Nombre del servicio"),
     *             @OA\Property(property="descripcion", type="string", example="Descripción actualizada", description="Descripción del servicio"),
     *             @OA\Property(property="produccionHora", type="number", example=1),
     *             @OA\Property(property="estado", type="boolean", example=false, description="Estado del servicio (activo o inactivo)")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Servicio actualizado con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Servicio actualizado con éxito."),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Servicio no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Servicio no encontrado.")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $idservicio): JsonResponse
    {
        // Configurar información de auditoría en el contexto SQL para la tabla "servicios"
        AuditoriaService::setContextInfo('ProcesosdeServicios');

        $servicio = Servicio::find($idservicio);

        if (!$servicio) {
            return response()->json(
                [
                    'message' => 'Servicio no encontrado.',
                ],
                404,
            );
        }

        // Validación de los datos
        $validated = $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'required|string|max:255',
            'produccionHora' => 'required|numeric',
            'estado' => 'required|boolean',
        ]);

        // Actualizar el servicio
        $servicio->update([
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'],
            'produccionHora' => $validated['produccionHora'],
            'estado' => $validated['estado'],
        ]);

        return response()->json([
            'message' => 'Servicio actualizado con éxito.',
            'data' => $servicio,
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/servicios/{idservicio}",
     *     summary="Eliminar un servicio",
     *     description="Esta ruta permite eliminar un servicio existente.",
     *     tags={"Servicios"},
     *     @OA\Parameter(
     *         name="idservicio",
     *         in="path",
     *         required=true,
     *         description="ID del servicio",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Servicio eliminado con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Servicio eliminado con éxito.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Servicio no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Servicio no encontrado.")
     *         )
     *     )
     * )
     */
    public function destroy($idservicio): JsonResponse
    {
        // Configurar información de auditoría en el contexto SQL para la tabla "servicios"
        AuditoriaService::setContextInfo('ProcesosdeServicios');

        $servicio = Servicio::find($idservicio);

        if (!$servicio) {
            return response()->json(
                [
                    'message' => 'Servicio no encontrado.',
                ],
                404,
            );
        }

        $servicio->delete();

        return response()->json([
            'message' => 'Servicio eliminado con éxito.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/servicios/select",
     *     tags={"Clientes"},
     *     summary="Obtiene la lista completa de servicios para select",
     *     @OA\Response(
     *         response=200,
     *         description="Lista completa de servicios",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/ServicioSchema")
     *         )
     *     )
     * )
     */
    public function getServiciosSelect(): JsonResponse
    {
        // Obtienes todos los clientes activos
        $servicios = Servicio::select('idservicio', 'nombre')->where('estado', 1)->orderBy('nombre', 'asc')->get();

        return response()->json($servicios);
    }
}
