<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\SedeController;
use App\Http\Controllers\AsignarSedeController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\ProformaController;
use App\Http\Controllers\ProformaAprobadaController;

use App\Http\Controllers\OrdenTrabajoController;

use App\Http\Controllers\ParametroController;

use App\Http\Middleware\CheckPermisos;

use App\Http\Controllers\PrecioServiciosController;
use App\Http\Controllers\ServiciosCategoriaController;
use App\Http\Controllers\TipoFacturacionController;
use App\Http\Controllers\FacturacionController;

use App\Http\Controllers\EmailController;
use App\Http\Controllers\ReportesController;
use App\Models\AsignarSede;

use Illuminate\Support\Facades\DB;
Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        return "✅ ¡Conexión exitosa a SQL Server!";
    } catch (\Exception $e) {
        return "❌ Error: " . $e->getMessage();
    }
});

/*
 * SELECT
 */
// metodo => Clientes Select
Route::get('/clientes/app/select', [ClienteController::class, 'getClientesSelect']);
// metodo => Servicios Select
Route::get('/servicios/app/select', [ServiciosController::class, 'getServiciosSelect']);
// metodo => Tipo Facturacion Select
Route::get('/tipo-de-facturacion/app/select', [TipoFacturacionController::class, 'getTipoFacturacionSelect']);
// metodo => Usuarios Select
Route::get('/usuarios/app/select', [AuthController::class, 'getUsuariosSelect']);
// metodo => Usuarios Select
Route::get('/sedes/app/select', [SedeController::class, 'getSedesSelect']);
// metodo => Usuarios Select
Route::get('/numero-proformas/app/select', [ProformaController::class, 'getNumerosProformasParaOTSelect']);
// metodo => Asignar Sede Select
Route::get('/asignar-sedes/app/select/{idusuario}', [AsignarSedeController::class, 'getAsignarSedeSelect']);

/*
 * VARIOS
 */
Route::middleware('auth:sanctum')->group(function () {
    Route::post('envio-de-correo', [EmailController::class, 'enviarCorreo']);
    Route::apiResource('auditorias', App\Http\Controllers\AuditoriaController::class);
});

/*
 * USUARIOS
 */
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::post('/usuarios/register', [AuthController::class, 'register']);
Route::match(['PUT', 'POST'], 'usuarios/{idusuario}', [AuthController::class, 'update']);
Route::get('/profile', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    // index => Ver
    Route::get('usuarios', [AuthController::class, 'index'])->middleware(CheckPermisos::class . ':users,Ver listado');
    // paginacion => Ver
    Route::get('/usuarios/paginated', [AuthController::class, 'paginated'])->middleware(CheckPermisos::class . ':users,Ver listado');
});

/*
 * ROLES Y PERMISOS
 */
Route::apiResource('permisos', PermisoController::class);
Route::post('/roles/{idrol}/permisos', [RolController::class, 'asignarPermisos']);
Route::get('/roles/{id}/permisos', [RolController::class, 'obtenerPermisos']);

Route::middleware('auth:sanctum')->group(function () {
    // index => Ver
    Route::get('roles', [RolController::class, 'index'])->middleware(CheckPermisos::class . ':roles,Ver listado');

    // store => Crear
    Route::post('roles', [RolController::class, 'store'])->middleware(CheckPermisos::class . ':roles,Crear');

    // paginacion => Ver
    Route::get('/roles/paginated', [RolController::class, 'paginated'])->middleware(CheckPermisos::class . ':roles,Ver listado');
    // show => Ver
    Route::get('roles/{rol}', [RolController::class, 'show'])->middleware(CheckPermisos::class . ':roles,Ver listado');
    // update => Editar
    Route::put('roles/{rol}', [RolController::class, 'update'])->middleware(CheckPermisos::class . ':roles,Editar');
    Route::patch('roles/{rol}', [RolController::class, 'update'])->middleware(CheckPermisos::class . ':roles,Editar');

    // destroy => Eliminar
    Route::delete('roles/{rol}', [RolController::class, 'destroy'])->middleware(CheckPermisos::class . ':roles,Eliminar');
});

