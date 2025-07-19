<?php

namespace App\Http\Controllers;

use App\Models\Proforma;
use App\Models\Parametro;
use App\Models\Sede;
use App\Models\DetalleProforma;
use App\Services\AuditoriaService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use OpenApi\Annotations as OA;

class ProformaController extends Controller
{
    public function viewAprobacion($id)
    {
        $proforma = Proforma::findOrFail($id);
        return view('proformas.aprobar', compact('proforma'));
    }

    public function verAprobacion($id)
    {
        $proforma = Proforma::findOrFail($id);

        return view('proformas.aprobar', compact('proforma'));
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

            $proforma = Proforma::findOrFail($id);
            $proforma->status = 'Aprobada';
            // $proforma->comentario_aprobacion = $datos->comentario;
            $proforma->idusuario_aprueba = $user->id;
            $proforma->fecha_aprobacion = now();
            $proforma->save();
        } catch (\Throwable $e) {
            // En producción podrías ocultar detalles
            return response()->json([
                'message' => 'Error en el servidor',
                'error' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ], 500);
        }

        return back()->with('success', 'Proforma aprobada correctamente.');
    }

    /**
     * @OA\Get(
     *     path="/api/proformas",
     *     tags={"Proformas"},
     *     summary="Obtiene una lista de todas las proformas",
     *     description="Devuelve una lista de todas las proformas, incluyendo usuario, cliente, tipo de facturación y detalles de servicios.",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de todas las proformas",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     allOf={
     *                         @OA\Schema(ref="#/components/schemas/ProformaSchema"),
     *                         @OA\Schema(
     *                             @OA\Property(property="usuario", ref="#/components/schemas/UsuarioSchema"),
     *                             @OA\Property(property="cliente", ref="#/components/schemas/ClienteSchema"),
     *                             @OA\Property(property="tipo_facturacion", ref="#/components/schemas/TipoFacturacionSchema"),
     *                             @OA\Property(
     *                                 property="detalles",
     *                                 type="array",
     *                                 @OA\Items(
     *                                     allOf={
     *                                         @OA\Schema(ref="#/components/schemas/DetalleProformaSchema"),
     *                                         @OA\Schema(
     *                                             @OA\Property(property="servicio", ref="#/components/schemas/ServicioSchema")
     *                                         )
     *                                     }
     *                                 )
     *                             )
     *                         )
     *                     }
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        // Listas de todas las proformas
        $proformas = Proforma::with(['sede', 'cliente', 'usuario', 'tipoFacturacion', 'detalles.servicio'])
            ->orderByDesc('idproforma')
            ->get();

        return response()->json([
            'data' => $proformas,
            'total' => $proformas->count(),
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/proformas/paginated",
     *     tags={"Proformas"},
     *     summary="Obtiene una lista paginada de proformas con búsqueda",
     *     description="Devuelve una lista paginada de proformas, incluyendo usuario, cliente, tipo de facturación y detalles de servicios.",
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
     *         name="search",
     *         in="query",
     *         description="Buscar por correo, cliente, solicitante o comentario",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista paginada de proformas",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     allOf={
     *                         @OA\Schema(ref="#/components/schemas/ProformaSchema"),
     *                         @OA\Schema(
     *                             @OA\Property(property="usuario", ref="#/components/schemas/UsuarioSchema"),
     *                             @OA\Property(property="cliente", ref="#/components/schemas/ClienteSchema"),
     *                             @OA\Property(property="tipo_facturacion", ref="#/components/schemas/TipoFacturacionSchema"),
     *                             @OA\Property(
     *                                 property="detalles",
     *                                 type="array",
     *                                 @OA\Items(
     *                                     allOf={
     *                                         @OA\Schema(ref="#/components/schemas/DetalleProformaSchema"),
     *                                         @OA\Schema(
     *                                             @OA\Property(property="servicio", ref="#/components/schemas/ServicioSchema")
     *                                         )
     *                                     }
     *                                 )
     *                             )
     *                         )
     *                     }
     *                 )
     *             ),
     *             @OA\Property(property="total", type="integer", example=50),
     *             @OA\Property(property="current_page", type="integer", example=1),
     *             @OA\Property(property="per_page", type="integer", example=10)
     *         )
     *     )
     * )
     */
    public function paginated(Request $request): JsonResponse
    {
        $idsede = $request->query('idsede');

        $perPage = $request->query('per_page', 10); // default 10
        $search = $request->query('search', '');

        $query = Proforma::select(
            'proformas.idproforma',
            'ordenesTrabajo.idorden',
            'proformas.fechaEmision',
            'proformas.num_proforma',
            'proformas.num_ot',
            'proformas.num_actualizacion',
            'proformas.idsede',
            'proformas.idcliente',
            'clientes.nombre_comercial',
            'proformas.status'
        )
            ->join('clientes', 'clientes.idcliente', '=', 'proformas.idcliente')
            ->leftJoin('ordenesTrabajo', 'ordenesTrabajo.idproforma', '=', 'proformas.idproforma')
            ->where('proformas.idsede', $idsede);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('clientes.nombre_comercial', 'like', "%$search%")
                    ->orWhere('proformas.num_proforma', 'like', "%$search%")
                    ->orWhere('proformas.fechaEmision', 'like', "%$search%");
            });
        }

        $proformas = $query->orderByDesc('proformas.idproforma')->paginate($perPage);

        return response()->json($proformas);
    }


    /**
     * @OA\Get(
     *     path="/api/proformas/para-orden-de-trabajo",
     *     tags={"Proformas"},
     *     summary="Obtiene una lista paginada de proformas con búsqueda",
     *     description="Devuelve una lista paginada de proformas, incluyendo usuario, cliente, tipo de facturación y detalles de servicios.",
     *     @OA\Parameter(
     *         name="idsede",
     *         in="query",
     *         description="ID de la sede consultada",
     *         required=false,
     *         @OA\Schema(type="integer", default=10)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista paginada de proformas",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     allOf={
     *                         @OA\Schema(ref="#/components/schemas/ProformaSchema"),
     *                         @OA\Schema(
     *                             @OA\Property(property="usuario", ref="#/components/schemas/UsuarioSchema"),
     *                             @OA\Property(property="cliente", ref="#/components/schemas/ClienteSchema"),
     *                             @OA\Property(property="tipo_facturacion", ref="#/components/schemas/TipoFacturacionSchema"),
     *                             @OA\Property(
     *                                 property="detalles",
     *                                 type="array",
     *                                 @OA\Items(
     *                                     allOf={
     *                                         @OA\Schema(ref="#/components/schemas/DetalleProformaSchema"),
     *                                         @OA\Schema(
     *                                             @OA\Property(property="servicio", ref="#/components/schemas/ServicioSchema")
     *                                         )
     *                                     }
     *                                 )
     *                             )
     *                         )
     *                     }
     *                 )
     *             ),
     *             @OA\Property(property="total", type="integer", example=50),
     *             @OA\Property(property="current_page", type="integer", example=1),
     *             @OA\Property(property="per_page", type="integer", example=10)
     *         )
     *     )
     * )
     */
    public function ProformasParaOT(Request $request): JsonResponse
    {
        $idsede = $request->query('idsede');

        if (!$idsede) {
            return response()->json(['error' => 'Parámetro idsede requerido'], 400);
        }

        $proformas = Proforma::with(['sede', 'cliente', 'usuario', 'tipoFacturacion', 'detalles.servicio'])
            ->where('idsede', $idsede)
            ->where('status', 'Autorizada')
            ->get();

        return response()->json(['data' => $proformas]);
    }

    /**
     * @OA\Get(
     *     path="/api/proformas-por-aprobar/lista",
     *     tags={"Proformas"},
     *     summary="Obtiene una lista paginada de proformas por aprobar",
     *     description="Devuelve una lista paginada de proformas con usuario, cliente, tipo de facturación y detalles de servicios.",
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
     *         name="search",
     *         in="query",
     *         description="Buscar por nombre comercial, número de proforma o fecha de emisión",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="idsede",
     *         in="query",
     *         description="ID de la sede para filtrar proformas",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista paginada de proformas",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/ProformaSchema")),
     *             @OA\Property(property="current_page", type="integer", example=1),
     *             @OA\Property(property="last_page", type="integer", example=5),
     *             @OA\Property(property="per_page", type="integer", example=10),
     *             @OA\Property(property="total", type="integer", example=50),
     *             @OA\Property(property="from", type="integer", example=1),
     *             @OA\Property(property="to", type="integer", example=10),
     *             @OA\Property(property="path", type="string", example="http://tuapi.com/api/proformas-por-aprobar/lista"),
     *             @OA\Property(property="first_page_url", type="string", example="http://tuapi.com/api/proformas-por-aprobar/lista?page=1"),
     *             @OA\Property(property="last_page_url", type="string", example="http://tuapi.com/api/proformas-por-aprobar/lista?page=5"),
     *             @OA\Property(property="next_page_url", type="string", nullable=true, example="http://tuapi.com/api/proformas-por-aprobar/lista?page=2"),
     *             @OA\Property(property="prev_page_url", type="string", nullable=true, example=null)
     *         )
     *     )
     * )
     */
    public function proformaPorAutorizar(Request $request): JsonResponse
    {
        $idsede = $request->query('idsede');

        $perPage = $request->query('per_page', 10); // default 10
        $search = $request->query('search', '');

        $query = Proforma::select(
            'proformas.idproforma',
            'ordenesTrabajo.idorden',
            'proformas.fechaEmision',
            'proformas.num_proforma',
            'proformas.num_ot',
            'proformas.num_actualizacion',
            'proformas.idsede',
            'proformas.idcliente',
            'clientes.nombre_comercial',
            'proformas.status'
        )
            ->join('clientes', 'clientes.idcliente', '=', 'proformas.idcliente')
            ->leftJoin('ordenesTrabajo', 'ordenesTrabajo.idproforma', '=', 'proformas.idproforma')
            ->where('proformas.status', 'Pendiente')
            ->where('proformas.idsede', $idsede);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('clientes.nombre_comercial', 'like', "%$search%")
                    ->orWhere('proformas.num_proforma', 'like', "%$search%")
                    ->orWhere('proformas.fechaEmision', 'like', "%$search%");
            });
        }

        $proformas = $query->orderByDesc('proformas.idproforma')->paginate($perPage);

        return response()->json($proformas);
    }


    /**
     * @OA\Post(
     *     path="/api/proformas",
     *     tags={"Proformas"},
     *     summary="Crear una nueva proforma con detalles",
     *     description="Registra una nueva proforma con su respectivo detalle de servicios.",
     *     operationId="storeProforma",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ProformaSchema")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="cliente creado con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="cliente creado con éxito."),
     *             @OA\Property(property="data", ref="#/components/schemas/ProformaSchema")
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
        AuditoriaService::setContextInfo('ProcesosdeProformas');

        $validated = $request->validate([
            'idusuario' => 'required|integer|exists:users,id',
            'idsede' => 'required|integer|exists:sedes,idsede',
            'idcliente' => 'required|integer|exists:clientes,idcliente',
            'num_proforma' => 'nullable|string|max:15',
            'num_ot' => 'nullable|string|max:15',
            'num_actualizacion' => 'nullable|string|max:15',
            'fechaEmision' => 'required|date',
            'fechaEstimadaInicio' => 'required|date|after_or_equal:fechaEmision',
            'fechaEstimadaFinalizacion' => 'required|date|after_or_equal:fechaEstimadaInicio',
            'horasEstimadas' => 'required|string|max:20',
            'correo' => 'required|email|max:255',
            'comentario' => 'nullable|string|max:255',
            'solicitante' => 'required|string|max:255',
            'idTipoFacturacion' => 'required|integer|exists:tipoFacturacion,idTipoFacturacion',

            // detalles (detalle de la proforma)
            'detalles' => 'required|array|min:1',
            'detalles.*.idservicio' => 'required|integer|exists:servicios,idservicio',
            'detalles.*.descripcion' => 'nullable|string|max:255',
            'detalles.*.cantidad' => 'required|numeric|min:0.01',
            'detalles.*.precio' => 'required|numeric|min:0.01',
            'detalles.*.urgente' => 'required|boolean',
        ]);

        DB::beginTransaction();

        try {
            // Buscar la sede
            $sede = Sede::find($request->idsede);
            if (!$sede) {
                return response()->json(['message' => 'Sede no encontrada'], 404);
            }

            // Incrementar el número actual de proforma
            $nuevoNumeroProforma = (int) $sede->num_actual_proforma + 1;
            $numeroProformaFormateado = str_pad($nuevoNumeroProforma, 6, '0', STR_PAD_LEFT);

            // Actualizar el número actual en sede
            $sede->num_actual_proforma = $nuevoNumeroProforma;
            $sede->save();

            $proforma = Proforma::create([
                'num_proforma' => $numeroProformaFormateado,
                'idusuario' => $validated['idusuario'],
                'idsede' => $validated['idsede'],
                'idcliente' => $validated['idcliente'],
                'fechaEmision' => $validated['fechaEmision'],
                'fechaEstimadaInicio' => $validated['fechaEstimadaInicio'],
                'fechaEstimadaFinalizacion' => $validated['fechaEstimadaFinalizacion'],
                'horasEstimadas' => $validated['horasEstimadas'],
                'correo' => $validated['correo'],
                'comentario' => $validated['comentario'] ?? '',
                'solicitante' => $validated['solicitante'],
                'idTipoFacturacion' => $validated['idTipoFacturacion'],
                'numeroActualizado' => $validated['numeroActualizado'] ?? 0,
                'status' => 'Pendiente',
            ]);

            foreach ($validated['detalles'] as $detalle) {
                DetalleProforma::create([
                    'idproforma' => $proforma->idproforma,
                    'idservicio' => $detalle['idservicio'],
                    'descripcion' => isset($detalle['descripcion']) ? $detalle['descripcion'] : '',
                    'cantidad' => $detalle['cantidad'],
                    'precio' => $detalle['precio'],
                    'urgente' => $detalle['urgente'],
                ]);
            }

            DB::commit();

            return response()->json(
                [
                    'message' => 'Proforma creada correctamente',
                    'data' => $proforma,
                ],
                201,
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(
                [
                    'error' => 'Error al crear proforma',
                    'details' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    /**
     * @OA\Get(
     *     path="/api/proformas/{id}",
     *     tags={"Proformas"},
     *     summary="Obtiene una proforma con cliente, tipo de facturación y detalles de servicios",
     *     description="Consulta detallada de una proforma específica, incluyendo información del cliente, tipo de facturación y sus detalles de servicios.",
     *     operationId="showProforma",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID numérico de la proforma a consultar",
     *         example=1,
     *         @OA\Schema(type="integer", format="int64")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Proforma encontrada exitosamente",
     *         @OA\JsonContent(
     *             allOf={
     *                 @OA\Schema(ref="#/components/schemas/ProformaSchema"),
     *                 @OA\Schema(
     *                     @OA\Property(property="usuario", ref="#/components/schemas/UsuarioSchema"),
     *                     @OA\Property(property="cliente", ref="#/components/schemas/ProformaSchema"),
     *                     @OA\Property(property="tipo_facturacion", ref="#/components/schemas/TipoFacturacionSchema"),
     *                     @OA\Property(
     *                         property="detalles",
     *                         type="array",
     *                         @OA\Items(
     *                             allOf={
     *                                 @OA\Schema(ref="#/components/schemas/DetalleProformaSchema"),
     *                                 @OA\Schema(
     *                                     @OA\Property(property="servicio", ref="#/components/schemas/ServicioSchema")
     *                                 )
     *                             }
     *                         )
     *                     )
     *                 )
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Proforma no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Proforma no encontrada.")
     *         )
     *     )
     * )
     */
    public function show($id): JsonResponse
    {
        // Buscar proforma con relaciones: cliente, tipo de facturación y detalles con servicio
        $proforma = Proforma::with(['tipoFacturacion', 'usuario', 'cliente', 'detalles.servicio'])->find($id);

        // Si no se encuentra la proforma, devolver error 404
        if (!$proforma) {
            return response()->json(
                [
                    'message' => 'Proforma no encontrada.',
                ],
                404,
            );
        }

        // Devolver proforma con datos relacionados
        return response()->json($proforma);
    }

    /**
     * @OA\Put(
     *     path="/api/proformas/{idcliente}",
     *     tags={"Proformas"},
     *     summary="Actualizar una proforma",
     *     description="Actualiza los datos básicos de una proforma existente, identificada por el ID del cliente asociado.",
     *     operationId="updateProforma",
     *     @OA\Parameter(
     *         name="idcliente",
     *         in="path",
     *         required=true,
     *         description="ID del cliente relacionado a la proforma a actualizar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"ruc_cedula", "nombre_comercial", "direccion", "telefono", "email", "estado"},
     *             @OA\Property(property="ruc_cedula", type="string", example="0999999999"),
     *             @OA\Property(property="nombre_comercial", type="string", example="Servicios Integrales XYZ"),
     *             @OA\Property(property="direccion", type="string", example="Av. 10 de Agosto y Naciones Unidas"),
     *             @OA\Property(property="telefono", type="string", example="0991234567"),
     *             @OA\Property(property="email", type="string", example="cliente@empresa.com"),
     *             @OA\Property(property="estado", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Proforma actualizada con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Proforma actualizada con éxito."),
     *             @OA\Property(property="data", ref="#/components/schemas/ProformaSchema")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Proforma no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Proforma no encontrada.")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $idcliente): JsonResponse
    {
        // Registrar auditoría del proceso
        AuditoriaService::setContextInfo('ProcesosdeCliente');

        // Buscar proforma por ID
        $proforma = Proforma::find($idcliente);

        // Si no existe, retornar 404
        if (!$proforma) {
            return response()->json(
                [
                    'message' => 'Proforma no encontrada.',
                ],
                404,
            );
        }

        // Validar entrada
        $validated = $request->validate([
            'ruc_cedula' => ['required', 'string', 'regex:/^\d{10}|\d{13}$/'],
            'nombre_comercial' => ['required', 'string', 'max:150'],
            'direccion' => ['required', 'string', 'max:200'],
            'telefono' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:150'],
            'estado' => ['required', 'boolean'],
        ]);

        // Actualizar la proforma
        $proforma->update($validated);

        // Retornar respuesta exitosa
        return response()->json([
            'message' => 'Proforma actualizada con éxito.',
            'data' => $proforma,
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/proformas/{idcliente}",
     *     summary="Eliminar un proforma",
     *     description="Esta ruta permite eliminar un proforma existente.",
     *     tags={"Proformas"},
     *     @OA\Parameter(
     *         name="idcliente",
     *         in="path",
     *         required=true,
     *         description="ID del proforma",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="proforma eliminado con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="proforma eliminado con éxito.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="proforma no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="proforma no encontrado.")
     *         )
     *     )
     * )
     */
    public function destroy($idcliente): JsonResponse
    {
        // Configurar información de auditoría en el contexto SQL para la tabla "proformas"
        AuditoriaService::setContextInfo('ProcesosdeBodega');

        $proforma = proforma::find($idcliente);

        if (!$proforma) {
            return response()->json(
                [
                    'message' => 'proforma no encontrado.',
                ],
                404,
            );
        }

        $proforma->delete();

        return response()->json([
            'message' => 'proforma eliminado con éxito.',
        ]);
    }

    private function prepararPdf(Proforma $proforma)
    {
        //Total Dias
        $fechaInicio = Carbon::parse($proforma->fechaEstimadaInicio);
        $fechaFin = Carbon::parse($proforma->fechaEstimadaFinalizacion);
        $dias = $fechaInicio->diffInDays($fechaFin);

        $porcentajeIva = Parametro::obtener('IVA'); // devuelve "15"
        $porcentajeUrgente = Parametro::obtener('Porcentaje de Urgencia'); // devuelve "16"

        $logoPath = public_path('logo/cripada-logo.svg');

        $pdf = Pdf::loadView('pdf.proforma', compact('proforma', 'logoPath', 'dias', 'porcentajeIva', 'porcentajeUrgente'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ])
            ->setWarnings(false);

        // Aquí añades el número de páginas:
        $dompdf = $pdf->getDomPDF();
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

        return $pdf;
    }

    /**
     * @OA\Get(
     *     path="/api/proformas/{id}/descargar",
     *     tags={"Proformas"},
     *     summary="Descarga el PDF de una proforma",
     *     description="Genera y descarga automáticamente el PDF con los datos completos de la proforma, incluyendo cliente, tipo de facturación y servicios.",
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
     *         description="Proforma no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Proforma no encontrada.")
     *         )
     *     )
     * )
     */
    public function descargarPdf($id): Response
    {
        $proforma = Proforma::with(['cliente', 'tipoFacturacion', 'detalles.servicio'])->find($id);
        if (!$proforma) {
            return response()->view('pdf.proforma_no_encontrada', [], 404);
        }
        $pdf = $this->prepararPdf($proforma);
        return $pdf->download('Proforma Nº ' . $proforma->idproforma . ' ' . $proforma->cliente->nombre_comercial . '.pdf');
    }

    /**
     * @OA\Get(
     *     path="/api/proformas/{id}/visualizar",
     *     tags={"Proformas"},
     *     summary="Descarga el PDF de una proforma",
     *     description="Genera y descarga automáticamente el PDF con los datos completos de la proforma, incluyendo cliente, tipo de facturación y servicios.",
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
     *         description="Proforma no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Proforma no encontrada.")
     *         )
     *     )
     * )
     */
    public function visualizarPdf($id): Response
    {
        $proforma = Proforma::with(['cliente', 'tipoFacturacion', 'detalles.servicio'])->find($id);
        if (!$proforma) {
            return response()->view('pdf.proforma_no_encontrada', [], 404);
        }
        $pdf = $this->prepararPdf($proforma);
        return $pdf->stream('Proforma Nº ' . $proforma->idproforma . ' ' . $proforma->cliente->nombre_comercial . '.pdf');
    }

    /**
     * @OA\Patch(
     *     path="/api/proformas/{id}/anular",
     *     tags={"Proformas"},
     *     summary="Anula la proforma y actualiza el contador de anulaciones (num_actualizacion) en la sede",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la proforma",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"idsede"},
     *             @OA\Property(property="idsede", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Proforma anulada correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Proforma anulada correctamente"),
     *             @OA\Property(property="num_actualizacion", type="integer", example=3)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Proforma o sede no encontrada"
     *     )
     * )
     */
    public function anularProforma(Request $request, $idproforma)
    {
        $request->validate([
            'idsede' => 'required|integer',
        ]);

        // Buscar la proforma
        $proforma = Proforma::find($idproforma);
        if (!$proforma) {
            return response()->json(['message' => 'Proforma no encontrada'], 404);
        }

        // Buscar la sede
        $sede = Sede::find($request->idsede);
        if (!$sede) {
            return response()->json(['message' => 'Sede no encontrada'], 404);
        }

        // Incrementar el contador de actualizaciones
        $nuevoNumActualizacion = (int) $sede->num_actualizacion + 1;

        // Anular la proforma
        $proforma->num_actualizacion = $nuevoNumActualizacion;
        $proforma->status = 'Anulada';
        $proforma->save();

        return response()->json([
            'message' => 'Proforma anulada correctamente',
            'num_actualizacion' => $nuevoNumActualizacion,
        ]);
    }

    /**
     * @OA\Patch(
     *     path="/api/proformas/{id}/actualizar-numero-ot",
     *     tags={"Proformas"},
     *     summary="Asigna y actualiza número de OT en la proforma usando la secuencia de la sede",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la proforma",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"idsede"},
     *             @OA\Property(property="idsede", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Número de OT actualizado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Número de OT asignado correctamente"),
     *             @OA\Property(property="numero_ot", type="string", example="000001")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Proforma o sede no encontrada"
     *     )
     * )
     */
    public function actualizarNumeroOT(Request $request, $idproforma)
    {
        $request->validate([
            'idsede' => 'required|integer',
        ]);

        // Buscar la proforma
        $proforma = Proforma::find($idproforma);
        if (!$proforma) {
            return response()->json(['message' => 'Proforma no encontrada'], 404);
        }

        // Buscar la sede
        $sede = Sede::find($request->idsede);
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

    /**
     * @OA\Patch(
     *     path="/api/proformas/{id}/actualizar-numero-factura",
     *     tags={"Proformas"},
     *     summary="Asigna y actualiza número de factura en la proforma usando la secuencia de la sede",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la proforma",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"idsede"},
     *             @OA\Property(property="idsede", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Número de factura actualizado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Número de factura asignado correctamente"),
     *             @OA\Property(property="numero_factura", type="string", example="000001")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Proforma o sede no encontrada"
     *     )
     * )
     */
    public function actualizarNumeroFactura(Request $request, $idproforma)
    {
        $request->validate([
            'idsede' => 'required|integer',
        ]);

        // Buscar la proforma
        $proforma = Proforma::find($idproforma);
        if (!$proforma) {
            return response()->json(['message' => 'Proforma no encontrada'], 404);
        }

        // Buscar la sede
        $sede = Sede::find($request->idsede);
        if (!$sede) {
            return response()->json(['message' => 'Sede no encontrada'], 404);
        }

        // Incrementar el número actual de factura
        $nuevoNumeroFactura = (int) $sede->num_actual_factura + 1;

        // Actualizar el número actual en sede
        $sede->num_actual_factura = $nuevoNumeroFactura;
        $sede->save();

        // Formatear con ceros a la izquierda
        $numeroFacturaFormateado = str_pad($nuevoNumeroFactura, 6, '0', STR_PAD_LEFT);

        // Asignar a la proforma
        $proforma->num_factura = $numeroFacturaFormateado;
        $proforma->status = 'Facturada'; // si quieres actualizar el estado, puedes cambiarlo o comentarlo
        $proforma->save();

        return response()->json([
            'message' => 'Número de factura asignado correctamente',
            'numero_factura' => $numeroFacturaFormateado,
        ]);
    }

    /**
     * @OA\Patch(
     *     path="/api/proformas/{id}/actualizar-numero-proforma",
     *     tags={"Proformas"},
     *     summary="Asigna y actualiza número de proforma en la proforma usando la secuencia de la sede",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la proforma",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"idsede"},
     *             @OA\Property(property="idsede", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Número de proforma actualizado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Número de proforma asignado correctamente"),
     *             @OA\Property(property="num_proforma", type="string", example="000001")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Proforma o sede no encontrada"
     *     )
     * )
     */
    public function actualizarNumeroProforma(Request $request, $idproforma)
    {
        $request->validate([
            'idsede' => 'required|integer',
        ]);

        // Buscar la proforma
        $proforma = Proforma::find($idproforma);
        if (!$proforma) {
            return response()->json(['message' => 'Proforma no encontrada'], 404);
        }

        // Buscar la sede
        $sede = Sede::find($request->idsede);
        if (!$sede) {
            return response()->json(['message' => 'Sede no encontrada'], 404);
        }

        // Incrementar el número actual de proforma
        $nuevoNumeroProforma = (int) $sede->num_actual_proforma + 1;

        // Actualizar el número actual en sede
        $sede->num_actual_proforma = $nuevoNumeroProforma;
        $sede->save();

        // Formatear el número con ceros a la izquierda
        $numeroProformaFormateado = str_pad($nuevoNumeroProforma, 6, '0', STR_PAD_LEFT);

        // Asignar a la proforma
        $proforma->num_proforma = $numeroProformaFormateado;
        $proforma->status = 'Aprobada'; // Opcional: si quieres aprobar
        $proforma->save();

        return response()->json([
            'message' => 'Número de proforma asignado correctamente',
            'num_proforma' => $numeroProformaFormateado,
        ]);
    }


    /**
     * @OA\Get(
     *     path="/api/numero-proformas/app/select",
     *     tags={"Proformas"},
     *     summary="Obtiene la lista numeros de proformas para convertir en ot para select",
     *     @OA\Response(
     *         response=200,
     *         description="Lista completa de numeros de proformas para convertir en ot",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/ProformaSchema")
     *         )
     *     )
     * )
     */
    public function getNumerosProformasParaOTSelect(): JsonResponse
    {
        // Obtienes todos los clientes activos
        $numProforma = Proforma::select('idproforma', 'num_proforma')
            ->where('status', 'Autorizada')
            ->get();

        return response()->json($numProforma);
    }
}
