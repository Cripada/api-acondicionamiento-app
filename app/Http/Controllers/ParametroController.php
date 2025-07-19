<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Parametro;
use Illuminate\Http\JsonResponse;

class ParametroController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/parametros",
     *     tags={"Parámetros"},
     *     summary="Listar todos los parámetros",
     *     @OA\Response(
     *         response=200,
     *         description="Listado exitoso",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ParametroSchema"))
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Parametro::all());
    }

    
    /**
     * @OA\Get(
     *     path="/api/parametros/paginated",
     *     tags={"Parametros"},
     *     summary="Obtiene la lista paginada de parametros con búsqueda",
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
     *         description="Texto a buscar en el nombre del parametro"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista paginada de parametros",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/ParametroSchema")),
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
        $query = Parametro::query();
        if ($search) {
            $query->where('nombre', 'like', '%' . $search . '%');
        }
        $parametros = $query->orderBy('idparametro', 'asc')->paginate($perPage);
        return response()->json($parametros);
    }

    /**
     * @OA\Get(
     *     path="/api/parametros/{clave}",
     *     tags={"Parámetros"},
     *     summary="Obtener un parámetro por clave",
     *     @OA\Parameter(name="clave", in="path", required=true, @OA\Schema(type="string")),
     *     @OA\Response(
     *         response=200,
     *         description="Parámetro encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/ParametroSchema")
     *     ),
     *     @OA\Response(response=404, description="No encontrado")
     * )
     */
    public function show($clave)
    {
        $param = Parametro::where('clave', $clave)->first();

        if (!$param) {
            return response()->json(
                [
                    'message' => 'Parámetro no encontrado.',
                ],
                404,
            );
        }

        return response()->json(
            [
                'data' => $param,
            ],
            200,
        );
    }

    /**
     * @OA\Post(
     *     path="/api/parametros",
     *     tags={"Parámetros"},
     *     summary="Crear un nuevo parámetro",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"clave", "valor"},
     *             @OA\Property(property="clave", type="string", example="IVA"),
     *             @OA\Property(property="valor", type="string", example="15"),
     *             @OA\Property(property="descripcion", type="string", example="Porcentaje del IVA")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Creado exitosamente"),
     *     @OA\Response(response=400, description="Datos inválidos")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'clave' => 'required|string|unique:parametros,clave',
            'valor' => 'required|string',
            'descripcion' => 'nullable|string',
        ]);

        $param = Parametro::create($validated);

        // Devolver una respuesta JSON con el nuevo recurso creado
        return response()->json(
            [
                'message' => 'Parametro creado con éxito.',
                'data' => $param,
            ],
            201,
        ); // Código de respuesta 201 - Creado
    }

    /**
     * @OA\Put(
     *     path="/api/parametros/{idparametro}",
     *     tags={"Parámetros"},
     *     summary="Actualizar solo el valor de un parámetro",
     *     @OA\Parameter(name="clave", in="path", required=true, @OA\Schema(type="string")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"valor"},
     *             @OA\Property(property="valor", type="string", example="12")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Actualizado exitosamente"),
     *     @OA\Response(response=404, description="Parámetro no encontrado")
     * )
     */
    public function update(Request $request, $idparametro)
    {
        $parametro = Parametro::find($idparametro);

        if (!$parametro) {
            return response()->json(['error' => 'Parámetro no encontrado'], 404);
        }

        $validated = $request->validate([
            'valor' => 'required|string',
        ]);

        $parametro->valor = $validated['valor'];
        $parametro->save();

        return response()->json([
            'message' => 'Parametro actualizado con éxito.',
            'data' => $parametro,
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/parametros/{clave}",
     *     tags={"Parámetros"},
     *     summary="Eliminar un parámetro",
     *     @OA\Parameter(name="clave", in="path", required=true, @OA\Schema(type="string")),
     *     @OA\Response(response=204, description="Eliminado correctamente"),
     *     @OA\Response(response=404, description="No encontrado")
     * )
     */
    public function destroy($clave)
    {
        $param = Parametro::where('clave', $clave)->first();

        if (!$param) {
            return response()->json(['error' => 'Parámetro no encontrado'], 404);
        }

        $param->delete();

        return response()->json([
            'message' => 'Parámetro eliminado con éxito.',
        ]);
    }
}
