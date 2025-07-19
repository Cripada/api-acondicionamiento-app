<?php

namespace App\Http\Controllers;

use App\Models\PrecioServicios;
use App\Services\AuditoriaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

use OpenApi\Annotations as OA;

class PrecioServiciosController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/precio-servicios",
     *     tags={"Precio Servicios"},
     *     summary="Obtiene la lista de precio servicios",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de precio servicios",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/PrecioServicioSchema")
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
        //$precio servicios = DB::select("SELECT * FROM [dbo].[precio servicios] ORDER BY idservicio OFFSET ? ROWS FETCH NEXT ? ROWS ONLY", [$offset, $limit]);
        $precioServicios = DB::select('SELECT * FROM [dbo].[precioServicios]');
        return response()->json($precioServicios);
    }

    /**
     * @OA\Post(
     *     path="/api/precio-servicios",
     *     summary="Crear un nuevo servicio",
     *     description="Esta ruta permite crear un nuevo servicio con los datos proporcionados en la solicitud.",
     *     tags={"Precio Servicios"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/PrecioServicioSchema")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Precio Servicio creado con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Precio Servicio creado con éxito."),
     *             @OA\Property(property="data", ref="#/components/schemas/PrecioServicioSchema")
     *         )
     *     )
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
        // Configurar información de auditoría en el contexto SQL para la tabla "precio servicios"
        AuditoriaService::setContextInfo('ProcesosdePrecioServicios');

        // Validación de datos
        $validated = $request->validate([
            'idservicio' => 'required|integer|exists:servicios,idservicio',
            'rangouno' => 'required|integer|min:1',
            'rangodos' => 'required|integer|gt:rangouno',
            'valor' => 'required|numeric|min:0',
            'estado' => 'required|boolean',
        ]);

        // Crear un nuevo servicio
        $precioServicios = PrecioServicios::create([
            'idservicio' => $validated['idservicio'],
            'rangouno' => $validated['rangouno'],
            'rangodos' => $validated['rangodos'],
            'valor' => $validated['valor'],
            'estado' => $validated['estado'],
        ]);

        // Devolver una respuesta JSON con el nuevo recurso creado
        return response()->json(
            [
                'message' => 'Precio Servicio creado con éxito.',
                'data' => $precioServicios,
            ],
            201,
        ); // Código de respuesta 201 - Creado
    }

    /**
     * @OA\Get(
     *     path="/api/precio-servicios/{idPrecioServicio}",
     *     tags={"Precio Servicios"},
     *     summary="Obtiene un servicio específico",
     *     @OA\Parameter(
     *         name="idPrecioServicio",
     *         in="path",
     *         required=true,
     *         description="ID del servicio",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Precio Servicio encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/PrecioServicioSchema")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Precio Servicio no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Precio Servicio no encontrado.")
     *         )
     *     )
     * )
     */
    public function show($idPrecioServicio): JsonResponse
    {
        $precioServicio = PrecioServicios::find($idPrecioServicio);

        if (!$precioServicio) {
            return response()->json(
                [
                    'message' => 'Precio Servicio no encontrado.',
                ],
                404,
            );
        }

        return response()->json(
            [
                'data' => $precioServicio,
            ],
            200,
        );
    }

    /**
     * @OA\Get(
     *     path="/api/precio-servicios/paginated/{idServicio}",
     *     tags={"Precio Servicios"},
     *     summary="Obtiene la lista paginada de rangos de precios de un servicio específico",
     *     @OA\Parameter(
     *         name="idServicio",
     *         in="path",
     *         required=true,
     *         description="ID del servicio",
     *         @OA\Schema(type="integer")
     *     ),
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
     *         @OA\Parameter(
     *         name="search",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer"),
     *         description="Numero del inicio o final del rango buscado"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista paginada de precios del servicio",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/PrecioServicioSchema")),
     *             @OA\Property(property="total", type="integer", example=50),
     *             @OA\Property(property="per_page", type="integer", example=10),
     *             @OA\Property(property="current_page", type="integer", example=1),
     *             @OA\Property(property="last_page", type="integer", example=5)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Precios del servicio no encontrados",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="No se encontraron precios para el servicio especificado.")
     *         )
     *     )
     * )
     */
    public function obtenerPreciosPorIdServicio(Request $request, $idServicio): JsonResponse
    {
        $perPage = $request->query('per_page', 10);
        $search = $request->query('search');

        $query = PrecioServicios::where('idservicio', $idServicio);

        if (!$query->exists()) {
            return response()->json(
                [
                    'message' => 'No se encontraron precios para el servicio especificado.',
                ],
                404,
            );
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('rangouno', 'like', '%' . $search . '%')
                    ->orWhere('rangodos', 'like', '%' . $search . '%');
            });
        }
        $precios = $query->orderBy('idprecioservicio', 'asc')->paginate($perPage);

        return response()->json($precios);
    }


    /**
     * @OA\Get(
     *     path="/api/precio-servicios/lista/{idServicio}",
     *     tags={"Precio Servicios"},
     *     summary="Obtiene la lista paginada de rangos de precios de un servicio específico",
     *     @OA\Parameter(
     *         name="idServicio",
     *         in="path",
     *         required=true,
     *         description="ID del servicio",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista paginada de precios del servicio",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/PrecioServicioSchema"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Precios del servicio no encontrados",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="No se encontraron precios para el servicio especificado.")
     *         )
     *     )
     * )
     */
    public function oPreciosPorIdServicio($idServicio): JsonResponse
    {
        $precios = PrecioServicios::query()
            ->where('idservicio', $idServicio)
            ->get();

        return response()->json($precios);
    }

    /**
     * @OA\Put(
     *     path="/api/precio-servicios/{idPrecioServicio}",
     *     summary="Actualizar un servicio",
     *     description="Esta ruta permite actualizar un servicio existente.",
     *     tags={"Precio Servicios"},
     *     @OA\Parameter(
     *         name="idPrecioServicio",
     *         in="path",
     *         required=true,
     *         description="ID del servicio",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/PrecioServicioSchema")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Precio Servicio actualizado con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Precio Servicio actualizado con éxito."),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Precio Servicio no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Precio Servicio no encontrado.")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $idPrecioServicio): JsonResponse
    {
        // Configurar información de auditoría en el contexto SQL para la tabla "precio servicios"
        AuditoriaService::setContextInfo('ProcesosdePrecioServicios');

        $precioServicio = PrecioServicios::find($idPrecioServicio);

        if (!$precioServicio) {
            return response()->json(
                [
                    'message' => 'Precio Servicio no encontrado.',
                ],
                404,
            );
        }

        // Validar los datos de la solicitud
        $validated = $request->validate([
            'idservicio' => 'required|integer|exists:servicios,idservicio',
            'rangouno' => 'required|integer|min:1',
            'rangodos' => 'required|integer|gt:rangouno',
            'valor' => 'required|numeric|min:0',
            'estado' => 'required|boolean',
        ]);

        // Actualizar el registro de PrecioServicio
        $precioServicio->update([
            'idservicio' => $validated['idservicio'],
            'rangouno' => $validated['rangouno'],
            'rangodos' => $validated['rangodos'],
            'valor' => $validated['valor'],
            'estado' => $validated['estado'],
        ]);

        return response()->json([
            'message' => 'Precio Servicio actualizado con éxito.',
            'data' => $precioServicio,
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/precio-servicios/{idPrecioServicio}",
     *     summary="Eliminar un servicio",
     *     description="Esta ruta permite eliminar un servicio existente.",
     *     tags={"Precio Servicios"},
     *     @OA\Parameter(
     *         name="idPrecioServicio",
     *         in="path",
     *         required=true,
     *         description="ID del precio servicio",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Precio Servicio eliminado con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Precio Servicio eliminado con éxito.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Precio Servicio no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Precio Servicio no encontrado.")
     *         )
     *     )
     * )
     */
    public function destroy($idPrecioServicio): JsonResponse
    {
        // Configurar información de auditoría en el contexto SQL para la tabla "precio servicios"
        AuditoriaService::setContextInfo('ProcesosdePrecioServicios');

        $precioServicio = PrecioServicios::find($idPrecioServicio);

        if (!$precioServicio) {
            return response()->json(
                [
                    'message' => 'Precio Servicio no encontrado.',
                ],
                404,
            );
        }

        $precioServicio->delete();

        return response()->json([
            'message' => 'Precio Servicio eliminado con éxito.',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/precio-servicios/rango",
     *     summary="Obtiene el precio por cantidad de un servicio",
     *     tags={"Precio Servicios"},
     *     description="Dado un ID de servicio y una cantidad, retorna el precio unitario correspondiente al rango de precios definido.",
     *     operationId="obtenerPrecioPorCantidad",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"idservicio", "cantidad"},
     *             @OA\Property(property="idservicio", type="integer", example=5, description="ID del servicio"),
     *             @OA\Property(property="cantidad", type="number", format="float", example=12, description="Cantidad seleccionada")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Precio unitario encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="precio_unitario", type="number", format="float", example=15.50),
     *             @OA\Property(property="rango", type="string", example="10 - 20")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Rango no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="No se encontró un rango de precios válido para la cantidad ingresada.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validación fallida",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(property="idservicio", type="array", @OA\Items(type="string")),
     *                 @OA\Property(property="cantidad", type="array", @OA\Items(type="string"))
     *             )
     *         )
     *     )
     * )
     */
    public function obtenerPrecioPorCantidad(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'idservicio' => 'required|integer|exists:precioServicios,idservicio',
            'cantidad' => 'required|numeric|min:0.01',
        ]);

        $precio = PrecioServicios::where('idservicio', $validated['idservicio'])
            ->where('estado', true)
            ->get()
            ->first(function ($registro) use ($validated) {
                $cantidad = floatval($validated['cantidad']);
                return $cantidad >= floatval($registro->rangouno) && $cantidad <= floatval($registro->rangodos);
            });

        if (!$precio) {
            return response()->json(
                [
                    'error' => 'No se encontró un rango de precios válido para la cantidad ingresada.',
                ],
                404,
            );
        }

        return response()->json([
            'precio_unitario' => $precio->valor,
            'rango' => "{$precio->rangouno} - {$precio->rangodos}",
        ]);
    }
}
