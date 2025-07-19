<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Services\AuditoriaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

use OpenApi\Annotations as OA;

class ClienteController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/clientes",
     *     tags={"Clientes"},
     *     summary="Obtiene la lista paginada de clientes",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         description="Número de página",
     *         @OA\Schema(type="integer", default=1)
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         required=false,
     *         description="Cantidad de resultados por página",
     *         @OA\Schema(type="integer", default=10)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista paginada de clientes",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/ClienteSchema")),
     *             @OA\Property(property="total", type="integer", example=100),
     *             @OA\Property(property="per_page", type="integer", example=10),
     *             @OA\Property(property="current_page", type="integer", example=1),
     *             @OA\Property(property="last_page", type="integer", example=10),
     *             @OA\Property(property="from", type="integer", example=1),
     *             @OA\Property(property="to", type="integer", example=10)
     *         )
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        // Consulta
        $clientes = Cliente::all();
        return response()->json($clientes);
    }

    /**
     * @OA\Get(
     *     path="/api/clientes/paginated",
     *     tags={"Clientes"},
     *     summary="Obtiene la lista paginada de clientes con búsqueda",
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
     *         description="Texto a buscar en el nombre del cliente"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista paginada de clientes",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/ClienteSchema")),
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

        $query = Cliente::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('ruc_cedula', 'like', '%' . $search . '%')
                  ->orWhere('nombre_comercial', 'like', '%' . $search . '%');
            });
        }

        $clientes = $query->orderBy('idcliente', 'asc')->paginate($perPage);

        return response()->json($clientes);
    }

    /**
     * @OA\Post(
     *     path="/api/clientes",
     *     summary="Crear un nuevo cliente",
     *     description="Esta ruta permite crear un nuevo cliente con los datos proporcionados en la solicitud.",
     *     tags={"Clientes"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ClienteSchema")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="cliente creado con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="cliente creado con éxito."),
     *             @OA\Property(property="data", ref="#/components/schemas/ClienteSchema")
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
        // Configurar información de auditoría en el contexto SQL para la tabla "clientes"
        AuditoriaService::setContextInfo('ProcesosdeCliente');

        // Validación de datos
        $validated = $request->validate([
            'ruc_cedula' => ['required', 'string', 'regex:/^\d{10}|\d{13}$/'],
            'nombre_comercial' => ['required', 'string', 'max:150'],
            'direccion' => ['required', 'string', 'max:200'],
            'telefono' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:150'],
            'estado' => ['required', 'boolean'],
        ]);

        // Crear un nuevo cliente
        $cliente = cliente::create([
            'ruc_cedula' => $validated['ruc_cedula'],
            'nombre_comercial' => $validated['nombre_comercial'],
            'direccion' => $validated['direccion'],
            'telefono' => $validated['telefono'],
            'email' => $validated['email'],
            'estado' => $validated['estado'],
        ]);

        // Devolver una respuesta JSON con el nuevo recurso creado
        return response()->json(
            [
                'message' => 'cliente creado con éxito.',
                'data' => $cliente,
            ],
            201,
        ); // Código de respuesta 201 - Creado
    }

    /**
     * @OA\Get(
     *     path="/api/clientes/{idcliente}",
     *     tags={"Clientes"},
     *     summary="Obtiene un cliente específico",
     *     @OA\Parameter(
     *         name="idcliente",
     *         in="path",
     *         required=true,
     *         description="ID del cliente",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="cliente encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="cliente",
     *                 ref="#/components/schemas/ClienteSchema"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="cliente no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="cliente no encontrado.")
     *         )
     *     )
     * )
     */
    public function show($idcliente): JsonResponse
    {
        $cliente = cliente::find($idcliente);

        if (!$cliente) {
            return response()->json(
                [
                    'message' => 'cliente no encontrado.',
                ],
                404,
            );
        }

        return response()->json($cliente);
    }

    /**
     * @OA\Put(
     *     path="/api/clientes/{idcliente}",
     *     summary="Actualizar un cliente",
     *     description="Esta ruta permite actualizar un cliente existente.",
     *     tags={"Clientes"},
     *     @OA\Parameter(
     *         name="idcliente",
     *         in="path",
     *         required=true,
     *         description="ID del cliente",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ClienteSchema")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="cliente actualizado con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="cliente actualizado con éxito."),
     *             @OA\Property(property="data", ref="#/components/schemas/ClienteSchema")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="cliente no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="cliente no encontrado.")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $idcliente): JsonResponse
    {
        // Configurar información de auditoría en el contexto SQL para la tabla "clientes"
        AuditoriaService::setContextInfo('ProcesosdeCliente');

        $cliente = cliente::find($idcliente);

        if (!$cliente) {
            return response()->json(
                [
                    'message' => 'cliente no encontrado.',
                ],
                404,
            );
        }

        // Validación de los datos
        $validated = $request->validate([
            'ruc_cedula' => ['required', 'string', 'regex:/^\d{10}|\d{13}$/'],
            'nombre_comercial' => ['required', 'string', 'max:150'],
            'direccion' => ['required', 'string', 'max:200'],
            'telefono' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:150'],
            'estado' => ['required', 'boolean'],
        ]);

        // Actualizar el cliente
        $cliente->update([
            'ruc_cedula' => $validated['ruc_cedula'],
            'nombre_comercial' => $validated['nombre_comercial'],
            'direccion' => $validated['direccion'],
            'telefono' => $validated['telefono'],
            'email' => $validated['email'],
            'estado' => $validated['estado'],
        ]);

        return response()->json([
            'message' => 'cliente actualizado con éxito.',
            'data' => $cliente,
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/clientes/{idcliente}",
     *     summary="Eliminar un cliente",
     *     description="Esta ruta permite eliminar un cliente existente.",
     *     tags={"Clientes"},
     *     @OA\Parameter(
     *         name="idcliente",
     *         in="path",
     *         required=true,
     *         description="ID del cliente",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="cliente eliminado con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="cliente eliminado con éxito.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="cliente no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="cliente no encontrado.")
     *         )
     *     )
     * )
     */
    public function destroy($idcliente): JsonResponse
    {
        // Configurar información de auditoría en el contexto SQL para la tabla "clientes"
        AuditoriaService::setContextInfo('ProcesosdeBodega');

        $cliente = cliente::find($idcliente);

        if (!$cliente) {
            return response()->json(
                [
                    'message' => 'cliente no encontrado.',
                ],
                404,
            );
        }

        $cliente->delete();

        return response()->json([
            'message' => 'cliente eliminado con éxito.',
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/clientes/app/select",
     *     tags={"Clientes"},
     *     summary="Obtiene la lista completa de clientes para select",
     *     @OA\Response(
     *         response=200,
     *         description="Lista completa de clientes",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/ClienteSchema")
     *         )
     *     )
     * )
     */
    public function getClientesSelect(): JsonResponse
    {
        // Obtienes todos los clientes activos ordenados por nombre_comercial
        $clientes = Cliente::where('estado', 1)->orderBy('nombre_comercial', 'asc')->get();

        return response()->json($clientes);
    }
}
