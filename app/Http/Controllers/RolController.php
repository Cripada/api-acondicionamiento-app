<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Services\AuditoriaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

use OpenApi\Annotations as OA;

class RolController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/roles",
     *     summary="Obtiene la lista de roles",
     *     description="Esta ruta permite consultar todos los roles de usuario paginados en paginas de 10 roles cada una.",
     *     tags={"Roles"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de roles",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="idrol", type="integer", example=1),
     *                 @OA\Property(property="nombre", type="string", example="Rol de usuario A"),
     *                 @OA\Property(property="descripcion", type="string", example="Descripción del rol de usuario A"),
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
        $roles = DB::select('SELECT * FROM [dbo].[roles] ORDER BY idrol OFFSET ? ROWS FETCH NEXT ? ROWS ONLY', [$offset, $limit]);
        return response()->json($roles);
    }

    
    /**
     * @OA\Get(
     *     path="/api/roles/paginated",
     *     tags={"Roles"},
     *     summary="Obtiene la lista paginada de roles con búsqueda",
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
     *         description="Texto a buscar en el nombre del rol"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista paginada de roles",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/RolSchema")),
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

        $query = Rol::query();

        if ($search) {
            $query->where('nombre', 'like', '%' . $search . '%');
        }

        $roles = $query->orderBy('idrol', 'asc')->paginate($perPage);

        return response()->json($roles);
    }

    /**
     * @OA\Post(
     *     path="/api/roles",
     *     summary="Crear un nuevo roles",
     *     description="Esta ruta permite crear un nuevo rol de usuario con los datos proporcionados en la solicitud.",
     *     tags={"Roles"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre", "descripcion"},
     *                 @OA\Property(property="nombre", type="string", example="Nuevo Rol"),
     *                 @OA\Property(property="descripcion", type="string", example="Descripción detallada del rol de usuario"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Rol de usuario creado con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Rol de usuario creado con éxito."),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="idrol", type="integer", example=1),
     *                 @OA\Property(property="nombre", type="string", example="Nuevo Rol"),
     *                 @OA\Property(property="descripcion", type="string", example="Descripción detallada del rol de usuario"),
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
        // Validación de datos
        $validated = $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'required|string|max:255',
        ]);

        // Crear un nuevo Rol de usuario
        $rol = Rol::create([
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'],
        ]);

        // Devolver una respuesta JSON con el nuevo recurso creado
        return response()->json(
            [
                'message' => 'Rol de usuario creado con éxito.',
                'data' => $rol,
            ],
            201,
        ); // Código de respuesta 201 - Creado
    }

    /**
     * @OA\Get(
     *     path="/api/roles/{idrol}",
     *     tags={"Roles"},
     *     summary="Obtiene un rol específico",
     *     @OA\Parameter(
     *         name="idrol",
     *         in="path",
     *         required=true,
     *         description="ID del rol",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Rol de usuario encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="idrol", type="integer", example=1),
     *             @OA\Property(property="nombre", type="string", example="Nuevo Rol"),
     *             @OA\Property(property="descripcion", type="string", example="Descripción detallada del rol de usuario"),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-27T12:00:00Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-27T12:00:00Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Rol de usuario no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Rol de usuario no encontrado.")
     *         )
     *     )
     * )
     */
    public function show($idrol): JsonResponse
    {
        $rol = Rol::find($idrol);

        if (!$rol) {
            return response()->json(
                [
                    'message' => 'Rol de usuario no encontrado.',
                ],
                404,
            );
        }

        return response()->json($rol);
    }

    /**
     * @OA\Put(
     *     path="/api/roles/{idrol}",
     *     summary="Actualizar un Rol de usuario",
     *     description="Esta ruta permite actualizar un Rol de usuario existente.",
     *     tags={"Roles"},
     *     @OA\Parameter(
     *         name="idrol",
     *         in="path",
     *         required=true,
     *         description="ID del Rol de usuario",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre", "descripcion"},
     *                 @OA\Property(property="nombre", type="string", example="Nuevo Rol"),
     *                 @OA\Property(property="descripcion", type="string", example="Descripción detallada del rol de usuario"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Rol de usuario actualizado con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Rol de usuario actualizado con éxito."),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Rol de usuario no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Rol de usuario no encontrado.")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $idrol): JsonResponse
    {
        $rol = Rol::find($idrol);

        if (!$rol) {
            return response()->json(
                [
                    'message' => 'Rol de usuario no encontrado.',
                ],
                404,
            );
        }

        // Validación de los datos
        $validated = $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'required|string|max:255',
        ]);

        // Actualizar el Rol de usuario
        $rol->update([
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'],
        ]);

        return response()->json([
            'message' => 'Rol de usuario actualizado con éxito.',
            'data' => $rol,
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/roles/{idrol}",
     *     summary="Eliminar un Rol de usuario",
     *     description="Esta ruta permite eliminar un Rol de usuario existente.",
     *     tags={"Roles"},
     *     @OA\Parameter(
     *         name="idrol",
     *         in="path",
     *         required=true,
     *         description="ID del rol de usuario",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Rol de usuario eliminado con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Rol de usuario eliminado con éxito.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Rol de usuario no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Rol de usuario no encontrado.")
     *         )
     *     )
     * )
     */
    public function destroy($id): JsonResponse
    {
        $rol = Rol::find($id);

        if (!$rol) {
            return response()->json(
                [
                    'message' => 'Rol de usuario no encontrado.',
                ],
                404,
            );
        }

        $rol->delete();

        return response()->json([
            'message' => 'Rol de usuario eliminado con éxito.',
        ]);
    }

    public function asignarPermisos(Request $request, $idrol)
    {
        $request->validate([
            'permisos' => 'required|array',
            'permisos.*' => 'integer|exists:permisos,idpermiso',
        ]);

        $rol = Rol::findOrFail($idrol);

        // Sincronizar permisos (reemplaza los anteriores)
        $rol->permisos()->sync($request->input('permisos'));

        return response()->json([
            'message' => 'Permisos asignados correctamente.',
        ]);
    }

    public function obtenerPermisos($id)
    {
        $rol = Rol::with('permisos')->find($id);

        if (!$rol) {
            return response()->json(['message' => 'Rol no encontrado.'], 404);
        }

        return response()->json([
            'idrol' => $rol->idrol,
            'nombre' => $rol->nombre,
            'permisos' => $rol->permisos, // ← devuelve los permisos asociados
        ]);
    }
}
