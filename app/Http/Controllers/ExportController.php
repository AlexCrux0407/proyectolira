<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use App\Models\FinanzaSucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class IngresosExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithTitle
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
        // Usar una consulta directa con JOIN para evitar problemas con relaciones nulas
        return DB::table('finanzas_sucursales as fs')
            ->leftJoin('sucursales as s', 'fs.sucursal_id', '=', 's.id')
            ->select(
                'fs.sucursal_id as id_sucursal',
                's.nombre as nombre_sucursal',
                'fs.fecha',
                'fs.ingresos',
                'fs.notas'
            )
            ->whereBetween('fs.fecha', [$this->fechaInicio, $this->fechaFin])
            ->orderBy('fs.sucursal_id')
            ->orderBy('fs.fecha')
            ->get()
            ->map(function ($item) {
                return [
                    'id_sucursal' => $item->id_sucursal,
                    'nombre_sucursal' => $item->nombre_sucursal ?? 'Sucursal Desconocida',
                    'fecha' => date('d/m/Y', strtotime($item->fecha)),
                    'ingresos' => number_format($item->ingresos, 2),
                    'notas' => $item->notas
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID Sucursal',
            'Nombre Sucursal',
            'Fecha',
            'Ingresos (MXN)',
            'Notas'
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
        return 'Reporte de Ingresos';
    }
}

class ExportController extends Controller
{
    public function exportFinanzas(Request $request)
    {
        $fechaInicio = $request->has('fecha_inicio') ? $request->fecha_inicio : null;
        $fechaFin = $request->has('fecha_fin') ? $request->fecha_fin : null;
        
        $fileName = 'reporte_ingresos_' . now()->format('Y-m-d') . '.xlsx';
        
        return Excel::download(new IngresosExport($fechaInicio, $fechaFin), $fileName);
    }
}