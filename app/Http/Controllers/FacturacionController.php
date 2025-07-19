<?php

namespace App\Http\Controllers;

use App\Models\Proforma;
use App\Models\Facturacion;
use App\Services\AuditoriaService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

use OpenApi\Annotations as OA;

class FacturacionController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/facturacion",
     *     tags={"Facturacion"},
     *     summary="Listar todas las facturaciones",
     *     @OA\Response(response=200, description="Listado de facturas")
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json(Facturacion::with('proforma', 'usuario')->get());
    }

    /**
     * @OA\Post(
     *     path="/api/facturacion",
     *     tags={"Facturacion"},
     *     summary="Crear nueva factura",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"idproforma", "idusuario", "fechaFactura", "numeroFactura"},
     *             @OA\Property(property="idproforma", type="integer"),
     *             @OA\Property(property="idusuario", type="integer"),
     *             @OA\Property(property="fechaFactura", type="string", format="date"),
     *             @OA\Property(property="numeroFactura", type="string"),
     *             @OA\Property(property="comentario", type="string")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Factura creada correctamente")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'idproforma' => 'required|exists:proformas,idproforma',
            'idusuario' => 'required|exists:users,id',
            'fechaFactura' => 'required|date',
            'numeroFactura' => 'required|unique:facturacion',
            'comentario' => 'nullable|string',
        ]);

        $factura = Facturacion::create($request->all());

        // Actualizar status en la proforma
        $factura->proforma->update(['status' => 'Facturada']);

        return response()->json($factura, 201);
    }
    
    /**
     * @OA\Post(
     *     path="/api/facturacion/lote",
     *     tags={"Facturacion"},
     *     summary="Crear facturas para varias proformas",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"idproformas", "idusuario", "fechaFactura", "numeroFactura"},
     *             @OA\Property(property="idproformas", type="array", @OA\Items(type="integer")),
     *             @OA\Property(property="idusuario", type="integer"),
     *             @OA\Property(property="fechaFactura", type="string", format="date"),
     *             @OA\Property(property="numeroFactura", type="string"),
     *             @OA\Property(property="comentario", type="string")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Facturas creadas correctamente"),
     *     @OA\Response(response=400, description="Error en la solicitud")
     * )
     */
    public function storeLote(Request $request): JsonResponse
    {
        $request->validate([
            'idproformas' => 'required|array|min:1',
            'idproformas.*' => 'integer|exists:proformas,idproforma',
            'idusuario' => 'required|exists:users,id',
            'fechaFactura' => 'required|date',
            'numeroFactura' => 'required|string|unique:facturacion,numeroFactura',
            'comentario' => 'nullable|string',
        ]);

        $facturas = [];

        DB::beginTransaction();

        try {
            foreach ($request->idproformas as $idproforma) {
                $factura = Facturacion::create([
                    'idproforma'    => $idproforma,
                    'idusuario'     => $request->idusuario,
                    'fechaFactura'  => $request->fechaFactura,
                    'numeroFactura' => $request->numeroFactura,
                    'comentario'    => $request->comentario,
                ]);

                Proforma::where('idproforma', $idproforma)->update(['status' => 'Facturada']);

                $facturas[] = $factura;
            }

            DB::commit();

            return response()->json([
                'message' => 'Facturas creadas correctamente.',
                'data' => $facturas
            ], 201);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Error al crear las facturas.',
                'error' => $e->getMessage()
            ], 400);
        }
    }
    /**
     * @OA\Get(
     *     path="/api/facturacion/{id}",
     *     tags={"Facturacion"},
     *     summary="Obtener una factura específica",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la factura",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Factura encontrada"),
     *     @OA\Response(response=404, description="Factura no encontrada")
     * )
     */
    public function show($id): JsonResponse
    {
        $factura = Facturacion::find($id);
        if (!$factura) {
            return response()->json([
                'message' => 'Facturacion no encontrada.'
            ], 404);
        }
        return response()->json($factura);
    }

    /**
     * @OA\Put(
     *     path="/api/facturacion/{id}",
     *     tags={"Facturacion"},
     *     summary="Actualizar una factura",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la factura",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="fechaFactura", type="string", format="date"),
     *             @OA\Property(property="numeroFactura", type="string"),
     *             @OA\Property(property="comentario", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Factura actualizada"),
     *     @OA\Response(response=404, description="Factura no encontrada")
     * )
     */
    public function update(Request $request, $id): JsonResponse
    {
        $factura = Facturacion::find($id);

        if (!$factura) {
            return response()->json([
                'message' => 'Factura no encontrada.',
                'status' => 404,
            ], 404);
        }

        $data = $request->only(['fechaFactura', 'numeroFactura', 'comentario']);

        // Ejemplo: validación condicional rápida sin usar FormRequest (puede omitirse si usas FormRequest)
        if (isset($data['numeroFactura']) && empty($data['numeroFactura'])) {
            return response()->json([
                'message' => 'El número de factura no puede estar vacío.',
                'status' => 422,
            ], 422);
        }

        $factura->update($data);

        return response()->json([
            'message' => 'Factura actualizada correctamente.',
            'data' => $factura,
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/facturacion/{id}",
     *     tags={"Facturacion"},
     *     summary="Eliminar una factura",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la factura",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Factura eliminada correctamente"),
     *     @OA\Response(response=404, description="Factura no encontrada")
     * )
     */
    public function destroy($id): JsonResponse
    {
        $factura = Facturacion::find($id);

        if (!$factura) {
            return response()->json([
                'message' => 'Factura no encontrada.',
                'status' => 404,
            ], 404);
        }

        $factura->delete();

        return response()->json([
            'message' => 'Factura eliminada correctamente.',
        ], 200);
    }
}