//CLIENTES
Route::middleware('auth:sanctum')->group(function () {
    // index => Ver
    Route::get('clientes', [ClienteController::class, 'index'])->middleware(CheckPermisos::class . ':clientes,Ver listado');

    // store => Crear
    Route::post('clientes', [ClienteController::class, 'store'])->middleware(CheckPermisos::class . ':clientes,Crear');

    // paginacion => Ver
    Route::get('/clientes/paginated', [ClienteController::class, 'paginated'])->middleware(CheckPermisos::class . ':clientes,Ver listado');
    // show => Ver
    Route::get('clientes/{cliente}', [ClienteController::class, 'show'])->middleware(CheckPermisos::class . ':clientes,Ver listado');
    // update => Editar
    Route::put('clientes/{cliente}', [ClienteController::class, 'update'])->middleware(CheckPermisos::class . ':clientes,Editar');
    Route::patch('clientes/{cliente}', [ClienteController::class, 'update'])->middleware(CheckPermisos::class . ':clientes,Editar');

    // destroy => Eliminar
    Route::delete('clientes/{cliente}', [ClienteController::class, 'destroy'])->middleware(CheckPermisos::class . ':clientes,Eliminar');
});

//SERVICIOS
Route::middleware('auth:sanctum')->group(function () {
    // index => Ver
    Route::get('/servicios', [ServiciosController::class, 'index'])->middleware(CheckPermisos::class . ':servicios,Ver listado');
    // store => Crear
    Route::post('/servicios', [ServiciosController::class, 'store'])->middleware(CheckPermisos::class . ':servicios,Crear');

    // paginacion => Ver
    Route::get('/servicios/paginated', [ServiciosController::class, 'paginated'])->middleware(CheckPermisos::class . ':servicios,Ver listado');
    // show => Ver
    Route::get('/servicios/{servicio}', [ServiciosController::class, 'show'])->middleware(CheckPermisos::class . ':servicios,Ver listado');

    // update => Editar
    Route::put('/servicios/{servicio}', [ServiciosController::class, 'update'])->middleware(CheckPermisos::class . ':servicios,Editar');
    Route::patch('/servicios/{cliente}', [ServiciosController::class, 'update'])->middleware(CheckPermisos::class . ':servicios,Editar');

    // destroy => Eliminar
    Route::delete('/servicios/{servicio}', [ServiciosController::class, 'destroy'])->middleware(CheckPermisos::class . ':servicios,Eliminar');
});

//PRECIO SERVICIOS
Route::middleware('auth:sanctum')->group(function () {
    // rangos de precios
    Route::post('precio-servicios/servicio/rango', [PrecioServiciosController::class, 'obtenerPrecioPorCantidad']);
    // paginacion rangos de precios por servicios => Ver
    Route::get('/precio-servicios/paginated/{idServicio}', [PrecioServiciosController::class, 'obtenerPreciosPorIdServicio'])->middleware(CheckPermisos::class . ':precioServicios,Ver listado');
    // paginacion rangos de precios por servicios => Ver
    Route::get('/precio-servicios/lista/{idServicio}', [PrecioServiciosController::class, 'oPreciosPorIdServicio'])->middleware(CheckPermisos::class . ':precioServicios,Ver listado');

    // store => Crear
    Route::post('/precio-servicios', [PrecioServiciosController::class, 'store'])->middleware(CheckPermisos::class . ':precioServicios,Crear');

    // index => Ver
    Route::get('/precio-servicios', [PrecioServiciosController::class, 'index'])->middleware(CheckPermisos::class . ':precioServicios,Ver listado');

    // show => Ver
    Route::get('/precio-servicios/{precioServicios}', [PrecioServiciosController::class, 'show'])->middleware(CheckPermisos::class . ':precioServicios,Ver listado');

    // update => Editar
    Route::put('/precio-servicios/{precioServicios}', [PrecioServiciosController::class, 'update'])->middleware(CheckPermisos::class . ':precioServicios,Editar');
    Route::patch('/precio-servicios/{precioServicios}', [PrecioServiciosController::class, 'update'])->middleware(CheckPermisos::class . ':precioServicios,Editar');

    // destroy => Eliminar
    Route::delete('/precio-servicios/{precioServicios}', [PrecioServiciosController::class, 'destroy'])->middleware(CheckPermisos::class . ':precioServicios,Eliminar');
});

