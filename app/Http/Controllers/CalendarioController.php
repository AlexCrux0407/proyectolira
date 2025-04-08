<?php

namespace App\Http\Controllers;

use App\Models\VisitaProveedor;
use App\Models\Proveedor;
use App\Models\Sucursal;
use Illuminate\Http\Request;

class CalendarioController extends Controller
{
    public function index()
    {
        $visitas = VisitaProveedor::with(['proveedor', 'sucursal'])->get();
        $proveedores = Proveedor::all();
        $sucursales = Sucursal::all();
        
        // Obtener estadísticas de visitas
        $totalProgramadas = VisitaProveedor::where('estado', 'programada')->count();
        $totalCompletadas = VisitaProveedor::where('estado', 'completada')->count();
        $totalCanceladas = VisitaProveedor::where('estado', 'cancelada')->count();
        
        // Obtener visitas programadas (pendientes) ordenadas por fecha más próxima
        $proximasVisitas = VisitaProveedor::with(['proveedor', 'sucursal'])
            ->where('estado', 'programada')
            ->orderBy('fecha_visita', 'asc')
            ->orderBy('hora_inicio', 'asc')
            ->get();
        
        // Preparar los eventos para el calendario
        $eventos = [];
        
        foreach ($visitas as $visita) {
            $eventos[] = [
                'id' => $visita->id,
                'title' => $visita->proveedor->nombre_empresa . ' - ' . $visita->sucursal->nombre,
                'start' => $visita->fecha_visita->format('Y-m-d') . 
                           ($visita->hora_inicio ? 'T' . $visita->hora_inicio : ''),
                'end' => $visita->fecha_visita->format('Y-m-d') . 
                         ($visita->hora_fin ? 'T' . $visita->hora_fin : ''),
                'color' => $this->getColorByStatus($visita->estado),
                'description' => $visita->motivo,
                'estado' => $visita->estado
            ];
        }
        
        return view('calendario.index', compact(
            'eventos', 
            'proveedores', 
            'sucursales',
            'totalProgramadas',
            'totalCompletadas',
            'totalCanceladas',
            'proximasVisitas'
        ));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'sucursal_id' => 'required|exists:sucursales,id',
            'fecha_visita' => 'required|date',
            'hora_inicio' => 'nullable',
            'hora_fin' => 'nullable',
            'motivo' => 'nullable|string|max:255',
            'estado' => 'required|in:programada,completada,cancelada',
            'notas' => 'nullable|string'
        ]);
        
        VisitaProveedor::create($request->all());
        
        return redirect()->route('calendario.index')
            ->with('success', 'Visita programada exitosamente');
    }
    
    public function update(Request $request, $id)
    {
        $visita = VisitaProveedor::findOrFail($id);
        
        $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'sucursal_id' => 'required|exists:sucursales,id',
            'fecha_visita' => 'required|date',
            'hora_inicio' => 'nullable',
            'hora_fin' => 'nullable',
            'motivo' => 'nullable|string|max:255',
            'estado' => 'required|in:programada,completada,cancelada',
            'notas' => 'nullable|string'
        ]);
        
        $visita->update($request->all());
        
        return redirect()->route('calendario.index')
            ->with('success', 'Visita actualizada exitosamente');
    }
    
    public function destroy($id)
    {
        $visita = VisitaProveedor::findOrFail($id);
        $visita->delete();
        
        return redirect()->route('calendario.index')
            ->with('success', 'Visita eliminada exitosamente');
    }
    
    private function getColorByStatus($status)
    {
        switch ($status) {
            case 'programada':
                return '#3788d8'; // Azul
            case 'completada':
                return '#28a745'; // Verde
            case 'cancelada':
                return '#dc3545'; // Rojo
            default:
                return '#6c757d'; // Gris
        }
    }
}