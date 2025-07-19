<?php

namespace App\Http\Controllers;

use App\Models\DetalleOrdenTrabajo;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(name="DetallesOrdenTrabajo", description="API de detalles de órdenes de trabajo")
 */
class DetalleOrdenTrabajoController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/ordenes-trabajo/{idorden}/detalles",
     *     tags={"DetallesOrdenTrabajo"},
     *     summary="Lista detalles de una orden de trabajo",
     *     @OA\Parameter(
     *         name="idorden",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID de la orden de trabajo"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de detalles",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/DetalleOrdenTrabajoSchema"))
     *     )
     * )
     */
    public function index($idorden): JsonResponse
    {
        $detalles = DetalleOrdenTrabajo::where('idorden', $idorden)->get();
        return response()->json($detalles);
    }

    /**
     * @OA\Post(
     *     path="/api/ordenes-trabajo/{idorden}/detalles",
     *     tags={"DetallesOrdenTrabajo"},
     *     summary="Crear un detalle para una orden de trabajo",
     *     @OA\Parameter(
     *         name="idorden",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID de la orden de trabajo"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/DetalleOrdenTrabajoSchema")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Detalle creado",
     *         @OA\JsonContent(ref="#/components/schemas/DetalleOrdenTrabajoSchema")
     *     )
     * )
     */
    public function store(Request $request, $idorden): JsonResponse
    {
        $validated = $request->validate([
            'idservicio' => 'required|exists:servicios,idservicio',
            'descripcion' => 'required|string',
            'cantidad' => 'required|numeric|min:0',
            'precio_unitario' => 'required|numeric|min:0',
            'precio_total' => 'required|numeric|min:0',
        ]);

        $detalle = DetalleOrdenTrabajo::create(array_merge($validated, ['idorden' => $idorden]));
        return response()->json($detalle, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/detalles-orden/{id}",
     *     tags={"DetallesOrdenTrabajo"},
     *     summary="Mostrar detalle específico",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del detalle",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalle encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/DetalleOrdenTrabajoSchema")
     *     ),
     *     @OA\Response(response=404, description="Detalle no encontrado")
     * )
     */
    public function show($id): JsonResponse
    {
        $detalle = DetalleOrdenTrabajo::find($id);
        if (!$detalle) {
            return response()->json(['message' => 'Detalle no encontrado'], 404);
        }
        return response()->json($detalle);
    }

    /**
     * @OA\Put(
     *     path="/api/detalles-orden/{id}",
     *     tags={"DetallesOrdenTrabajo"},
     *     summary="Actualizar un detalle",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del detalle",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/DetalleOrdenTrabajoSchema")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalle actualizado",
     *         @OA\JsonContent(ref="#/components/schemas/DetalleOrdenTrabajoSchema")
     *     ),
     *     @OA\Response(response=404, description="Detalle no encontrado")
     * )
     */
    public function update(Request $request, $id): JsonResponse
    {
        $detalle = DetalleOrdenTrabajo::find($id);
        if (!$detalle) {
            return response()->json(['message' => 'Detalle no encontrado'], 404);
        }

        $validated = $request->validate([
            'idservicio' => 'sometimes|exists:servicios,idservicio',
            'descripcion' => 'sometimes|string',
            'cantidad' => 'sometimes|numeric|min:0',
            'precio_unitario' => 'sometimes|numeric|min:0',
            'precio_total' => 'sometimes|numeric|min:0',
        ]);

        $detalle->update($validated);
        return response()->json($detalle);
    }

    /**
     * @OA\Delete(
     *     path="/api/detalles-orden/{id}",
     *     tags={"DetallesOrdenTrabajo"},
     *     summary="Eliminar un detalle",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del detalle",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Detalle eliminado"),
     *     @OA\Response(response=404, description="Detalle no encontrado")
     * )
     */
    public function destroy($id): JsonResponse
    {
        $detalle = DetalleOrdenTrabajo::find($id);
        if (!$detalle) {
            return response()->json(['message' => 'Detalle no encontrado'], 404);
        }
        $detalle->delete();
        return response()->json(null, 204);
    }
}