//CATEGORIA DE SERVICIOS
Route::middleware('auth:sanctum')->group(function () {
    // index => Ver
    Route::get('/categorias-servicios', [ServiciosCategoriaController::class, 'index'])->middleware(CheckPermisos::class . ':servicios,Ver listado');
    // store => Crear
    Route::post('/categorias-servicios', [ServiciosCategoriaController::class, 'store'])->middleware(CheckPermisos::class . ':servicios,Crear');
    // paginacion => Ver
    Route::get('/categorias-servicios/paginated', [ServiciosCategoriaController::class, 'paginated'])->middleware(CheckPermisos::class . ':servicios,Ver listado');
    // show => Ver
    Route::get('/categorias-servicios/{categoria}', [ServiciosCategoriaController::class, 'show'])->middleware(CheckPermisos::class . ':servicios,Ver listado');
    // update => Editar
    Route::put('/categorias-servicios/{categoria}', [ServiciosCategoriaController::class, 'update'])->middleware(CheckPermisos::class . ':servicios,Editar');
    // destroy => Eliminar
    Route::delete('/categorias-servicios/{categoria}', [ServiciosCategoriaController::class, 'destroy'])->middleware(CheckPermisos::class . ':servicios,Eliminar');
});

//SEDE
Route::middleware('auth:sanctum')->group(function () {
    // paginacion => Ver
    Route::get('/sedes/paginated', [SedeController::class, 'paginated'])->middleware(CheckPermisos::class . ':sedes,Ver listado');
    // index => Ver
    Route::get('/sedes', [SedeController::class, 'index'])->middleware(CheckPermisos::class . ':sedes,Ver listado');
    // show => Ver
    Route::get('/sedes/{sede}', [SedeController::class, 'show'])->middleware(CheckPermisos::class . ':sedes,Ver listado');

    // store => Crear
    Route::post('/sedes', [SedeController::class, 'store'])->middleware(CheckPermisos::class . ':sedes,Crear');

    // update => Editar
    Route::put('/sedes/{sede}', [SedeController::class, 'update'])->middleware(CheckPermisos::class . ':sedes,Editar');
    Route::patch('/sedes/{sede}', [SedeController::class, 'update'])->middleware(CheckPermisos::class . ':sedes,Editar');

    // destroy => Eliminar
    Route::delete('/sedes/{sede}', [SedeController::class, 'destroy'])->middleware(CheckPermisos::class . ':sedes,Eliminar');
});

//ASIGNAR SEDES
Route::middleware('auth:sanctum')->group(function () {
    // show => Ver
    Route::get('/asignar-sedes/usuario/{idusuario}', [AsignarSedeController::class, 'show'])->middleware(CheckPermisos::class . ':asignarSedes,Ver listado');

    // index => Ver
    Route::get('/asignar-sedes', [AsignarSedeController::class, 'index'])->middleware(CheckPermisos::class . ':asignarSedes,Ver listado');

    // paginacion => Ver
    Route::get('/asignar-sedes/paginated', [AsignarSedeController::class, 'paginated'])->middleware(CheckPermisos::class . ':asignarSedes,Ver listado');

    // store => Crear
    Route::post('/asignar-sedes', [AsignarSedeController::class, 'store'])->middleware(CheckPermisos::class . ':asignarSedes,Crear');

    // update => Editar
    Route::put('/asignar-sedes/{sede}', [AsignarSedeController::class, 'update'])->middleware(CheckPermisos::class . ':asignarSedes,Editar');
    Route::patch('/asignar-sedes/{sede}', [AsignarSedeController::class, 'update'])->middleware(CheckPermisos::class . ':asignarSedes,Editar');

    // destroy => Eliminar
    Route::delete('/asignar-sedes/{sede}', [AsignarSedeController::class, 'destroy'])->middleware(CheckPermisos::class . ':asignarSedes,Eliminar');
});

