@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-0">
                    <i class="bi bi-graph-up-arrow text-primary me-2"></i>Predicción Inteligente de Demanda
                </h2>
                <p class="text-muted">Optimice su inventario, personal y reducción de desperdicios con análisis predictivo
                </p>
            </div>
            <div>
                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#filtroModal">
                    <i class="bi bi-sliders me-1"></i> Configurar Predicción
                </button>
            </div>
        </div>

        @if(isset($error))
            <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $error }}
            </div>
        @else
            <!-- Información general -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 p-3 rounded me-3">
                                    <i class="bi bi-building text-primary fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 text-muted">Sucursal</h6>
                                    <h5 class="mb-0">{{ $sucursal->nombre }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-success bg-opacity-10 p-3 rounded me-3">
                                    <i class="bi bi-calendar-range text-success fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 text-muted">Período de Predicción</h6>
                                    <h5 class="mb-0">Próximos {{ $dias }} días</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-info bg-opacity-10 p-3 rounded me-3">
                                    <i class="bi bi-clipboard-data text-info fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 text-muted">Productos Analizados</h6>
                                    <h5 class="mb-0">{{ count($predicciones) }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Columna de predicciones de demanda -->
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0"><i class="bi bi-graph-up text-primary me-2"></i>Predicción de Demanda por Producto
                            </h5>
                        </div>
                        <div class="card-body">
                            <div style="height: 350px;">
                                <canvas id="demandaChart"></canvas>
                            </div>

                            <hr class="my-4">

                            <h6 class="mb-3">Detalle por Día</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Día</th>
                                            <th>Demanda Total</th>
                                            <th>Productos Principales</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $demandaPorDia = [];
                                            foreach ($predicciones as $productoId => $prediccionesProducto) {
                                                $producto = App\Models\Producto::find($productoId);
                                                foreach ($prediccionesProducto as $prediccion) {
                                                    $fecha = $prediccion['fecha'];
                                                    if (!isset($demandaPorDia[$fecha])) {
                                                        $demandaPorDia[$fecha] = [
                                                            'total' => 0,
                                                            'productos' => []
                                                        ];
                                                    }
                                                    $demandaPorDia[$fecha]['total'] += $prediccion['demanda_predicha'];
                                                    $demandaPorDia[$fecha]['productos'][$productoId] = [
                                                        'nombre' => $producto->nombre,
                                                        'cantidad' => $prediccion['demanda_predicha']
                                                    ];
                                                    $demandaPorDia[$fecha]['dia_semana'] = $prediccion['dia_semana'];
                                                }
                                            }
                                            // Ordenar por fecha
                                            ksort($demandaPorDia);
                                        @endphp

                                        @foreach($demandaPorDia as $fecha => $datos)
                                                                    <tr>
                                                                        <td>{{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}</td>
                                                                        <td>{{ \Carbon\Carbon::parse($fecha)->format('l') }}</td>
                                                                        <td>{{ $datos['total'] }} unidades</td>
                                                                        <td>
                                                                            @php
                                                                                // Obtener los 3 productos más demandados para este día
                                                                                $productosOrdenados = collect($datos['productos'])->sortByDesc('cantidad')->take(3);
                                                                            @endphp
                                                                            @foreach($productosOrdenados as $producto)
                                                                                <span class="badge bg-light text-dark border mb-1">
                                                                                    {{ $producto['nombre'] }}: {{ $producto['cantidad'] }}
                                                                                </span>
                                                                            @endforeach
                                                                        </td>
                                                                    </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Columna de insights y recomendaciones -->
                <div class="col-md-4">
                    <!-- Recomendación de Personal -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0"><i class="bi bi-people text-success me-2"></i>Recomendación de Personal</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Día</th>
                                            <th>Empleados</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recomendacionesPersonal as $fecha => $recomendacion)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($fecha)->format('d/m') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($fecha)->format('D') }}</td>
                                                <td>
                                                    <span
                                                        class="badge {{ $recomendacion['es_fin_de_semana'] ? 'bg-warning' : 'bg-info' }} rounded-pill">
                                                        {{ $recomendacion['empleados_recomendados'] }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="alert alert-info mt-3 mb-0">
                                <i class="bi bi-info-circle-fill me-2"></i>
                                Las recomendaciones se basan en la carga de trabajo proyectada y consideran demanda, día de la
                                semana y capacidad de atención por empleado.
                            </div>
                        </div>
                    </div>

                    <!-- Reducción de Desperdicios -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0"><i class="bi bi-trash text-danger me-2"></i>Reducción de Desperdicios</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Sin predicción ({{ $reduccionDesperdicio['desperdicio_actual_porcentaje'] }}%)</span>
                                    <span>{{ $reduccionDesperdicio['desperdicio_actual_unidades'] }} unidades</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-danger" role="progressbar"
                                        style="width: {{ $reduccionDesperdicio['desperdicio_actual_porcentaje'] }}%"></div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Con predicción
                                        ({{ $reduccionDesperdicio['desperdicio_proyectado_porcentaje'] }}%)</span>
                                    <span>{{ $reduccionDesperdicio['desperdicio_proyectado_unidades'] }} unidades</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-success" role="progressbar"
                                        style="width: {{ $reduccionDesperdicio['desperdicio_proyectado_porcentaje'] }}%"></div>
                                </div>
                            </div>

                            <div class="alert alert-success mt-3 mb-0">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-check-circle-fill fs-4 me-2"></i>
                                    <div>
                                        <p class="mb-0"><strong>Ahorro potencial: {{ $reduccionDesperdicio['ahorro_unidades'] }}
                                                unidades</strong></p>
                                        <p class="mb-0">Equivalente a
                                            ${{ number_format($reduccionDesperdicio['ahorro_costo'], 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Productos en Riesgo de Escasez -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0"><i class="bi bi-exclamation-triangle text-warning me-2"></i>Productos en Riesgo
                            </h5>
                        </div>
                        <div class="card-body">
                            @if(count($productosEnRiesgo) > 0)
                                <div class="list-group list-group-flush">
                                    @foreach($productosEnRiesgo as $producto)
                                        <div class="list-group-item border-0 border-bottom py-3 px-0">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h6 class="mb-1">{{ $producto['producto_nombre'] }}</h6>
                                                    <small class="text-muted">{{ $producto['categoria'] }}</small>
                                                </div>
                                                <span
                                                    class="badge bg-{{ $producto['nivel_riesgo'] == 'Alto' ? 'danger' : 'warning' }} rounded-pill align-self-center">
                                                    {{ $producto['nivel_riesgo'] }}
                                                </span>
                                            </div>
                                            <div class="mt-2">
                                                <div class="d-flex justify-content-between small mb-1">
                                                    <span>Cobertura: {{ $producto['porcentaje_cobertura'] }}%</span>
                                                    <span>Inventario: {{ $producto['inventario_actual'] }} /
                                                        {{ $producto['demanda_proyectada'] }}</span>
                                                </div>
                                                <div class="progress" style="height: 5px;">
                                                    <div class="progress-bar {{ $producto['nivel_riesgo'] == 'Alto' ? 'bg-danger' : 'bg-warning' }}"
                                                        role="progressbar" style="width: {{ $producto['porcentaje_cobertura'] }}%">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="bi bi-check-circle text-success fs-1 mb-3"></i>
                                    <p class="mb-0">No hay productos en riesgo de escasez en este período.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Modal de Filtros -->
    <div class="modal fade" id="filtroModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-sliders me-2"></i>Configurar Predicción
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('predicciones.index') }}" method="GET">
                    <div class="modal-body py-4">
                        <div class="mb-3">
                            <label for="sucursal_id" class="form-label">Sucursal</label>
                            <select class="form-select" id="sucursal_id" name="sucursal_id" required>
                                @foreach($sucursales as $sucursal)
                                    <option value="{{ $sucursal->id }}" {{ isset($sucursalId) && $sucursalId == $sucursal->id ? 'selected' : '' }}>
                                        {{ $sucursal->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="dias" class="form-label">Días a predecir</label>
                            <select class="form-select" id="dias" name="dias">
                                <option value="7" {{ $dias == 7 ? 'selected' : '' }}>7 días</option>
                                <option value="14" {{ $dias == 14 ? 'selected' : '' }}>14 días</option>
                                <option value="30" {{ $dias == 30 ? 'selected' : '' }}>30 días</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-search me-1"></i>Generar Predicción
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Preparar datos para el gráfico
            const labels = [];
            const datasets = [];

            @php
                $fechas = [];
                $productosPrincipales = [];

                // Recopilar todas las fechas únicas
                foreach ($predicciones as $productoId => $prediccionesProducto) {
                    foreach ($prediccionesProducto as $prediccion) {
                        if (!in_array($prediccion['fecha'], $fechas)) {
                            $fechas[] = $prediccion['fecha'];
                        }
                    }
                }
                sort($fechas);

                // Identificar los 5 productos principales
                $totalPorProducto = [];
                foreach ($predicciones as $productoId => $prediccionesProducto) {
                    $totalPorProducto[$productoId] = 0;
                    foreach ($prediccionesProducto as $prediccion) {
                        $totalPorProducto[$productoId] += $prediccion['demanda_predicha'];
                    }
                }
                arsort($totalPorProducto);
                $productosPrincipales = array_slice($totalPorProducto, 0, 5, true);
            @endphp

            // Fechas para el eje X
            const fechas = @json($fechas);

            // Formatear las fechas para mostrar
            const labelsFormateados = fechas.map(fecha => {
                const date = new Date(fecha);
                return date.toLocaleDateString('es-ES', { day: 'numeric', month: 'short' });
            });

            // Crear datasets para los productos principales
            const colores = [
                { bg: 'rgba(54, 162, 235, 0.2)', border: 'rgba(54, 162, 235, 1)' },
                { bg: 'rgba(255, 99, 132, 0.2)', border: 'rgba(255, 99, 132, 1)' },
                { bg: 'rgba(255, 206, 86, 0.2)', border: 'rgba(255, 206, 86, 1)' },
                { bg: 'rgba(75, 192, 192, 0.2)', border: 'rgba(75, 192, 192, 1)' },
                { bg: 'rgba(153, 102, 255, 0.2)', border: 'rgba(153, 102, 255, 1)' }
            ];

            let index = 0;
            @foreach($productosPrincipales as $productoId => $total)
                const producto{{ $productoId }} = @json(App\Models\Producto::find($productoId));
                const dataProducto{{ $productoId }} = [];

                // Llenar datos para todas las fechas
                fechas.forEach(fecha => {
                    let valor = 0;

                    // Buscar si hay predicción para esta fecha y producto
                    @foreach($predicciones[$productoId] ?? [] as $prediccion)
                        if ('{{ $prediccion['fecha'] }}' === fecha) {
                            valor = {{ $prediccion['demanda_predicha'] }};
                        }
                    @endforeach

                    dataProducto{{ $productoId }}.push(valor);
                });

                datasets.push({
                    label: producto{{ $productoId }}.nombre,
                    data: dataProducto{{ $productoId }},
                    backgroundColor: colores[index % colores.length].bg,
                    borderColor: colores[index % colores.length].border,
                    borderWidth: 1
                });

                index++;
            @endforeach

            // Crear el gráfico
            const ctx = document.getElementById('demandaChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labelsFormateados,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Unidades Proyectadas'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Fecha'
                            }
                        }
                    },
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return context.dataset.label + ': ' + context.parsed.y + ' unidades';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection