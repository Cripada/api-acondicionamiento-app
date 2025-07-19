<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Illuminate\Support\Str;


class ReporteAcondicionamientoExport implements FromView, WithTitle, ShouldAutoSize,  WithEvents
{
    protected $proformasAgrupadas;
    protected $desde;
    protected $hasta;
    protected $totalGeneral;
    protected $nomCliente;
    protected $nomSede;

    public function __construct($proformasAgrupadas, $desde, $hasta, $totalGeneral, $nomCliente='', $nomSede='')
    {
        $this->proformasAgrupadas = $proformasAgrupadas;
        $this->desde  = $desde;
        $this->hasta  = $hasta;
        $this->totalGeneral = $totalGeneral;
        $this->nomCliente = trim($nomCliente) !== '' ? $nomCliente : '';
        $this->nomSede = trim($nomSede) !== '' ? $nomSede : '';
    }

    public function view(): View
    {
        return view('exports.reporte_acondicionamiento', [
            'proformasAgrupadas' => $this->proformasAgrupadas,
            'desde' => $this->desde,
            'hasta' => $this->hasta,
            'totalGeneral' => $this->totalGeneral,
            'nomCliente' => $this->nomCliente ? Str::upper($this->nomCliente) : '',
            'nomSede' => $this->nomSede ? Str::upper($this->nomSede) : '',

        ]);
    }

    // ✅ Nombre personalizado para la hoja
    public function title(): string
    {
        return 'Reporte_Acondicionamiento';
    }

    // ✅ Aquí registras el evento de estilo para aplicar en A7:J7
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->getStyle('A7:J8')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => ['horizontal' => 'center'],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);
                $sheet->getStyle('A3:D4')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => ['horizontal' => 'center'],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);
                // ✅ Autoajustar columnas de la A a la O (columnas 1 a 15)
                foreach (range('A', 'O') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                // ✅ Autoajustar fila 1
                $sheet->getRowDimension(1)->setRowHeight(-1);
                $sheet->getStyle('1')->getAlignment()->setWrapText(true);

                // ❌ Desactivar las líneas de guía (gridlines)
                $sheet->setShowGridlines(false);

                // 👁️‍🗨️ Poner el foco en la celda A4 al abrir el archivo
                $sheet->setSelectedCell('A4');

                // 🔍 Establecer zoom al 90%
                $sheet->getSheetView()->setZoomScale(90);
            },
        ];
    }
}
