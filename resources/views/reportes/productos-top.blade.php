@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">
                <i class="bi bi-graph-up-arrow text-primary me-2"></i>Productos Más Vendidos
            </h2>
            <p class="text-muted">Análisis de los productos con mayor volumen de ventas por sucursal</p>
        </div>
        <div>
            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#filtroFechasModal">
                <i class="bi bi-calendar3 me-1"></i> Filtrar por Fechas
            </button>
        </div>
    </div>

    <!-- Filtro de fechas activo -->
    <div class="alert alert-info d-flex align-items-center mb-4">
        <i class="bi bi-info-circle-fill me-2"></i>
        <div>
            Mostrando datos desde <strong>{{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') }}</strong> hasta <strong>{{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') }}</strong>
        </div>
    </div>

    <!-- TOP 10 General -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0">
                <i class="bi bi-trophy me-2"></i>Top 10 Productos Más Vendidos (General)
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div style="height: 300px;">
                        <canvas id="chartTopGeneral"></canvas>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Ingresos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($totalesGenerales as $index => $producto)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $producto->nombre }}</td>
                                    <td>{{ $producto->total_vendido }}</td>
                                    <td>${{ number_format($producto->total_ingresos, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Por sucursal -->
    <div class="row">
        @foreach($productosTopPorSucursal as $sucursalId => $data)
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-light py-3">
                        <h5 class="mb-0">
                            <i class="bi bi-shop me-2"></i>{{ $data['sucursal']->nombre }}
                        </h5>
                    </div>
                    <div class="card-body">
                        @if(count($data['productos']) > 0)
                            <div style="height: 220px;">
                                <canvas id="chartSucursal{{ $sucursalId }}"></canvas>
                            </div>
                            <div class="table-responsive mt-3">
                                <table class="table table-sm table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Producto</th>
                                            <th>Categoría</th>
                                            <th>Cantidad</th>
                                            <th>Ingresos</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data['productos'] as $producto)
                                        <tr>
                                            <td>{{ $producto->nombre }}</td>
                                            <td><span class="badge bg-secondary">{{ $producto->categoria }}</span></td>
                                            <td>{{ $producto->total_vendido }}</td>
                                            <td>${{ number_format($producto->total_ingresos, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-clipboard-x text-muted fs-1 mb-3"></i>
                                <p class="mb-0">No hay datos de ventas disponibles para esta sucursal en el período seleccionado.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Modal de filtro por fechas -->
<div class="modal fade" id="filtroFechasModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-calendar-range me-2"></i>Filtrar por Fechas
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('reportes.productos-top') }}" method="GET">
                <div class="modal-body py-4">
                    <div class="mb-3">
                        <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="{{ $fechaInicio }}">
                    </div>
                    <div class="mb-3">
                        <label for="fecha_fin" class="form-label">Fecha Fin</label>
                        <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="{{ $fechaFin }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-search me-1"></i>Aplicar Filtro
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
    document.addEventListener('DOMContentLoaded', function() {
        // Configuración de colores
        const backgroundColors = [
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 99, 132, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(199, 199, 199, 0.2)',
            'rgba(83, 102, 255, 0.2)',
            'rgba(40, 159, 64, 0.2)',
            'rgba(210, 199, 199, 0.2)'
        ];
        
        const borderColors = [
            'rgba(54, 162, 235, 1)',
            'rgba(255, 99, 132, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(199, 199, 199, 1)',
            'rgba(83, 102, 255, 1)',
            'rgba(40, 159, 64, 1)',
            'rgba(210, 199, 199, 1)'
        ];
        
        // Chart Top General
        const datosTopGeneral = @json($totalesGenerales);
        if (document.getElementById('chartTopGeneral')) {
            const labelsTopGeneral = datosTopGeneral.map(item => item.nombre);
            const dataTopGeneral = datosTopGeneral.map(item => item.total_vendido);
            
            new Chart(document.getElementById('chartTopGeneral'), {
                type: 'bar',
                data: {
                    labels: labelsTopGeneral,
                    datasets: [{
                        label: 'Unidades Vendidas',
                        data: dataTopGeneral,
                        backgroundColor: backgroundColors,
                        borderColor: borderColors,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `Vendidos: ${context.parsed.y} unidades`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
        
        // Charts por sucursal
        @foreach($productosTopPorSucursal as $sucursalId => $data)
            @if(count($data['productos']) > 0)
                const datosSucursal{{ $sucursalId }} = @json($data['productos']);
                if (document.getElementById('chartSucursal{{ $sucursalId }}')) {
                    const labelsSucursal{{ $sucursalId }} = datosSucursal{{ $sucursalId }}.map(item => item.nombre);
                    const dataSucursal{{ $sucursalId }} = datosSucursal{{ $sucursalId }}.map(item => item.total_vendido);
                    
                    new Chart(document.getElementById('chartSucursal{{ $sucursalId }}'), {
                        type: 'doughnut',
                        data: {
                            labels: labelsSucursal{{ $sucursalId }},
                            datasets: [{
                                label: 'Unidades Vendidas',
                                data: dataSucursal{{ $sucursalId }},
                                backgroundColor: backgroundColors,
                                borderColor: borderColors,
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'right'
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                            const percentage = Math.round((context.parsed * 100) / total);
                                            return `${context.parsed} unidades (${percentage}%)`;
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            @endif
        @endforeach
    });
</script>
@endsection