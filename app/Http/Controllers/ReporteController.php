<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use App\Models\HistorialCambio;
use Illuminate\Http\Request;
use PDF;

class ReporteController extends Controller
{
    public function historialCambiosSucursal($id)
    {
        $sucursal = Sucursal::findOrFail($id);
        
        // Obtener historial de la sucursal
        $cambiosSucursal = HistorialCambio::where('modelo_tipo', Sucursal::class)
            ->where('modelo_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Obtener historial de empleados de la sucursal
        $empleadosIds = $sucursal->empleados->pluck('id')->toArray();
        $cambiosEmpleados = HistorialCambio::where('modelo_tipo', Empleado::class)
            ->whereIn('modelo_id', $empleadosIds)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Combinar ambos historiales y ordenar por fecha
        $todosCambios = $cambiosSucursal->concat($cambiosEmpleados)->sortByDesc('created_at');
        
        return view('reportes.historial_cambios', compact('sucursal', 'todosCambios'));
    }
    
    public function generarPDFHistorial($id)
    {
        $sucursal = Sucursal::findOrFail($id);
        
        // Obtener historial de la sucursal
        $cambiosSucursal = HistorialCambio::where('modelo_tipo', Sucursal::class)
            ->where('modelo_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Obtener historial de empleados de la sucursal
        $empleadosIds = $sucursal->empleados->pluck('id')->toArray();
        $cambiosEmpleados = HistorialCambio::where('modelo_tipo', Empleado::class)
            ->whereIn('modelo_id', $empleadosIds)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Combinar ambos historiales y ordenar por fecha
        $todosCambios = $cambiosSucursal->concat($cambiosEmpleados)->sortByDesc('created_at');
        
        $pdf = PDF::loadView('reportes.historial_cambios_pdf', compact('sucursal', 'todosCambios'));
        
        return $pdf->download('historial_cambios_sucursal_' . $sucursal->id . '.pdf');
    }
}