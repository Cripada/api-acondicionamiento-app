<?php

namespace App\Http\Controllers;

use App\Models\AsignarSede;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AsignarSedeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/asignar-sedes",
     *     tags={"Asignar Sedes"},
     *     summary="Lista todas las asignaciones de sedes",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de asignaciones",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/AsignarSedeSchema")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $asignaciones = AsignarSede::with(['usuario', 'sede'])->get();

        return response()->json([
            'data' => $asignaciones,
            'total' => $asignaciones->count(),
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/asignar-sedes/{id}",
     *     tags={"Asignar Sedes"},
     *     summary="Obtiene asignaciones por usuario",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del usuario",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Asignaciones encontradas",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/AsignarSedeSchema")),
     *             @OA\Property(property="total", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encontraron asignaciones para este usuario"
     *     )
     * )
     */
    public function show($idusuario): JsonResponse
    {
        $asignaciones = AsignarSede::with(['usuario', 'sede'])
            ->where('idusuario', $idusuario)
            ->get();

        if ($asignaciones->isEmpty()) {
            return response()->json(['message' => 'No se encontraron asignaciones.'], 404);
        }

        return response()->json([
            'data' => $asignaciones,
            'total' => $asignaciones->count(),
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/asignar-sedes",
     *     tags={"Asignar Sedes"},
     *     summary="Crea una nueva asignación (sin duplicados por usuario y sede)",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AsignarSedeSchema")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Asignación creada",
     *         @OA\JsonContent(ref="#/components/schemas/AsignarSedeSchema")
     *     ),
     *     @OA\Response(
     *         response=409,
     *         description="Asignación ya existe",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="La asignación ya existe para este usuario y sede.")
     *         )
     *     )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'idusuario' => 'required|exists:users,id',
            'idsede' => 'required|exists:sedes,idsede',
            'estado' => 'required|boolean',
        ]);

        // Verificar si ya existe asignación
        $existe = AsignarSede::where('idusuario', $validated['idusuario'])->where('idsede', $validated['idsede'])->exists();

        if ($existe) {
            return response()->json(
                [
                    'message' => 'La asignación ya existe para este usuario y sede.',
                ],
                409,
            );
        }

        $asignacion = AsignarSede::create($validated);

        return response()->json(
            [
                'message' => 'Sede asignada con éxito.',
                'data' => $asignacion,
            ],
            201,
        );
    }

    /**
     * @OA\Put(
     *     path="/api/asignar-sedes/{id}",
     *     tags={"Asignar Sedes"},
     *     summary="Actualiza una asignación existente (evitando duplicados)",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la asignación",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AsignarSedeSchema")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Asignación actualizada",
     *         @OA\JsonContent(ref="#/components/schemas/AsignarSedeSchema")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Asignación no encontrada"
     *     ),
     *     @OA\Response(
     *         response=409,
     *         description="Asignación duplicada"
     *     )
     * )
     */
    public function update(Request $request, $id): JsonResponse
    {
        $asignacion = AsignarSede::find($id);

        if (!$asignacion) {
            return response()->json(['message' => 'Asignación no encontrada.'], 404);
        }

        $validated = $request->validate([
            'idusuario' => 'sometimes|exists:users,id',
            'idsede' => 'sometimes|exists:sedes,idsede',
            'estado' => 'sometimes|boolean',
        ]);

        // Obtener nuevos valores (si vienen) o mantener los actuales
        $nuevoUsuario = $validated['idusuario'] ?? $asignacion->idusuario;
        $nuevaSede = $validated['idsede'] ?? $asignacion->idsede;

        // Verificar si existe otra asignación con esos datos
        $existe = AsignarSede::where('idusuario', $nuevoUsuario)->where('idsede', $nuevaSede)->where('idasignarsede', '!=', $id)->exists();

        if ($existe) {
            return response()->json(
                [
                    'message' => 'Ya existe una asignación para este usuario y sede.',
                ],
                409,
            );
        }

        $asignacion->update($validated);

        return response()->json([
            'message' => 'Sede asignada actualizada con éxito.',
            'data' => $asignacion,
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/asignar-sedes/{id}",
     *     tags={"Asignar Sedes"},
     *     summary="Elimina una asignación",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la asignación",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Asignación eliminada"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Asignación no encontrada"
     *     )
     * )
     */
    public function destroy($id): JsonResponse
    {
        $asignacion = AsignarSede::find($id);

        if (!$asignacion) {
            return response()->json(['message' => 'Asignación no encontrada.'], 404);
        }

        $asignacion->delete();

        return response()->json(
            [
                'message' => 'Sede asignada eliminada con éxito.',
            ],
            204,
        );
    }

    /**
     * @OA\Get(
     *     path="/api/asignar-sedes/app/select/{idusuario}",
     *     tags={"Asignar Sedes"},
     *     summary="Obtiene la lista completa de las sedes activas asignadas a un usuario, para select",
     *     @OA\Parameter(
     *         name="idusuario",
     *         in="path",
     *         required=true,
     *         description="ID del usuario",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de sedes activas asignadas",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/AsignarSedeSchema")
     *         )
     *     )
     * )
     */
    public function getAsignarSedeSelect($idusuario): JsonResponse
    {
        $asignaciones = AsignarSede::with('sede')->where('idusuario', $idusuario)->where('estado', 1)->get();

        // Extraer solo la información de la sede para el select
        $sedes = $asignaciones
            ->map(function ($asignacion) {
                return [
                    'idsede' => $asignacion->sede->idsede ?? null,
                    'nombre' => $asignacion->sede->nombre ?? null,
                ];
            })
            ->filter(function ($sede) {
                return $sede['idsede'] !== null; // Filtrar por si alguna sede no existe
            })
            ->values();

        return response()->json($sedes);
    }
}
