<?php

namespace App\Http\Controllers;

use App\Models\VentaProducto;
use App\Models\Producto;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Phpml\Regression\LeastSquares;
use Phpml\Preprocessing\Normalizer;

class PrediccionDemandaController extends Controller
{
    public function index(Request $request)
    {
        // Obtener datos para los filtros
        $sucursales = Sucursal::all();
        $productos = Producto::all();

        // Valores por defecto
        $sucursalId = $request->sucursal_id ?? ($sucursales->first()->id ?? null);
        $dias = $request->dias ?? 30; // Predecir para los próximos 30 días

        if (!$sucursalId) {
            return view('predicciones.index', compact('sucursales', 'productos'))
                ->with('error', 'No hay sucursales disponibles para realizar predicciones.');
        }

        $sucursal = Sucursal::find($sucursalId);

        // Obtener datos históricos de ventas
        $ventasHistoricas = $this->obtenerDatosHistoricos($sucursalId);

        // Preparar datos para la predicción
        $predicciones = $this->generarPredicciones($ventasHistoricas, $dias);

        // Obtener recomendaciones de personal
        $recomendacionesPersonal = $this->recomendarPersonal($predicciones, $sucursalId);

        // Calcular potencial reducción de desperdicio
        $reduccionDesperdicio = $this->calcularReduccionDesperdicio($predicciones);

        // Detectar productos clave en riesgo de escasez
        $productosEnRiesgo = $this->detectarProductosEnRiesgo($predicciones);

        return view('predicciones.index', compact(
            'sucursales',
            'productos',
            'sucursal',
            'ventasHistoricas',
            'predicciones',
            'recomendacionesPersonal',
            'reduccionDesperdicio',
            'productosEnRiesgo',
            'dias'
        ));
    }

    private function obtenerDatosHistoricos($sucursalId)
    {
        // Obtener datos de ventas de los últimos 90 días
        $fechaInicio = Carbon::now()->subDays(90);

        // Agrupar por día y producto
        return VentaProducto::select(
            'productos.id as producto_id',
            'productos.nombre as producto_nombre',
            'productos.categoria as categoria',
            DB::raw('DATE(ventas_productos.fecha_venta) as fecha'),
            DB::raw('DAYOFWEEK(ventas_productos.fecha_venta) as dia_semana'),
            DB::raw('SUM(ventas_productos.cantidad) as unidades_vendidas'),
            DB::raw('SUM(ventas_productos.total) as ingresos')
        )
            ->join('productos', 'ventas_productos.producto_id', '=', 'productos.id')
            ->where('ventas_productos.sucursal_id', $sucursalId)
            ->where('ventas_productos.fecha_venta', '>=', $fechaInicio)
            ->groupBy('productos.id', 'productos.nombre', 'productos.categoria', 'fecha', 'dia_semana')
            ->orderBy('fecha')
            ->get()
            ->groupBy('producto_id');
    }

    private function generarPredicciones($ventasHistoricas, $diasAFuturo)
    {
        $predicciones = [];
        $hoy = Carbon::today();

        foreach ($ventasHistoricas as $productoId => $ventas) {
            // Preparar datos para el algoritmo
            $samples = [];
            $targets = [];

            foreach ($ventas as $venta) {
                $fecha = Carbon::parse($venta->fecha);
                $diaSemana = $venta->dia_semana;

                // Características: [día de la semana (1-7), días desde el inicio]
                $samples[] = [$diaSemana, $fecha->diffInDays($hoy)];
                $targets[] = $venta->unidades_vendidas;
            }

            // Si no hay suficientes datos, usar promedio simple
            if (count($samples) < 5) {
                $promedio = collect($targets)->average();

                for ($i = 1; $i <= $diasAFuturo; $i++) {
                    $fechaPrediccion = $hoy->copy()->addDays($i);
                    $predicciones[$productoId][] = [
                        'fecha' => $fechaPrediccion->format('Y-m-d'),
                        'dia_semana' => $fechaPrediccion->dayOfWeek,
                        'demanda_predicha' => round($promedio),
                        'confianza' => 'Baja'
                    ];
                }
                continue;
            }

            try {
                // Entrenar modelo directamente con los datos
                $regression = new LeastSquares();
                $regression->train($samples, $targets);

                // Generar predicciones para los próximos días
                for ($i = 1; $i <= $diasAFuturo; $i++) {
                    $fechaPrediccion = $hoy->copy()->addDays($i);
                    $diaSemana = $fechaPrediccion->dayOfWeek;

                    // Predecir demanda
                    $demandaPredicha = $regression->predict([$diaSemana, $i]);

                    // Asegurar que la predicción sea un número positivo
                    $demandaPredicha = max(0, round($demandaPredicha));

                    $predicciones[$productoId][] = [
                        'fecha' => $fechaPrediccion->format('Y-m-d'),
                        'dia_semana' => $diaSemana,
                        'demanda_predicha' => $demandaPredicha,
                        'confianza' => 'Media'
                    ];
                }
            } catch (\Exception $e) {
                // Si hay error en el algoritmo, usar promedio
                $promedio = collect($targets)->average();

                for ($i = 1; $i <= $diasAFuturo; $i++) {
                    $fechaPrediccion = $hoy->copy()->addDays($i);
                    $predicciones[$productoId][] = [
                        'fecha' => $fechaPrediccion->format('Y-m-d'),
                        'dia_semana' => $fechaPrediccion->dayOfWeek,
                        'demanda_predicha' => round($promedio),
                        'confianza' => 'Baja (Error)'
                    ];
                }
            }
        }

        return $predicciones;
    }

