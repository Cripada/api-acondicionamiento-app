<?php

namespace App\Http\Controllers;

use App\Models\Proforma;
use App\Models\OrdenTrabajo;
use App\Models\DetalleOrdenTrabajo;
use App\Models\Sede;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Barryvdh\DomPDF\Facade\Pdf;

/**
 * @OA\Tag(name="OrdenesTrabajo", description="API de órdenes de trabajo")
 */
class OrdenTrabajoController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/ordenes-trabajo",
     *     tags={"OrdenesTrabajo"},
     *     summary="Lista todas las órdenes de trabajo",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de órdenes",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/OrdenTrabajoSchema"))
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $ordenes = OrdenTrabajo::with(['detalles', 'responsables'])->get();
        return response()->json($ordenes);
    }

    /**
     * @OA\Get(
     *     path="/api/ordenes-trabajo/paginated",
     *     tags={"OrdenesTrabajo"},
     *     summary="Obtiene una lista paginada de órdenes de trabajo",
     *     description="Devuelve una lista paginada de órdenes de trabajo con datos clave: fechas, responsable, estado, prioridad, número de proforma y cliente.",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Número de página",
     *         required=false,
     *         @OA\Schema(type="integer", default=1)
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Cantidad de resultados por página",
     *         required=false,
     *         @OA\Schema(type="integer", default=10)
     *     ),
     *     @OA\Parameter(
     *         name="idsede",
     *         in="query",
     *         description="ID de la sede",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista paginada de órdenes de trabajo",
     *         @OA\JsonContent(
     *             @OA\Property(property="current_page", type="integer", example=1),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="idorden", type="integer", example=1),
     *                 @OA\Property(property="fecha_inicio", type="string", format="date", example="2025-07-14"),
     *                 @OA\Property(property="fecha_fin", type="string", format="date", example="2025-07-20"),
     *                 @OA\Property(property="idusuario_responsable", type="integer", example=9),
     *                 @OA\Property(property="usuario_responsable", type="string", example="Andy Leonardo Baidal"),
     *                 @OA\Property(property="estado", type="string", example="Pendiente"),
     *                 @OA\Property(property="prioridad", type="string", example="Normal"),
     *                 @OA\Property(property="comentario", type="string", nullable=true, example="Observaciones generales"),
     *                 @OA\Property(property="avance_general", type="string", example="0.00"),
     *                 @OA\Property(property="num_proforma", type="string", example="PR-0005"),
     *                 @OA\Property(property="num_ot", type="string", example="000023"),
     *                 @OA\Property(property="cliente", type="string", example="Comercial Batallas")
     *             )),
     *             @OA\Property(property="last_page", type="integer", example=5),
     *             @OA\Property(property="per_page", type="integer", example=10),
     *             @OA\Property(property="total", type="integer", example=50)
     *         )
     *     )
     * )
     */
    public function paginated(Request $request): JsonResponse
    {
        $idsede = $request->query('idsede');
        $perPage = $request->query('per_page', 10);
        $search = $request->query('search', '');

        $ordenes = DB::table('ordenesTrabajo as ot')
            ->select([
                'ot.idorden',
                'ot.idproforma',
                'ot.fecha_inicio',
                'ot.fecha_fin',
                'ot.idusuario_responsable',
                'users.nombre as nombre_responsable',
                'users.apellido as apellido_responsable',
                'ot.estado',
                'ot.prioridad',
                'ot.comentario',
                'ot.avance_general',
                'proformas.num_proforma',
                'proformas.num_ot',
                'clientes.nombre_comercial as cliente',
            ])
            ->join('proformas', 'proformas.idproforma', '=', 'ot.idproforma')
            ->join('clientes', 'clientes.idcliente', '=', 'proformas.idcliente')
            ->join('users', 'users.id', '=', 'ot.idusuario_responsable')
            ->where('proformas.idsede', $idsede)
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('clientes.nombre_comercial', 'like', "%$search%")
                        ->orWhere('proformas.num_proforma', 'like', "%$search%")
                        ->orWhere('ot.estado', 'like', "%$search%");
                });
            })
            ->orderBy('ot.created_at', 'desc')
            ->paginate($perPage);


        return response()->json($ordenes);
    }


    /**
     * @OA\Get(
     *     path="/api/ordenes-trabajo/ot-por-autorizar",
     *     tags={"OrdenesTrabajo"},
     *     summary="Obtiene una lista paginada de órdenes de trabajo",
     *     description="Devuelve una lista paginada de órdenes de trabajo con datos clave: fechas, responsable, estado, prioridad, número de proforma y cliente.",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Número de página",
     *         required=false,
     *         @OA\Schema(type="integer", default=1)
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Cantidad de resultados por página",
     *         required=false,
     *         @OA\Schema(type="integer", default=10)
     *     ),
     *     @OA\Parameter(
     *         name="idsede",
     *         in="query",
     *         description="ID de la sede",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista paginada de órdenes de trabajo",
     *         @OA\JsonContent(
     *             @OA\Property(property="current_page", type="integer", example=1),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="idorden", type="integer", example=1),
     *                 @OA\Property(property="fecha_inicio", type="string", format="date", example="2025-07-14"),
     *                 @OA\Property(property="fecha_fin", type="string", format="date", example="2025-07-20"),
     *                 @OA\Property(property="idusuario_responsable", type="integer", example=9),
     *                 @OA\Property(property="usuario_responsable", type="string", example="Andy Leonardo Baidal"),
     *                 @OA\Property(property="estado", type="string", example="Pendiente"),
     *                 @OA\Property(property="prioridad", type="string", example="Normal"),
     *                 @OA\Property(property="comentario", type="string", nullable=true, example="Observaciones generales"),
     *                 @OA\Property(property="avance_general", type="string", example="0.00"),
     *                 @OA\Property(property="num_proforma", type="string", example="PR-0005"),
     *                 @OA\Property(property="num_ot", type="string", example="000023"),
     *                 @OA\Property(property="cliente", type="string", example="Comercial Batallas")
     *             )),
     *             @OA\Property(property="last_page", type="integer", example=5),
     *             @OA\Property(property="per_page", type="integer", example=10),
     *             @OA\Property(property="total", type="integer", example=50)
     *         )
     *     )
     * )
     */
    public function otPorAutorizar(Request $request): JsonResponse
    {
        $idsede = $request->query('idsede');
        $perPage = $request->query('per_page', 10);
        $search = $request->query('search', '');

        $ordenes = DB::table('ordenesTrabajo as ot')
            ->select([
                'ot.idorden',
                'ot.idproforma',
                'ot.fecha_inicio',
                'ot.fecha_fin',
                'ot.idusuario_responsable',
                'users.nombre as nombre_responsable',
                'users.apellido as apellido_responsable',
                'ot.estado',
                'ot.prioridad',
                'ot.comentario',
                'ot.avance_general',
                'proformas.num_proforma',
                'proformas.num_ot',
                'clientes.nombre_comercial as cliente',
            ])
            ->join('proformas', 'proformas.idproforma', '=', 'ot.idproforma')
            ->join('clientes', 'clientes.idcliente', '=', 'proformas.idcliente')
            ->join('users', 'users.id', '=', 'ot.idusuario_responsable')
            ->where('proformas.idsede', $idsede)
            ->where('ot.estado', 'Pendiente')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('clientes.nombre_comercial', 'like', "%$search%")
                        ->orWhere('proformas.num_proforma', 'like', "%$search%");
                });
            })
            ->orderBy('ot.created_at', 'desc')
            ->paginate($perPage);


        return response()->json($ordenes);
    }


    /**
     * @OA\Post(
     *     path="/api/ordenes-trabajo",
     *     tags={"OrdenesTrabajo"},
     *     summary="Crear una nueva orden de trabajo",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/OrdenTrabajoSchema")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Orden creada",
     *         @OA\JsonContent(ref="#/components/schemas/OrdenTrabajoSchema")
     *     )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'idproforma' => 'required|exists:proformas,idproforma',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'responsable' => 'required|string|max:255',
            'estado' => 'nullable|string|max:50',
            'comentario' => 'nullable|string',
        ]);

        $orden = OrdenTrabajo::create($validated);
        return response()->json($orden, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/ordenes-trabajo/{id}",
     *     tags={"OrdenesTrabajo"},
     *     summary="Mostrar una orden de trabajo específica",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la orden de trabajo",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Orden encontrada",
     *         @OA\JsonContent(ref="#/components/schemas/OrdenTrabajoSchema")
     *     ),
     *     @OA\Response(response=404, description="Orden no encontrada")
     * )
     */
    public function show($id): JsonResponse
    {
        $orden = OrdenTrabajo::with(['usuarioAprueba', 'proforma', 'proforma.usuario', 'proforma.cliente', 'detalles', 'responsables'])->find($id);

        if (!$orden) {
            return response()->json(['message' => 'Orden no encontrada'], 404);
        }
        return response()->json($orden);
    }

    /**
     * @OA\Put(
     *     path="/api/ordenes-trabajo/{id}",
     *     tags={"OrdenesTrabajo"},
     *     summary="Actualizar una orden de trabajo",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la orden de trabajo",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/OrdenTrabajoSchema")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Orden actualizada",
     *         @OA\JsonContent(ref="#/components/schemas/OrdenTrabajoSchema")
     *     ),
     *     @OA\Response(response=404, description="Orden no encontrada")
     * )
     */
    public function update(Request $request, $id): JsonResponse
    {
        $orden = OrdenTrabajo::find($id);
        if (!$orden) {
            return response()->json(['message' => 'Orden no encontrada'], 404);
        }

        $validated = $request->validate([
            'idproforma' => 'sometimes|exists:proformas,idproforma',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'responsable' => 'sometimes|string|max:255',
            'estado' => 'sometimes|string|max:50',
            'comentario' => 'nullable|string',
        ]);

        $orden->update($validated);
        return response()->json($orden);
    }

    /**
     * @OA\Delete(
     *     path="/api/ordenes-trabajo/{id}",
     *     tags={"OrdenesTrabajo"},
     *     summary="Eliminar una orden de trabajo",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la orden de trabajo",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Orden eliminada"),
     *     @OA\Response(response=404, description="Orden no encontrada")
     * )
     */
    public function destroy($id): JsonResponse
    {
        $orden = OrdenTrabajo::find($id);
        if (!$orden) {
            return response()->json(['message' => 'Orden no encontrada'], 404);
        }
        $orden->delete();
        return response()->json(null, 204);
    }

    /**
     * @OA\Post(
     *     path="/api/ordenes-trabajo/crear-desde-proforma/{idproforma}",
     *     summary="Crear orden de trabajo a partir de una proforma existente",
     *     tags={"OrdenesTrabajo"},
     *     @OA\Parameter(
     *         name="idproforma",
     *         in="path",
     *         description="ID de la proforma",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"fecha_inicio", "fecha_fin", "prioridad", "responsables"},
     *             @OA\Property(property="fecha_inicio", type="string", format="date", example="2025-07-08"),
     *             @OA\Property(property="fecha_fin", type="string", format="date", example="2025-07-12"),
     *             @OA\Property(property="idusuario_responsable", type="integer", nullable=true, example=1),            
     *             @OA\Property(property="prioridad", type="string", example="Alta"),
     *             @OA\Property(property="comentario", type="string", nullable=true, example="Trabajo urgente derivado de proforma"),
     *             @OA\Property(property="aprobada", type="boolean", example=false),
     *             @OA\Property(property="idusuario_aprueba", type="integer", nullable=true, example=null),
     *             @OA\Property(property="fecha_aprobacion", type="string",nullable=false, example="10:00:00"),
     *             @OA\Property(
     *                 property="responsables",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     * 
     *                     required={"idusuario"},
     *                     @OA\Property(property="idusuario", type="integer", example=1),
     *                     @OA\Property(property="tiempo_asignado", type="string", format="time", nullable=true, example="02:00:00"),
     *                     @OA\Property(property="observaciones", type="string", nullable=true, example="Realizar las marcaciones en la maquina Injek")
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="detalles",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     required={"idservicio"},
     *                     @OA\Property(property="idservicio", type="integer", example=1),
     *                     @OA\Property(property="produccionHora", type="number", format="float", example=2.5),
     *                     @OA\Property(property="observaciones", type="string", nullable=true, example="Realizar las marcaciones en la maquina Injek")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Orden de trabajo creada exitosamente",
     *         @OA\JsonContent(ref="#/components/schemas/OrdenTrabajoSchema")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Proforma no encontrada"
     *     )
     * )
     */
    public function crearOtDesdeProforma(Request $request, $idproforma)
    {
        $request->validate([
            //Cabecera OT
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'prioridad' => 'required|string',
            'comentario' => 'nullable|string',
            
            //Aprueba
            'aprobada' => 'boolean',
            'idusuario_aprueba' => 'nullable|exists:users,id',
            'fecha_aprobacion' => 'nullable|date',

            //Detalle OT
            'detalles' => 'required|array',
            'detalles.*.idservicio' => 'exists:servicios,idservicio',
            'detalles.*.produccionHora'  => 'required|numeric|min:0',
            'detalles.*.observaciones' => 'nullable|string',

            //Responsables
            'responsables' => 'required|array',
            'responsables.*.idusuario' => 'required|integer|exists:users,id',
            'responsables.*.tiempo_asignado' => 'required|string',
            'responsables.*.observaciones' => 'nullable|string',

        ]);

        DB::beginTransaction();

        try {

            $orden = OrdenTrabajo::create([
                'idproforma' => $idproforma,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
                'idusuario_responsable' => $request->idusuario_responsable,
                'comentario' => $request->comentario,
                'prioridad' => $request->prioridad,
                'aprobada' => $request->aprobada ?? false,
                'idusuario_aprueba' => $request->idusuario_aprueba,
                'fecha_aprobacion' => $request->fecha_aprobacion,
                'avance_general' => 0,
                'estado' => 'Pendiente',
            ]);

            // Crear detalles
            foreach ($request->detalles as $detalle) {
                DetalleOrdenTrabajo::create([
                    'idorden' => $orden->idorden,
                    'idservicio' => $detalle['idservicio'],
                    'produccionHora' => $detalle['produccionHora'],
                    'observacion' => $detalle['observaciones'] ?? null,
                    'avance' => 0,
                    'estado' => 'Pendiente',
                ]);
            }


            $pivotData = [];

            foreach ($request->responsables as $r) {
                $pivotData[$r['idusuario']] = [
                    'tiempo_asignado' => $r['tiempo_asignado'] ?? null,
                    'observaciones' => $r['observaciones'] ?? null,
                ];
            }

            // Asignar responsables usando tabla pivot ordenTrabajoUsuario
            $orden->responsables()->attach($pivotData);

            DB::commit();

            // Actualizar número OT y proforma
            $this->crearNumeroOT($idproforma);

            return response()->json($orden->load(['detalles', 'responsables']), 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al crear la orden de trabajo', 'error' => $e->getMessage()], 500);
        }
    }

    private function crearNumeroOT($idproforma)
    {
        // Buscar la proforma
        $proforma = Proforma::find($idproforma);
        if (!$proforma) {
            return response()->json(['message' => 'Proforma no encontrada'], 404);
        }

        // Buscar la sede
        $sede = Sede::find($proforma->idsede);
        if (!$sede) {
            return response()->json(['message' => 'Sede no encontrada'], 404);
        }

        // Incrementar el número actual de OT
        $nuevoNumeroOT = (int) $sede->num_actual_ot + 1;

        // Actualizar el número actual en sede
        $sede->num_actual_ot = $nuevoNumeroOT;
        $sede->save();

        // Formatear el número con ceros a la izquierda
        $numeroOTFormateado = str_pad($nuevoNumeroOT, 6, '0', STR_PAD_LEFT);

        // Asignar a la proforma
        $proforma->num_ot = $numeroOTFormateado;
        $proforma->status = 'Aprobada'; // si quieres actualizar el estado
        $proforma->save();

        return response()->json([
            'message' => 'Número de OT asignado correctamente',
            'numero_ot' => $numeroOTFormateado,
        ]);
    }

    private function prepararPdf(OrdenTrabajo $orden)
    {
        //Total Dias
        $logoPath = public_path('logo/cripada-logo.svg');

        $pdf = Pdf::loadView('pdf.orden_trabajo', compact('orden'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ])
            ->setWarnings(false);

        // Aquí añades el número de páginas:
        /*  $dompdf = $pdf->getDomPDF();
        $canvas = $dompdf->getCanvas();
        $fontMetrics = new \Dompdf\FontMetrics($canvas, $dompdf->getOptions());

        $canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
            $font = $fontMetrics->getFont('sans-serif', 'normal');
            $size = 9;
            $text = "Página $pageNumber de $pageCount";
            $x = 500; // Ajustado para mejor visibilidad
            $y = 820; // Parte inferior visible
            $canvas->text($x, $y, $text, $font, $size);
        });
        */
        return $pdf;
    }

    /**
     * @OA\Get(
     *     path="/api/ordenes-trabajo/{id}/descargar",
     *     tags={"OrdenesTrabajo"},
     *     summary="Descarga el PDF de una Orden Trabajo",
     *     description="Genera y descarga automáticamente el PDF con los datos completos de la Orden Trabajo.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la proforma",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="PDF generado exitosamente",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/pdf",
     *                 @OA\Schema(type="string", format="binary")
     *             )
     *         }
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Orden Trabajo no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Orden Trabajo no encontrada.")
     *         )
     *     )
     * )
     */
    public function descargarPdf($id): Response
    {
        $orden = OrdenTrabajo::with(['usuarioAprueba', 'proforma', 'proforma.usuario', 'proforma.cliente', 'detalles', 'responsables'])->find($id);

        if (!$orden) {
            return response()->view('pdf.proforma_no_encontrada', [], 404);
        }
        $pdf = $this->prepararPdf($orden);
        return $pdf->download('Proforma Nº ' . $orden->idorden . '.pdf');
    }

    /**
     * @OA\Get(
     *     path="/api/ordenes-trabajo/{id}/visualizar",
     *     tags={"OrdenesTrabajo"},
     *     summary="Descarga el PDF de una Orden Trabajo",
     *     description="Genera y descarga automáticamente el PDF con los datos completos de la Orden Trabajo.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la Orden Trabajo",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="PDF generado exitosamente",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/pdf",
     *                 @OA\Schema(type="string", format="binary")
     *             )
     *         }
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Orden Trabajo no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Orden Trabajo no encontrada.")
     *         )
     *     )
     * )
     */
    public function visualizarPdf($id): Response
    {
        $orden = OrdenTrabajo::with(['usuarioAprueba', 'proforma', 'proforma.usuario', 'proforma.cliente', 'detalles', 'responsables'])->find($id);

        if (!$orden) {
            return response()->view('pdf.proforma_no_encontrada', [], 404);
        }
        $pdf = $this->prepararPdf($orden);
        return $pdf->stream('Proforma Nº ' . $orden->idorden . '.pdf');
    }


    public function verAprobacion($id)
    {
        $ordenTrabajo = OrdenTrabajo::findOrFail($id);

        return view('ordenTrabajo.aprobar', compact('ordenTrabajo'));
    }

    public function aprobar(Request $request, $id)
    {
        try {

            $credentials = $request->validate([
                'correo' => 'required|email',
                'password' => 'required'
            ]);

            $datos = $request->validate([
                'comentario' => 'nullable|string|max:500',
            ]);

            if (!Auth::attempt($credentials)) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }

            /** @var \App\Models\User $user */
            $user = Auth::user();

            $ordenTrabajo = OrdenTrabajo::findOrFail($id);
            $ordenTrabajo->estado = 'Autorizada';
            $ordenTrabajo->aprobada = true;
            // $proforma->comentario_aprobacion = $datos->comentario;
            $ordenTrabajo->idusuario_aprueba = $user->id;
            $ordenTrabajo->fecha_aprobacion = now();
            $ordenTrabajo->save();
        } catch (\Throwable $e) {
            // En producción podrías ocultar detalles
            return response()->json([
                'message' => 'Error en el servidor',
                'error' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ], 500);
        }

        return back()->with('success', 'Orden Trabajo aprobada correctamente.');
    }

    public function aprobarOrdenDeTrabajo(Request $request, $id)
    {
        try {
            // Validar solo el comentario si viene
            $datos = $request->validate([
                'comentario' => 'nullable|string|max:500',
            ]);

            // Obtener el usuario autenticado
            /** @var \App\Models\User $user */
            $user = Auth::user();

            if (!$user) {
                return response()->json(['message' => 'Usuario no autenticado'], 401);
            }

            $ordenTrabajo = OrdenTrabajo::findOrFail($id);
            $ordenTrabajo->estado = 'Autorizada';
            $ordenTrabajo->aprobada = true;
            //$ordenTrabajo->comentario_aprobacion = $datos['comentario'] ?? null;
            $ordenTrabajo->idusuario_aprueba = $user->id;
            $ordenTrabajo->fecha_aprobacion = now();
            $ordenTrabajo->save();

            return back()->with('success', 'Orden Trabajo aprobada correctamente.');
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Error en el servidor',
                'error' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ], 500);
        }
    }
}
