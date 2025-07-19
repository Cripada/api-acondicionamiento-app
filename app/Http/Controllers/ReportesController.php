<?php

namespace App\Http\Controllers;

use App\Models\Proforma;
use Illuminate\Http\Request;
use App\Exports\ReporteAcondicionamientoExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Response;
use OpenApi\Annotations as OA;

class ReportesController extends Controller
{
    public function exportarReporte(Request $request)
    {
        // 🔍 Consulta filtrando por los IDs proporcionados
        $proformas = DB::table('proformas as p')
            ->leftJoin('detalleProforma as d', 'p.idproforma', '=', 'd.idproforma')
            ->leftJoin('servicios as s', 'd.idservicio', '=', 's.idservicio')
            ->leftJoin('ordenesTrabajo as ot', 'p.idproforma', '=', 'ot.idproforma')
            ->leftJoin('users as u', 'ot.idusuario_aprueba', '=', 'u.id')
            ->select(
                'p.idproforma',
                'p.num_proforma',
                'p.num_ot',
                'p.fechaEmision',
                'p.solicitante',
                'd.iddetalle',
                'd.descripcion as detalle_descripcion',
                'd.cantidad',
                'd.precio',
                DB::raw('(COALESCE(d.cantidad, 0) * COALESCE(d.precio, 0)) as precio_total'),
                'd.urgente',
                's.nombre as servicio_nombre',
                'ot.fecha_inicio',
                'ot.fecha_fin',
                'u.nombre as autorizado_por'
            )
            ->where('p.num_ot', '<>', '-')
            ->orderByDesc('p.idproforma')
            ->get();

        if ($proformas->isEmpty()) {
            return response()->json(['mensaje' => 'No se encontraron proformas para los IDs proporcionados.']);
        }

        // 🧠 Agrupar, sumar y obtener fechas
        $proformasAgrupadas = $proformas->groupBy('idproforma');
        $totalGeneral = $proformas->sum(fn($item) => floatval($item->cantidad) * floatval($item->precio));
        $desde = $proformas->min('fechaEmision');
        $hasta = $proformas->max('fechaEmision');

        // 📤 Exportar a Excel
        //$export = new ReporteAcondicionamientoExport($proformasAgrupadas, $desde, $hasta, $totalGeneral);
        //return Excel::download($export, "reporte-cotizaciones-{$desde}-{$hasta}.xlsx");

        // Si quieres mostrar en blade
        return view('exports.reporte_acondicionamiento', [
            'proformasAgrupadas' => $proformasAgrupadas,
            'desde' => $desde,
            'hasta' => $hasta,
            'totalGeneral' => $totalGeneral,
        ]);
    }

    public function exportarReporteAPI(Request $request)
    {
        $idcliente = $request->query('idcliente');
        if (!$idcliente) {
            return response()->json(['error' => 'Debe enviar el parámetro idcliente'], 400);
        }

        $idsede = $request->query('idsede');
        if (!$idsede) {
            return response()->json(['error' => 'Debe enviar el parámetro idsede'], 400);
        }

        // 🧾 Obtener el array desde el cuerpo del request
        $idList = $request->input('idproformas', []);
        // Obtener el nombre del cliente como string, valor por defecto ''
        $nomCliente = $request->input('nomCliente', '');
        // Obtener el nombre de la sede como string, valor por defecto ''
        $nomSede = $request->input('nomSede', '');

        // ✅ Validación básica
        if (!is_array($idList) || count($idList) === 0) {
            return response()->json(['error' => 'Debe enviar un arreglo de ID de proformas.'], 400);
        }

        // 🔍 Consulta filtrando por los IDs proporcionados
        $proformas = DB::table('proformas as p')
            ->leftJoin('detalleProforma as d', 'p.idproforma', '=', 'd.idproforma')
            ->leftJoin('servicios as s', 'd.idservicio', '=', 's.idservicio')
            ->leftJoin('ordenesTrabajo as ot', 'p.idproforma', '=', 'ot.idproforma')
            ->leftJoin('users as u', 'ot.idusuario_aprueba', '=', 'u.id')
            ->select(
                'p.idproforma',
                'p.num_proforma',
                'p.num_ot',
                'p.fechaEmision',
                'p.solicitante',
                'd.iddetalle',
                'd.descripcion as detalle_descripcion',
                'd.cantidad',
                'd.precio',
                DB::raw('(COALESCE(d.cantidad, 0) * COALESCE(d.precio, 0)) as precio_total'),
                'd.urgente',
                's.nombre as servicio_nombre',
                'ot.fecha_inicio',
                'ot.fecha_fin',
                'u.nombre as autorizado_por'
            )
            ->where('p.idsede', $idsede)
            ->where('p.idcliente', $idcliente)
            ->where('p.num_ot', '<>', '-')
            ->whereIn('p.idproforma', $idList)
            ->orderByDesc('p.idproforma')
            ->get();

        if ($proformas->isEmpty()) {
            return response()->json(['mensaje' => 'No se encontraron proformas para los IDs proporcionados.']);
        }

        // 🧠 Agrupar, sumar y obtener fechas
        $proformasAgrupadas = $proformas->groupBy('idproforma');
        $totalGeneral = $proformas->sum(fn($item) => floatval($item->cantidad) * floatval($item->precio));
        $desde = $proformas->min('fechaEmision');
        $hasta = $proformas->max('fechaEmision');

        // 📤 Exportar a Excel
        $export = new ReporteAcondicionamientoExport(
            $proformasAgrupadas,
            $desde,
            $hasta,
            $totalGeneral,
            $nomCliente,
            $nomSede
        );
        return Excel::download($export, "reporte-cotizaciones-{$desde}-{$hasta}.xlsx");

        // Si quieres mostrar en blade
        /*return view('exports.reporte_acondicionamiento', [
            'proformasAgrupadas' => $proformasAgrupadas,
            'desde' => $desde,
            'hasta' => $hasta,
            'totalGeneral' => $totalGeneral,
        ]);*/
    }