    private function recomendarPersonal($predicciones, $sucursalId)
    {
        // Agrupar predicciones por día
        $demandaPorDia = [];
        $hoy = Carbon::today();

        foreach ($predicciones as $productoId => $prediccionesProducto) {
            foreach ($prediccionesProducto as $prediccion) {
                $fecha = $prediccion['fecha'];

                if (!isset($demandaPorDia[$fecha])) {
                    $demandaPorDia[$fecha] = 0;
                }

                $demandaPorDia[$fecha] += $prediccion['demanda_predicha'];
            }
        }

        // Calcular personal necesario basado en la demanda
        $recomendaciones = [];
        $empleadosPorDefecto = 3; // Base mínima de empleados
        $ventasPorEmpleado = 50; // Unidades que puede atender un empleado

        foreach ($demandaPorDia as $fecha => $demandaTotal) {
            $empleadosNecesarios = max($empleadosPorDefecto, ceil($demandaTotal / $ventasPorEmpleado));

            $diaSemana = Carbon::parse($fecha)->format('l');
            $esFinDeSemana = in_array($diaSemana, ['Saturday', 'Sunday']);

            // Ajuste para fines de semana (mayor demanda)
            if ($esFinDeSemana) {
                $empleadosNecesarios = ceil($empleadosNecesarios * 1.2);
            }

            $recomendaciones[$fecha] = [
                'fecha' => $fecha,
                'dia_semana' => $diaSemana,
                'demanda_total' => $demandaTotal,
                'empleados_recomendados' => $empleadosNecesarios,
                'es_fin_de_semana' => $esFinDeSemana
            ];
        }

        return $recomendaciones;
    }

    private function calcularReduccionDesperdicio($predicciones)
    {
        // Simulación de reducción de desperdicio
        $desperdicioPorDefecto = 15; // Porcentaje estimado sin predicciones
        $desperdicioConPredicciones = 5; // Porcentaje estimado con predicciones

        $totalUnidades = 0;
        $costoPromedio = 60; // Costo promedio por unidad en pesos

        foreach ($predicciones as $productoId => $prediccionesProducto) {
            foreach ($prediccionesProducto as $prediccion) {
                $totalUnidades += $prediccion['demanda_predicha'];
            }
        }

        return [
            'unidades_totales' => $totalUnidades,
            'desperdicio_actual_porcentaje' => $desperdicioPorDefecto,
            'desperdicio_actual_unidades' => round($totalUnidades * ($desperdicioPorDefecto / 100)),
            'desperdicio_actual_costo' => round($totalUnidades * ($desperdicioPorDefecto / 100) * $costoPromedio),
            'desperdicio_proyectado_porcentaje' => $desperdicioConPredicciones,
            'desperdicio_proyectado_unidades' => round($totalUnidades * ($desperdicioConPredicciones / 100)),
            'desperdicio_proyectado_costo' => round($totalUnidades * ($desperdicioConPredicciones / 100) * $costoPromedio),
            'ahorro_unidades' => round($totalUnidades * (($desperdicioPorDefecto - $desperdicioConPredicciones) / 100)),
            'ahorro_costo' => round($totalUnidades * (($desperdicioPorDefecto - $desperdicioConPredicciones) / 100) * $costoPromedio),
        ];
    }

    private function detectarProductosEnRiesgo($predicciones)
    {
        $productosEnRiesgo = [];
        $inventarioActual = []; // En un sistema real, se obtendría del inventario

        // Simular inventario para demostración
        foreach ($predicciones as $productoId => $prediccionesProducto) {
            $producto = Producto::find($productoId);
            $inventarioActual[$productoId] = rand(10, 100); // Inventario simulado

            $demandaTotal = 0;
            foreach ($prediccionesProducto as $prediccion) {
                $demandaTotal += $prediccion['demanda_predicha'];
            }

            $porcentajeCobertura = ($inventarioActual[$productoId] / max(1, $demandaTotal)) * 100;

            if ($porcentajeCobertura < 70) { // Umbral de alerta
                $productosEnRiesgo[] = [
                    'producto_id' => $productoId,
                    'producto_nombre' => $producto->nombre,
                    'categoria' => $producto->categoria,
                    'inventario_actual' => $inventarioActual[$productoId],
                    'demanda_proyectada' => $demandaTotal,
                    'porcentaje_cobertura' => round($porcentajeCobertura, 1),
                    'nivel_riesgo' => $porcentajeCobertura < 30 ? 'Alto' : 'Medio'
                ];
            }
        }

        return $productosEnRiesgo;
    }
}