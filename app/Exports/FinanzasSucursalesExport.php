<?php

namespace App\Exports;

use App\Models\Sucursal;
use App\Models\FinanzaSucursal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class FinanzasSucursalesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
{
    protected $fechaInicio;
    protected $fechaFin;

    public function __construct($fechaInicio = null, $fechaFin = null)
    {
        $this->fechaInicio = $fechaInicio ?: now()->subMonths(3)->startOfMonth();
        $this->fechaFin = $fechaFin ?: now();
    }

    public function collection()
    {
        return FinanzaSucursal::with('sucursal')
            ->whereBetween('fecha', [$this->fechaInicio, $this->fechaFin])
            ->orderBy('sucursal_id')
            ->orderBy('fecha')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID Sucursal',
            'Nombre Sucursal',
            'Fecha',
            'Ingresos (MXN)',
            'Gastos (MXN)',
            'Ganancias (MXN)',
            'Margen (%)',
            'Notas'
        ];
    }

    public function map($finanza): array
    {
        $margen = $finanza->ingresos > 0 ? 
            round(($finanza->ganancias / $finanza->ingresos) * 100, 2) : 
            0;

        return [
            $finanza->sucursal_id,
            $finanza->sucursal->nombre,
            $finanza->fecha->format('d/m/Y'),
            number_format($finanza->ingresos, 2),
            number_format($finanza->gastos, 2),
            number_format($finanza->ganancias, 2),
            $margen . '%',
            $finanza->notas,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function title(): string
    {
        return 'Reporte Financiero';
    }
}