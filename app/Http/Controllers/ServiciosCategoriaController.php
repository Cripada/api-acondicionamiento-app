<?php

namespace App\Http\Controllers;

use App\Models\serviciosCategoria;
use App\Services\AuditoriaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

use OpenApi\Annotations as OA;

class ServiciosCategoriaController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/categorias-servicios",
     *     tags={"Categorias de servicios"},
     *     summary="Obtiene la lista de categorias de servicios",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de categorias de servicios",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/ServiciosCategoriaSchema")
     *             )
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json(serviciosCategoria::all());
    }

    /**
     * @OA\Get(
     *     path="/api/categorias-servicios/{idcategoria}",
     *     tags={"Categorias de servicios"},
     *     summary="Obtiene una categoria de servicios específica",
     *     @OA\Parameter(
     *         name="idcategoria",
     *         in="path",
     *         required=true,
     *         description="ID de la categoria de servicios",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Categorias de servicios encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/ServiciosCategoriaSchema")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Categorias de servicios no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Categoria de servicios no encontrada.")
     *         )
     *     )
     * )
     */
    public function show($idcategoria): JsonResponse
    {
        $categoria = serviciosCategoria::find($idcategoria);

        if (!$categoria) {
            return response()->json(
                [
                    'message' => 'Categoria de servicios no encontrada.',
                ],
                404,
            );
        }

        return response()->json(
            [
                'data' => $categoria,
            ],
            200,
        );
    }

    /**
     * @OA\Post(
     *     path="/api/categorias-servicios",
     *     summary="Crear un nuevo categoria de servicios",
     *     description="Esta ruta permite crear una nueva categoria de servicios con los datos proporcionados en la solicitud.",
     *     tags={"Categorias de servicios"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ServiciosCategoriaSchema")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="categoria creada con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="categoria de servicios creada con éxito."),
     *             @OA\Property(property="data", ref="#/components/schemas/ServiciosCategoriaSchema")
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
        // Configurar información de auditoría en el contexto SQL para la tabla "categorias"
        AuditoriaService::setContextInfo('ProcesosdeBodega');

        // Validación de datos
        $validated = $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'string|max:255',
            'estado' => 'required|boolean',
        ]);

        // Crear un nuevo
        $Categorias = serviciosCategoria::create([
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'],
            'estado' => $validated['estado'],
        ]);

        // Devolver una respuesta JSON con el nuevo recurso creado
        return response()->json(
            [
                'message' => 'Categoria de servicios creado con éxito.',
                'data' => $Categorias,
            ],
            201,
        ); // Código de respuesta 201 - Creado
    }

    /**
     * @OA\Put(
     *     path="/api/categorias-servicios/{idcliente}",
     *     summary="Actualizar un categoria",
     *     description="Esta ruta permite actualizar un categoria existente.",
     *     tags={"Categorias de servicios"},
     *     @OA\Parameter(
     *         name="idcliente",
     *         in="path",
     *         required=true,
     *         description="ID del categoria",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ServiciosCategoriaSchema")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="categoria actualizada con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="categoria actualizada con éxito."),
     *             @OA\Property(property="data", ref="#/components/schemas/ServiciosCategoriaSchema")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="categoria no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="categoria no encontrada.")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $idcategoria): JsonResponse
    {
        // Configurar información de auditoría en el contexto SQL para la tabla "categorias"
        AuditoriaService::setContextInfo('ProcesosdeBodega');

        $Categorias = serviciosCategoria::find($idcategoria);

        if (!$Categorias) {
            return response()->json(
                [
                    'message' => 'Categoria de servicios no encontrado.',
                ],
                404,
            );
        }

        // Validación de los datos
        $validated = $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'string|max:255',
            'estado' => 'required|boolean',
        ]);

        // Actualizar
        $Categorias->update([
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'],
            'estado' => $validated['estado'],
        ]);

        return response()->json([
            'message' => 'Categoria de servicios actualizado con éxito.',
            'data' => $Categorias,
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/categorias-servicios/{idcategoria}",
     *     summary="Eliminar una categoria",
     *     description="Esta ruta permite eliminar una categoria existente.",
     *     tags={"Categorias de servicios"},
     *     @OA\Parameter(
     *         name="idcategoria",
     *         in="path",
     *         required=true,
     *         description="ID de la categoria",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Categoria de servicios eliminada con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Categoria de servicios eliminada con éxito.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Categoria de servicios no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Categoria de servicios no encontrada.")
     *         )
     *     )
     * )
     */
    public function destroy($idcategoria): JsonResponse
    {
        // Configurar información de auditoría en el contexto SQL para la tabla "categorias"
        AuditoriaService::setContextInfo('ProcesosdeBodega');

        $Categorias = serviciosCategoria::find($idcategoria);

        if (!$Categorias) {
            return response()->json(
                [
                    'message' => 'Categoria de servicios no encontrada.',
                ],
                404,
            );
        }

        $Categorias->delete();

        return response()->json([
            'message' => 'Categoria de servicios eliminada con éxito.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/categorias-servicios/paginated",
     *     tags={"Categorias de servicios"},
     *     summary="Obtiene la lista paginada de las categorias con búsqueda",
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
     *         description="Texto a buscar en el nombre de la categoria",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista paginada de las categorias",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/ServiciosCategoriaSchema")),
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
        $query = serviciosCategoria::query();
        if ($search) {
            $query->where('nombre', 'like', '%' . $search . '%');
        }
        $categorias = $query->orderBy('idcategoria', 'asc')->paginate($perPage);
        return response()->json($categorias);
    }

    /**
     * @OA\Get(
     *     path="/api/categorias-servicios/app/select",
     *     tags={"Categorias de servicios"},
     *     summary="Obtiene la lista completa de las categorias para select",
     *     @OA\Response(
     *         response=200,
     *         description="Lista completa de las categorias",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/ServiciosCategoriaSchema")
     *         )
     *     )
     * )
     */
    public function getServiciosCategoriaSelect(): JsonResponse
    {
        // Obtienes todos las categorias activos ordenados por nombre
        $categorias = serviciosCategoria::select('idcategoria', 'nombre')
            ->where('estado', 1)
            ->orderBy('nombre', 'asc')
            ->get();

        return response()->json($categorias);
    }
}