    public function exportarReporteAPI_Dos(Request $request)
    {
        $idcliente = $request->query('idcliente');
        if (!$idcliente) {
            return response()->json(['error' => 'Debe enviar el parámetro idcliente'], 400);
        }
        $idsede = $request->query('idsede');
        if (!$idsede) {
            return response()->json(['error' => 'Debe enviar el parámetro idsede'], 400);
        }

        $proformas = DB::table('proformas as p')
            ->leftJoin('detalleProforma as d', 'p.idproforma', '=', 'd.idproforma')
            ->leftJoin('servicios as s', 'd.idservicio', '=', 's.idservicio')
            ->leftJoin('ordenesTrabajo as ot', 'p.idproforma', '=', 'ot.idproforma')
            ->leftJoin('users as u', 'ot.idusuario_aprueba', '=', 'u.id')
            ->leftJoin('tipoFacturacion as tf', 'p.idTipoFacturacion', '=', 'tf.idTipoFacturacion')
            ->select(
                'p.idproforma',
                'p.num_proforma',
                'p.num_ot',
                'p.fechaEmision',
                'p.solicitante',
                'd.iddetalle',
                'd.descripcion as detalle_descripcion',
                'd.cantidad',
                'd.precio',
                DB::raw('(d.cantidad * d.precio) as precio_total'),
                'd.urgente',
                's.nombre as servicio_nombre',
                'ot.fecha_inicio',
                'ot.fecha_fin',
                'ot.estado',
                'u.nombre as autorizado_por',
                'tf.nombre as tipoFacturacion'
            )
            ->where('p.idsede', $idsede)
            ->where('p.idcliente', $idcliente)
            ->where('p.num_ot', '<>', '-')
            ->orderByDesc('p.idproforma')
            ->get();

        // Agrupar por idproforma
        $proformasAgrupadas = $proformas->groupBy('idproforma');

        // Total general
        $totalGeneral = $proformas->sum('precio_total');

        // Respuesta
        return response()->json([
            'totalGeneral' => $totalGeneral,
            'proformasAgrupadas' => $proformasAgrupadas,
        ]);
    }

    
    public function verReporteAPI(Request $request)
    {
        $idcliente = $request->query('idcliente');
        if (!$idcliente) {
            return response()->json(['error' => 'Debe enviar el parámetro idcliente'], 400);
        }

        $idsede = $request->query('idsede');
        if (!$idsede) {
            return response()->json(['error' => 'Debe enviar el parámetro idsede'], 400);
        }

        // 🧾 Obtener el array desde el cuerpo del request
        $idList = $request->input('idproformas', []);
        // Obtener el nombre del cliente como string, valor por defecto ''
        $nomCliente = $request->input('nomCliente', '');
        // Obtener el nombre de la sede como string, valor por defecto ''
        $nomSede = $request->input('nomSede', '');

        // ✅ Validación básica
        if (!is_array($idList) || count($idList) === 0) {
            return response()->json(['error' => 'Debe enviar un arreglo de ID de proformas.'], 400);
        }

        // 🔍 Consulta filtrando por los IDs proporcionados
        $proformas = DB::table('proformas as p')
            ->leftJoin('detalleProforma as d', 'p.idproforma', '=', 'd.idproforma')
            ->leftJoin('servicios as s', 'd.idservicio', '=', 's.idservicio')
            ->leftJoin('ordenesTrabajo as ot', 'p.idproforma', '=', 'ot.idproforma')
            ->leftJoin('users as u', 'ot.idusuario_aprueba', '=', 'u.id')
            ->select(
                'p.idproforma',
                'p.num_proforma',
                'p.num_ot',
                'p.fechaEmision',
                'p.solicitante',
                'd.iddetalle',
                'd.descripcion as detalle_descripcion',
                'd.cantidad',
                'd.precio',
                DB::raw('(COALESCE(d.cantidad, 0) * COALESCE(d.precio, 0)) as precio_total'),
                'd.urgente',
                's.nombre as servicio_nombre',
                'ot.fecha_inicio',
                'ot.fecha_fin',
                'u.nombre as autorizado_por'
            )
            ->where('p.idsede', $idsede)
            ->where('p.idcliente', $idcliente)
            ->where('p.num_ot', '<>', '-')
            ->whereIn('p.idproforma', $idList)
            ->orderByDesc('p.idproforma')
            ->get();

        if ($proformas->isEmpty()) {
            return response()->json(['mensaje' => 'No se encontraron proformas para los IDs proporcionados.']);
        }

        // 🧠 Agrupar, sumar y obtener fechas
        $proformasAgrupadas = $proformas->groupBy('idproforma');
        $totalGeneral = $proformas->sum(fn($item) => floatval($item->cantidad) * floatval($item->precio));
        $desde = $proformas->min('fechaEmision');
        $hasta = $proformas->max('fechaEmision');

        $export = new ReporteAcondicionamientoExport(
            $proformasAgrupadas,
            $desde,
            $hasta,
            $totalGeneral,
            $nomCliente,
            $nomSede
        );

        return view('exports.reporte_acondicionamiento', [
            'proformasAgrupadas' => $proformasAgrupadas,
            'desde' => $desde,
            'hasta' => $hasta,
            'totalGeneral' => $totalGeneral,
        ]);
    }
}
