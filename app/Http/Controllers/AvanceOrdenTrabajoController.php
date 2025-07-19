<?php

namespace App\Http\Controllers;

use App\Models\AvanceOrdenTrabajo;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(name="AvancesOrdenTrabajo", description="API de avances en detalles de órdenes de trabajo")
 */
class AvanceOrdenTrabajoController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/detalles-orden/{iddetalle}/avances",
     *     tags={"AvancesOrdenTrabajo"},
     *     summary="Lista avances de un detalle de orden",
     *     @OA\Parameter(
     *         name="iddetalle",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID del detalle de orden"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de avances",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/AvanceOrdenTrabajoSchema"))
     *     )
     * )
     */
    public function index($iddetalle): JsonResponse
    {
        $avances = AvanceOrdenTrabajo::where('iddetalle', $iddetalle)->get();
        return response()->json($avances);
    }

    /**
     * @OA\Post(
     *     path="/api/detalles-orden/{iddetalle}/avances",
     *     tags={"AvancesOrdenTrabajo"},
     *     summary="Crear un avance para un detalle de orden",
     *     @OA\Parameter(
     *         name="iddetalle",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID del detalle de orden"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AvanceOrdenTrabajoSchema")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Avance creado",
     *         @OA\JsonContent(ref="#/components/schemas/AvanceOrdenTrabajoSchema")
     *     )
     * )
     */
    public function store(Request $request, $iddetalle): JsonResponse
    {
        $validated = $request->validate([
            'idusuario' => 'required|exists:users,id',
            'tiempo' => 'required|date_format:H:i:s',
            'fecha' => 'required|date',
        ]);

        $avance = AvanceOrdenTrabajo::create(array_merge($validated, ['iddetalle' => $iddetalle]));
        return response()->json($avance, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/avances/{id}",
     *     tags={"AvancesOrdenTrabajo"},
     *     summary="Mostrar un avance específico",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del avance",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Avance encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/AvanceOrdenTrabajoSchema")
     *     ),
     *     @OA\Response(response=404, description="Avance no encontrado")
     * )
     */
    public function show($id): JsonResponse
    {
        $avance = AvanceOrdenTrabajo::find($id);
        if (!$avance) {
            return response()->json(['message' => 'Avance no encontrado'], 404);
        }
        return response()->json($avance);
    }

    /**
     * @OA\Put(
     *     path="/api/avances/{id}",
     *     tags={"AvancesOrdenTrabajo"},
     *     summary="Actualizar un avance",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del avance",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AvanceOrdenTrabajoSchema")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Avance actualizado",
     *         @OA\JsonContent(ref="#/components/schemas/AvanceOrdenTrabajoSchema")
     *     ),
     *     @OA\Response(response=404, description="Avance no encontrado")
     * )
     */
    public function update(Request $request, $id): JsonResponse
    {
        $avance = AvanceOrdenTrabajo::find($id);
        if (!$avance) {
            return response()->json(['message' => 'Avance no encontrado'], 404);
        }

        $validated = $request->validate([
            'idusuario' => 'sometimes|exists:users,id',
            'tiempo' => 'sometimes|date_format:H:i:s',
            'fecha' => 'sometimes|date',
        ]);

        $avance->update($validated);
        return response()->json($avance);
    }

    /**
     * @OA\Delete(
     *     path="/api/avances/{id}",
     *     tags={"AvancesOrdenTrabajo"},
     *     summary="Eliminar un avance",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del avance",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Avance eliminado"),
     *     @OA\Response(response=404, description="Avance no encontrado")
     * )
     */
    public function destroy($id): JsonResponse
    {
        $avance = AvanceOrdenTrabajo::find($id);
        if (!$avance) {
            return response()->json(['message' => 'Avance no encontrado'], 404);
        }
        $avance->delete();
        return response()->json(null, 204);
    }
}
