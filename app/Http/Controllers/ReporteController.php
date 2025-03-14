<?php

namespace App\Http\Controllers;

use App\Models\Empleado;  // Import correcto del modelo
use App\Models\Sucursal;
use App\Models\HistorialCambio;
use Illuminate\Http\Request;
use PDF;

class ReporteController extends Controller
{
    // En app/Http/Controllers/ReporteController.php
    public function historialCambiosSucursal($id)
    {
        $sucursal = Sucursal::findOrFail($id);

        // Obtener historial de la sucursal
        $cambiosSucursal = HistorialCambio::where('modelo_tipo', Sucursal::class)
            ->where('modelo_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Obtener ids de empleados asignados a esta sucursal
        $empleadosIds = $sucursal->empleados()->pluck('id')->toArray();

        // Obtener historial de los empleados de esta sucursal
        $cambiosEmpleados = collect([]);
        if (!empty($empleadosIds)) {
            $cambiosEmpleados = HistorialCambio::where('modelo_tipo', Empleado::class)
                ->whereIn('modelo_id', $empleadosIds)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        // Combinar ambos conjuntos de cambios y ordenar por fecha descendente
        $todosCambios = $cambiosSucursal->concat($cambiosEmpleados)->sortByDesc('created_at');

        // Para depuración - agregamos alguna información para ver qué está pasando
        \Log::info('Historial de Cambios', [
            'sucursal_id' => $id,
            'empleados_ids' => $empleadosIds,
            'cambios_sucursal_count' => $cambiosSucursal->count(),
            'cambios_empleados_count' => $cambiosEmpleados->count(),
            'todos_cambios_count' => $todosCambios->count()
        ]);

        return view('reportes.historial_cambios', compact('sucursal', 'todosCambios'));
    }
}
