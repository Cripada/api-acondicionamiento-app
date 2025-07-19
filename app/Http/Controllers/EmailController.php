<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use App\Mail\ProformaMail;
use App\Mail\DespachoSacMail;

use App\Models\Proforma;
use App\Models\Parametro;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class EmailController extends Controller
{
    /**
     * Enviar un correo con el archivo PDF adjunto.
     *
     * @OA\Post(
     *     path="/api/envio-de-correo",
     *     summary="Enviar un correo con el detalle en PDF adjunto de los despachos a realizar en bodega.",
     *     tags={"Envio de correo"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="file",
     *                     type="string",
     *                     format="binary",
     *                     description="Archivo PDF que se adjuntará al correo"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Correo enviado correctamente.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Correo enviado correctamente.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Solicitud incorrecta.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Error al enviar el correo: {error_message}")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno del servidor.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Error al enviar el correo: {error_message}")
     *         )
     *     )
     * )
     */
    public function enviarCorreo(Request $request)
    {
        // Validar la solicitud para asegurarnos de que se envíe un archivo PDF
        $request->validate([
            'file' => 'required|file|mimes:pdf',
        ]);

        // Obtener el archivo
        $file = $request->file('file');

        // Crear el directorio 'private' si no existe
        if (!Storage::exists('private')) {
            Storage::makeDirectory('private');
        }

        // Definir el nombre personalizado del archivo
        $fileName = 'planificacion-despachos.pdf';
        $filePath = 'private/' . $fileName;

        // Guardar el archivo con el nombre personalizado
        Storage::put($filePath, file_get_contents($file));

        try {
            // Enviar el correo con el archivo adjunto
            Mail::to('ricardo.batallas@cripada.com')->send(new DespachoSacMail($filePath));

            // Eliminar el archivo después de enviarlo
            Storage::delete($filePath);

            return response()->json(['message' => 'Correo enviado correctamente.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al enviar el correo: ' . $e->getMessage()], 500);
        }
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
     *     path="/api/proforma/{id}/enviar-pdf",
     *     summary="Generar y enviar la proforma en PDF por correo electrónico",
     *     description="Genera un PDF de la proforma especificada y lo envía al correo configurado como archivo adjunto.",
     *     operationId="generarProformaYEnviarPdf",
     *     tags={"Proformas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la proforma a generar",
     *         required=true,
     *         @OA\Schema(type="integer", example=12)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Correo enviado con éxito.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Correo enviado con éxito.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Proforma no encontrada.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Proforma no encontrada.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error al enviar correo.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Error al enviar correo: ...")
     *         )
     *     )
     * )
     */
    public function generarProformaYEnviarPdf(int $idProforma): Response
    {
        $proforma = Proforma::with(['cliente', 'tipoFacturacion', 'detalles.servicio'])->find($idProforma);

        if (!$proforma) {
            return response()->json(['error' => 'Proforma no encontrada.'], 404);
        }

        try {
            // Generar PDF en memoria
            $pdf = $this->prepararPdf($proforma);
            $pdfContent = $pdf->output();

            // Definir nombre y ruta del archivo temporal
            $fileName = 'Proforma N°' . $proforma->num_proforma . ' - ' . $proforma->cliente->nombre_comercial . '.pdf';
            $filePath = 'private/' . $fileName;

            // Guardar en storage privado temporalmente
            Storage::put($filePath, $pdfContent);

            // Enviar el correo
            Mail::to('ricardo.batallas@cripada.com')
                ->send(new ProformaMail($filePath, $proforma));

            // Borrar el archivo después de enviar
            Storage::delete($filePath);

            return response()->json(['message' => 'Correo enviado con éxito.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al enviar correo: ' . $e->getMessage()], 500);
        }
    }
}
