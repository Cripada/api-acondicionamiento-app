<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use App\Services\AuditoriaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

use OpenApi\Annotations as OA;

class PermisoController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/permisos",
     *     tags={"Permisos"},
     *     summary="Obtiene la lista de permisos",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de permisos",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="idpermiso", type="integer", example=1),
     *                 @OA\Property(property="nombre", type="string", example="Permiso A"),
     *                 @OA\Property(property="descripcion", type="string", example="Descripción del permiso A"),
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
        $limit = 20; // Limite de registros por página
        $offset = ($page - 1) * $limit;

        
        // Consulta paginada
        //$permisos = DB::select("SELECT * FROM [dbo].[permisos] ORDER BY idpermiso OFFSET ? ROWS FETCH NEXT ? ROWS ONLY", [$offset, $limit]);
         $permisos = Permiso::all();
        return response()->json($permisos);
    }

    /**
     * @OA\Post(
     *     path="/api/permisos",
     *     summary="Crear un nuevo permiso",
     *     description="Esta ruta permite crear un nuevo permiso con los datos proporcionados en la solicitud.",
     *     tags={"Permisos"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre", "descripcion", "estado"},
     *             @OA\Property(property="nombre", type="string", example="Nuevo Permiso", description="Nombre del permiso"),
     *             @OA\Property(property="descripcion", type="string", example="Descripción detallada del permiso", description="Descripción del permiso"),
     *             @OA\Property(property="estado", type="boolean", example=true, description="Estado del permiso (activo o inactivo)")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Permiso creado con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Permiso creado con éxito."),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="idpermiso", type="integer", example=1),
     *                 @OA\Property(property="nombre", type="string", example="Nuevo Permiso"),
     *                 @OA\Property(property="descripcion", type="string", example="Descripción detallada del permiso"),
     *                 @OA\Property(property="estado", type="boolean", example=true),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-27T12:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-27T12:00:00Z")
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
        // Configurar información de auditoría en el contexto SQL para la tabla "permisos"
        AuditoriaService::setContextInfo('ProcesosdeBodega');

        // Validación de datos
        $validated = $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'required|string|max:255',
            'estado' => 'required|boolean',
        ]);

        // Crear un nuevo permiso
        $permiso = Permiso::create([
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'],
            'estado' => $validated['estado'],
        ]);

        // Devolver una respuesta JSON con el nuevo recurso creado
        return response()->json([
            'message' => 'Permiso creado con éxito.',
            'data' => $permiso
        ], 201); // Código de respuesta 201 - Creado
    }

    /**
     * @OA\Get(
     *     path="/api/permisos/{idpermiso}",
     *     tags={"Permisos"},
     *     summary="Obtiene un permiso específico",
     *     @OA\Parameter(
     *         name="idpermiso",
     *         in="path",
     *         required=true,
     *         description="ID del permiso",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Permiso encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="idpermiso", type="integer", example=1),
     *             @OA\Property(property="nombre", type="string", example="Nuevo Permiso"),
     *             @OA\Property(property="descripcion", type="string", example="Descripción detallada del permiso"),
     *             @OA\Property(property="estado", type="boolean", example=true),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-27T12:00:00Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-27T12:00:00Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Permiso no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Permiso no encontrado.")
     *         )
     *     )
     * )
     */
    public function show($idpermiso): JsonResponse
    {
        $permiso = Permiso::find($idpermiso);

        if (!$permiso) {
            return response()->json([
                'message' => 'Permiso no encontrado.'
            ], 404);
        }

        return response()->json($permiso);
    }

    /**
     * @OA\Put(
     *     path="/api/permisos/{idpermiso}",
     *     summary="Actualizar un permiso",
     *     description="Esta ruta permite actualizar un permiso existente.",
     *     tags={"Permisos"},
     *     @OA\Parameter(
     *         name="idpermiso",
     *         in="path",
     *         required=true,
     *         description="ID del permiso",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre", "descripcion", "estado"},
     *             @OA\Property(property="nombre", type="string", example="Permiso Actualizado", description="Nombre del permiso"),
     *             @OA\Property(property="descripcion", type="string", example="Descripción actualizada", description="Descripción del permiso"),
     *             @OA\Property(property="estado", type="boolean", example=false, description="Estado del permiso (activo o inactivo)")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Permiso actualizado con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Permiso actualizado con éxito."),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Permiso no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Permiso no encontrado.")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $idpermiso): JsonResponse
    {
        // Configurar información de auditoría en el contexto SQL para la tabla "permisos"
        AuditoriaService::setContextInfo('ProcesosdeBodega');

        $permiso = Permiso::find($idpermiso);

        if (!$permiso) {
            return response()->json([
                'message' => 'Permiso no encontrado.'
            ], 404);
        }

        // Validación de los datos
        $validated = $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'required|string|max:255',
            'estado' => 'required|boolean',
        ]);

        // Actualizar el permiso
        $permiso->update([
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'],
            'estado' => $validated['estado'],
        ]);

        return response()->json([
            'message' => 'Permiso actualizado con éxito.',
            'data' => $permiso
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/permisos/{idpermiso}",
     *     summary="Eliminar un permiso",
     *     description="Esta ruta permite eliminar un permiso existente.",
     *     tags={"Permisos"},
     *     @OA\Parameter(
     *         name="idpermiso",
     *         in="path",
     *         required=true,
     *         description="ID del permiso",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Permiso eliminado con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Permiso eliminado con éxito.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Permiso no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Permiso no encontrado.")
     *         )
     *     )
     * )
     */
    public function destroy($idpermiso): JsonResponse
    {
        // Configurar información de auditoría en el contexto SQL para la tabla "permisos"
        AuditoriaService::setContextInfo('ProcesosdeBodega');

        $permiso = Permiso::find($idpermiso);

        if (!$permiso) {
            return response()->json([
                'message' => 'Permiso no encontrado.'
            ], 404);
        }

        $permiso->delete();

        return response()->json([
            'message' => 'Permiso eliminado con éxito.'
        ]);
    }
}
