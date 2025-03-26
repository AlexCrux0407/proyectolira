<?php

namespace Database\Seeders;

use App\Models\Sucursal;
use App\Models\Producto;
use App\Models\VentaProducto;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class VentasProductosSeeder extends Seeder
{
    public function run()
    {
        // Obtener todas las sucursales y productos
        $sucursales = Sucursal::all();
        $productos = Producto::all();
        
        if ($sucursales->isEmpty() || $productos->isEmpty()) {
            $this->command->info('No hay sucursales o productos para generar datos de ventas.');
            return;
        }
        
        // Generar datos para los últimos 3 meses
        $startDate = Carbon::now()->subMonths(3)->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        
        $currentDate = clone $startDate;
        
        // Para cada día en el rango
        while ($currentDate <= $endDate) {
            // Para cada sucursal
            foreach ($sucursales as $sucursal) {
                // Determinar cuántos productos diferentes se vendieron ese día (entre 3 y 10)
                $numProductos = rand(3, min(10, count($productos)));
                $productosVendidos = $productos->random($numProductos);
                
                // Para cada producto vendido
                foreach ($productosVendidos as $producto) {
                    // Determinar la cantidad vendida (entre 1 y 30)
                    $cantidad = rand(1, 30);
                    
                    // Crear la venta
                    VentaProducto::create([
                        'sucursal_id' => $sucursal->id,
                        'producto_id' => $producto->id,
                        'cantidad' => $cantidad,
                        'precio_unitario' => $producto->precio,
                        'total' => $producto->precio * $cantidad,
                        'fecha_venta' => clone $currentDate,
                    ]);
                }
            }
            
            // Avanzar al siguiente día
            $currentDate->addDay();
        }
        
        $this->command->info('Datos de ventas generados correctamente.');
    }
}