//PARAMETROS
Route::middleware('auth:sanctum')->group(function () {
    // store => Crear
    Route::post('/parametros', [ParametroController::class, 'store'])->middleware(CheckPermisos::class . ':parametros,Crear');

    // paginacion => Ver
    Route::get('/parametros/paginated', [ParametroController::class, 'paginated'])->middleware(CheckPermisos::class . ':parametros,Ver listado');
    // index => Ver
    Route::get('/parametros', [ParametroController::class, 'index'])->middleware(CheckPermisos::class . ':parametros,Ver listado');
    // show => Ver
    Route::get('/parametros/{parametro}', [ParametroController::class, 'show'])->middleware(CheckPermisos::class . ':parametros,Ver listado');

    // update => Editar
    Route::put('/parametros/{parametro}', [ParametroController::class, 'update'])->middleware(CheckPermisos::class . ':parametros,Editar');
    Route::patch('/parametros/{parametro}', [ParametroController::class, 'update'])->middleware(CheckPermisos::class . ':parametros,Editar');

    // destroy => Eliminar
    Route::delete('/parametros/{parametro}', [ParametroController::class, 'destroy'])->middleware(CheckPermisos::class . ':parametros,Eliminar');
});

//FACTURACION
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/lote', [FacturacionController::class, 'storeLote']);

    // index => Ver
    Route::get('/facturacion', [FacturacionController::class, 'index'])->middleware(CheckPermisos::class . ':facturacion,Ver listado');

    // store => Crear
    Route::post('/facturacion', [FacturacionController::class, 'store'])->middleware(CheckPermisos::class . ':facturacion,Crear');

    // show => Ver
    Route::get('/facturacion/{facturacion}', [FacturacionController::class, 'show'])->middleware(CheckPermisos::class . ':facturacion,Ver listado');

    // update => Editar
    Route::put('/facturacion/{facturacion}', [FacturacionController::class, 'update'])->middleware(CheckPermisos::class . ':facturacion,Editar');
    Route::patch('/facturacion/{facturacion}', [FacturacionController::class, 'update'])->middleware(CheckPermisos::class . ':facturacion,Editar');

    // destroy => Eliminar
    Route::delete('/facturacion/{facturacion}', [FacturacionController::class, 'destroy'])->middleware(CheckPermisos::class . ':facturacion,Eliminar');
});

//TIPO DE FACTURACION
Route::middleware('auth:sanctum')->group(function () {
    // store => Crear
    Route::post('/tipo-de-facturacion', [TipoFacturacionController::class, 'store'])->middleware(CheckPermisos::class . ':tipoFacturacion,Crear');

    // paginacion => Ver
    Route::get('/tipo-de-facturacion/paginated', [TipoFacturacionController::class, 'paginated'])->middleware(CheckPermisos::class . ':tipoFacturacion,Ver listado');
    // index => Ver
    Route::get('/tipo-de-facturacion', [TipoFacturacionController::class, 'index'])->middleware(CheckPermisos::class . ':tipoFacturacion,Ver listado');
    // show => Ver
    Route::get('/tipo-de-facturacion/{tipoFacturacion}', [TipoFacturacionController::class, 'show'])->middleware(CheckPermisos::class . ':tipoFacturacion,Ver listado');

    // update => Editar
    Route::put('/tipo-de-facturacion/{tipoFacturacion}', [TipoFacturacionController::class, 'update'])->middleware(CheckPermisos::class . ':tipoFacturacion,Editar');
    Route::patch('/tipo-de-facturacion/{tipoFacturacion}', [TipoFacturacionController::class, 'update'])->middleware(CheckPermisos::class . ':tipoFacturacion,Editar');

    // destroy => Eliminar
    Route::delete('/tipo-de-facturacion/{tipoFacturacion}', [TipoFacturacionController::class, 'destroy'])->middleware(CheckPermisos::class . ':tipoFacturacion,Eliminar');
});

