<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use App\Models\Producto;
use App\Models\VentaProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteVentasController extends Controller
{
    public function productosTopPorSucursal(Request $request)
    {
        // Obtener todas las sucursales
        $sucursales = Sucursal::all();
        
        // Establecer fechas por defecto para el filtro (último mes)
        $fechaInicio = $request->fecha_inicio ?? now()->subMonth()->startOfMonth()->format('Y-m-d');
        $fechaFin = $request->fecha_fin ?? now()->format('Y-m-d');
        
        // Inicializar array de productos top por sucursal
        $productosTopPorSucursal = [];
        
        // Para cada sucursal, obtener sus productos más vendidos
        foreach ($sucursales as $sucursal) {
            $productosTop = VentaProducto::select(
                    'productos.id',
                    'productos.nombre',
                    'productos.categoria',
                    DB::raw('SUM(ventas_productos.cantidad) as total_vendido'),
                    DB::raw('SUM(ventas_productos.total) as total_ingresos')
                )
                ->join('productos', 'ventas_productos.producto_id', '=', 'productos.id')
                ->where('ventas_productos.sucursal_id', $sucursal->id)
                ->whereBetween('ventas_productos.fecha_venta', [$fechaInicio, $fechaFin])
                ->groupBy('productos.id', 'productos.nombre', 'productos.categoria')
                ->orderBy('total_vendido', 'desc')
                ->limit(5)
                ->get();
            
            $productosTopPorSucursal[$sucursal->id] = [
                'sucursal' => $sucursal,
                'productos' => $productosTop
            ];
        }
        
        // Obtener totales generales para comparativas
        $totalesGenerales = VentaProducto::select(
                'productos.id',
                'productos.nombre',
                'productos.categoria',
                DB::raw('SUM(ventas_productos.cantidad) as total_vendido'),
                DB::raw('SUM(ventas_productos.total) as total_ingresos')
            )
            ->join('productos', 'ventas_productos.producto_id', '=', 'productos.id')
            ->whereBetween('ventas_productos.fecha_venta', [$fechaInicio, $fechaFin])
            ->groupBy('productos.id', 'productos.nombre', 'productos.categoria')
            ->orderBy('total_vendido', 'desc')
            ->limit(10)
            ->get();
            
        return view('reportes.productos-top', compact(
            'productosTopPorSucursal', 
            'totalesGenerales',
            'sucursales',
            'fechaInicio',
            'fechaFin'
        ));
    }
}