<?php

namespace App\Http\Controllers;

use App\Models\TipoFacturacion;
use App\Services\AuditoriaService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use OpenApi\Annotations as OA;

class TipoFacturacionController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/tipo-de-facturacion",
     *     tags={"Tipo de facturación"},
     *     summary="Obtiene la lista de tipo de facturación",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de tipo de facturación",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/TipoFacturacionSchema")
     *             )
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json(TipoFacturacion::all());
    }

    /**
     * @OA\Get(
     *     path="/api/tipo-de-facturacion/paginated",
     *     tags={"Tipo de facturación"},
     *     summary="Obtiene la lista paginada de Tipo de facturación con búsqueda",
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
     *         description="Texto a buscar en el nombre del tipo de facturación"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista paginada de Tipo de facturación",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/TipoFacturacionSchema")),
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
        $query = TipoFacturacion::query();
        if ($search) {
            $query->where('nombre', 'like', '%' . $search . '%');
        }
        $tipoDeFacturacion = $query->orderBy('idTipoFacturacion', 'asc')->paginate($perPage);
        return response()->json($tipoDeFacturacion);
    }

    /**
     * @OA\Post(
     *     path="/api/tipo-de-facturacion",
     *     summary="Crear un nuevo tipo de facturación",
     *     description="Esta ruta permite crear un nuevo tipo de facturación con los datos proporcionados en la solicitud.",
     *     tags={"Tipo de facturación"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TipoFacturacionSchema")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="tipo de facturación creado con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="tipo de facturación creada con éxito."),
     *             @OA\Property(property="data", ref="#/components/schemas/TipoFacturacionSchema")
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
        // Configurar información de auditoría en el contexto SQL para la tabla "tipo de facturación"
        AuditoriaService::setContextInfo('tipo_de_facturacion');

        // Validación de los datos
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:150'],
            'descripcion' => ['required', 'string', 'max:200'],
            'estado' => ['required', 'boolean'],
        ]);

        // Crear un nuevo tipo_de_facturación
        $tipo_de_facturacion = TipoFacturacion::create([
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'],
            'estado' => $validated['estado'],
        ]);

        // Devolver una respuesta JSON con el nuevo recurso creado
        return response()->json(
            [
                'message' => 'tipo de facturación creado con éxito.',
                'data' => $tipo_de_facturacion,
            ],
            201,
        ); // Código de respuesta 201 - Creado
    }

    /**
     * @OA\Get(
     *     path="/api/tipo-de-facturacion/{idTipoFacturacion}",
     *     tags={"Tipo de facturación"},
     *     summary="Obtiene un tipo de facturación específico",
     *     @OA\Parameter(
     *         name="idTipoFacturacion",
     *         in="path",
     *         required=true,
     *         description="ID del tipo de facturación",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tipo de facturación encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/TipoFacturacionSchema")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tipo de facturación no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Tipo de facturación no encontrado.")
     *         )
     *     )
     * )
     */
    public function show($idTipoFacturacion): JsonResponse
    {
        $tipoDeFacturacion = TipoFacturacion::find($idTipoFacturacion);

        if (!$tipoDeFacturacion) {
            return response()->json(
                [
                    'message' => 'tipo de facturación no encontrado.',
                ],
                404,
            );
        }

        return response()->json(
            [
                'data' => $tipoDeFacturacion,
            ],
            200,
        );
    }

    /**
     * @OA\Put(
     *     path="/api/tipo-de-facturacion/{idTipoFacturacion}",
     *     summary="Actualizar un tipo de facturación",
     *     description="Esta ruta permite actualizar un tipo de facturación existente.",
     *     tags={"Tipo de facturación"},
     *     @OA\Parameter(
     *         name="idTipoFacturacion",
     *         in="path",
     *         required=true,
     *         description="ID del tipo de facturación",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TipoFacturacionSchema")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="tipo de facturación actualizado con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="tipo de facturacion actualizado con éxito."),
     *             @OA\Property(property="data", ref="#/components/schemas/TipoFacturacionSchema")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="tipo de facturación no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="tipo de facturacion no encontrado.")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $idTipoFacturacion): JsonResponse
    {
        // Configurar información de auditoría en el contexto SQL para la tabla "tipo de facturación"
        AuditoriaService::setContextInfo('tipo-de-facturacion');

        $tipo_de_facturacion = TipoFacturacion::find($idTipoFacturacion);

        if (!$tipo_de_facturacion) {
            return response()->json(
                [
                    'message' => 'tipo de facturación no encontrado.',
                ],
                404,
            );
        }

        // Validación de los datos
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:150'],
            'descripcion' => ['required', 'string', 'max:200'],
            'estado' => ['required', 'boolean'],
        ]);

        // Actualizar el tipo_de_facturacion
        $tipo_de_facturacion->update([
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'],
            'estado' => $validated['estado'],
        ]);

        return response()->json([
            'message' => 'tipo de facturación actualizado con éxito.',
            'data' => $tipo_de_facturacion,
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/tipo-de-facturacion/{idTipoFacturacion}",
     *     summary="Eliminar un tipo de facturación",
     *     description="Esta ruta permite eliminar un tipo de facturación existente.",
     *     tags={"Tipo de facturación"},
     *     @OA\Parameter(
     *         name="idTipoFacturacion",
     *         in="path",
     *         required=true,
     *         description="ID del tipo de facturación",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="tipo de facturación eliminado con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="tipo de facturación eliminado con éxito.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="tipo de facturación no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="tipo de facturación no encontrado.")
     *         )
     *     )
     * )
     */
    public function destroy($idTipoFacturacion): JsonResponse
    {
        // Configurar información de auditoría en el contexto SQL para la tabla "tipo_de_facturacion"
        AuditoriaService::setContextInfo('tipo-de-facturacion');

        $tipo_de_facturacion = TipoFacturacion::find($idTipoFacturacion);

        if (!$tipo_de_facturacion) {
            return response()->json(
                [
                    'message' => 'tipo de facturación no encontrado.',
                ],
                404,
            );
        }

        $tipo_de_facturacion->delete();

        return response()->json([
            'message' => 'tipo de facturación eliminado con éxito.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/tipo-de-facturacion/app/select",
     *     tags={"Tipo de facturación"},
     *     summary="Obtiene la lista completa de tipo de facturacion para select",
     *     @OA\Response(
     *         response=200,
     *         description="Lista completa de tipo de facturacion",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/TipoFacturacionSchema")
     *         )
     *     )
     * )
     */
    public function getTipoFacturacionSelect(): JsonResponse
    {
        // Obtienes todos los clientes activos
        $clientes = TipoFacturacion::select('idTipoFacturacion', 'nombre')->where('estado', 1)->orderBy('nombre', 'asc')->get();

        return response()->json($clientes);
    }
}