//PROFORMAS
Route::middleware('auth:sanctum')->group(function () {
    // index => Ver
    Route::get('/proforma/{id}/enviar-pdf', [EmailController::class, 'generarProformaYEnviarPdf'])->middleware(CheckPermisos::class . ':proformas,Ver listado');
    Route::get('/proformas', [ProformaController::class, 'index'])->middleware(CheckPermisos::class . ':proformas,Ver listado');
    Route::get('/proformas/paginated', [ProformaController::class, 'paginated'])->middleware(CheckPermisos::class . ':proformas,Ver listado');
    Route::get('/proformas/para-orden-de-trabajo', [ProformaController::class, 'ProformasParaOT'])->middleware(CheckPermisos::class . ':proformas,Ver listado');

    Route::get('/proformas-por-aprobar/lista', [ProformaController::class, 'proformaPorAutorizar'])->middleware(CheckPermisos::class . ':proformas,Ver listado');
    Route::get('/proformas/{id}/visualizar', [ProformaController::class, 'visualizarPdf'])->middleware(CheckPermisos::class . ':proformas,Ver PDF');
    Route::get('/proformas/{id}/descargar', [ProformaController::class, 'descargarPdf'])->middleware(CheckPermisos::class . ':proformas,Descargar PDF');

    // store => Crear
    Route::post('/proformas', [ProformaController::class, 'store'])->middleware(CheckPermisos::class . ':proformas,Crear');
    Route::post('/proformas-aprobadas', [ProformaAprobadaController::class, 'store'])->middleware(CheckPermisos::class . ':proformas,Crear');

    // show => Ver
    Route::get('/proformas/{proforma}', [ProformaController::class, 'show'])->middleware(CheckPermisos::class . ':proformas,Ver listado');

    // update => Editar
    Route::put('/proformas/{proforma}', [ProformaController::class, 'update'])->middleware(CheckPermisos::class . ':proformas,Editar');
    Route::patch('/proformas/{proforma}', [ProformaController::class, 'update'])->middleware(CheckPermisos::class . ':proformas,Editar');

    // destroy => Eliminar
    Route::delete('/proformas/{proforma}', [ProformaController::class, 'destroy'])->middleware(CheckPermisos::class . ':proformas,Eliminar');
});

//ORDEN DE TRABAJO
Route::get('/ordenes-trabajo/paginated', [OrdenTrabajoController::class, 'paginated']);
Route::get('/ordenes-trabajo/ot-por-autorizar', [OrdenTrabajoController::class, 'otPorAutorizar']);
Route::post('/ordenes-trabajo/crear-desde-proforma/{idproforma}', [OrdenTrabajoController::class, 'crearOtDesdeProforma']);
Route::get('/ordenes-trabajo', [OrdenTrabajoController::class, 'index']);
Route::get('/ordenes-trabajo/{idorden}', [OrdenTrabajoController::class, 'show']);
Route::get('/ordenes-trabajo/{id}/visualizar', [OrdenTrabajoController::class, 'visualizarPdf']);
Route::get('/ordenes-trabajo/{id}/descargar', [OrdenTrabajoController::class, 'descargarPdf']);

Route::middleware('auth:sanctum')->group(function () {
    // store => Crear OT
    Route::post('/orden-de-trabajo/{id}/aprobar', [OrdenTrabajoController::class, 'aprobarOrdenDeTrabajo']);
    // index => Ver
    Route::get('/proformas', [ProformaController::class, 'index'])->middleware(CheckPermisos::class . ':proformas,Ver listado');
    Route::get('/proformas/paginated', [ProformaController::class, 'paginated'])->middleware(CheckPermisos::class . ':proformas,Ver listado');
    Route::get('/proformas/{id}/visualizar', [ProformaController::class, 'visualizarPdf'])->middleware(CheckPermisos::class . ':proformas,Ver PDF');
    Route::get('/proformas/{id}/descargar', [ProformaController::class, 'descargarPdf'])->middleware(CheckPermisos::class . ':proformas,Descargar PDF');

    // store => Crear
    Route::post('/proformas', [ProformaController::class, 'store'])->middleware(CheckPermisos::class . ':proformas,Crear');

    // update => Editar
    Route::put('/proformas/{proforma}', [ProformaController::class, 'update'])->middleware(CheckPermisos::class . ':proformas,Editar');
    Route::patch('/proformas/{proforma}', [ProformaController::class, 'update'])->middleware(CheckPermisos::class . ':proformas,Editar');

    // destroy => Eliminar
    Route::delete('/proformas/{proforma}', [ProformaController::class, 'destroy'])->middleware(CheckPermisos::class . ':proformas,Eliminar');
});

//REPORTE 
Route::post('/reporte-cotizaciones/ver-revizar', [ReportesController::class, 'verReporteAPI']);
Route::get('/reporte-cotizaciones/exportar-revizar', [ReportesController::class, 'exportarReporte']);
Route::post('/reporte-cotizaciones/exportar', [ReportesController::class, 'exportarReporteAPI']);
Route::get('/reporte-cotizaciones/exportar-app', [ReportesController::class, 'exportarReporteAPI_Dos']);
