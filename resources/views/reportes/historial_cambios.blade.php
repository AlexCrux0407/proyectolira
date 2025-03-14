@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-0">
                <i class="bi bi-clock-history text-primary me-2"></i>
                Historial de Cambios
            </h2>
            <p class="text-muted">Sucursal: {{ $sucursal->nombre }}</p>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('reportes.historial.sucursal.pdf', $sucursal->id) }}" class="btn btn-danger">
                <i class="bi bi-file-pdf me-1"></i> Generar PDF
            </a>
            <a href="{{ route('sucursales.show', $sucursal->id) }}" class="btn btn-secondary ms-2">
                <i class="bi bi-arrow-left me-1"></i> Volver a Sucursal
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-light py-3">
            <div class="row align-items-center fw-bold">
                <div class="col-md-2">Fecha</div>
                <div class="col-md-2">Tipo</div>
                <div class="col-md-2">Acción</div>
                <div class="col-md-6">Detalles</div>
            </div>
        </div>
        <div class="card-body p-0">
            @if(count($todosCambios) > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <tbody>
                            @foreach($todosCambios as $cambio)
                                <tr>
                                    <td class="py-3 px-3" style="width: 20%">
                                        <div class="d-flex align-items-center">
                                            <div class="calendar-icon me-2 bg-light text-center p-1 rounded">
                                                <div class="small text-uppercase fw-bold">{{ $cambio->created_at->format('M') }}</div>
                                                <div class="fw-bold">{{ $cambio->created_at->format('d') }}</div>
                                            </div>
                                            <div>
                                                <div>{{ $cambio->created_at->format('Y') }}</div>
                                                <div class="small text-muted">{{ $cambio->created_at->format('H:i:s') }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3" style="width: 15%">
                                        @if($cambio->modelo_tipo == 'App\Models\Sucursal')
                                            <span class="badge bg-primary">Sucursal</span>
                                        @elseif($cambio->modelo_tipo == 'App\Models\Empleado')
                                            <span class="badge bg-success">Empleado</span>
                                        @else
                                            <span class="badge bg-secondary">{{ class_basename($cambio->modelo_tipo) }}</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-3" style="width: 15%">
                                        @if($cambio->accion == 'crear')
                                            <span class="badge bg-success rounded-pill">Creación</span>
                                        @elseif($cambio->accion == 'actualizar')
                                            <span class="badge bg-warning rounded-pill text-dark">Actualización</span>
                                        @elseif($cambio->accion == 'eliminar')
                                            <span class="badge bg-danger rounded-pill">Eliminación</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-3" style="width: 50%">
                                        @if($cambio->accion == 'crear')
                                            <p class="mb-0">Se creó un nuevo registro.</p>
                                        @elseif($cambio->accion == 'actualizar')
                                            <p class="mb-0">
                                                Campo <strong class="text-primary">{{ $cambio->campo }}</strong> cambió de 
                                                "<span class="text-danger">{{ $cambio->valor_anterior ?: 'vacío' }}</span>" a 
                                                "<span class="text-success">{{ $cambio->valor_nuevo }}</span>"
                                            </p>
                                        @elseif($cambio->accion == 'eliminar')
                                            <p class="mb-0">Se eliminó un registro.</p>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-4 text-center">
                    <i class="bi bi-info-circle text-info fs-1 mb-3"></i>
                    <p class="mb-0">No hay cambios registrados para esta sucursal.</p>
                </div>
            @endif
        </div>
    </div>
    
    @if(count($todosCambios) > 0)
    <div class="card mt-4 border-0 shadow-sm">
        <div class="card-header bg-light py-3">
            <h5 class="mb-0">Resumen de Actividad</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="card bg-light border-0 mb-3">
                        <div class="card-body text-center p-3">
                            <h6 class="mb-2">Total de Cambios</h6>
                            <h2 class="mb-0">{{ count($todosCambios) }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-light border-0 mb-3">
                        <div class="card-body text-center p-3">
                            <h6 class="mb-2">Último Cambio</h6>
                            <p class="mb-0">{{ $todosCambios->first()->created_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-light border-0 mb-3">
                        <div class="card-body text-center p-3">
                            <h6 class="mb-2">Campo Más Modificado</h6>
                            <p class="mb-0">
                                @php
                                    $camposModificados = $todosCambios->where('accion', 'actualizar')->pluck('campo')->toArray();
                                    $campo = !empty($camposModificados) ? array_keys(array_count_values($camposModificados))[0] : 'N/A';
                                @endphp
                                {{ $campo }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('head')
<style>
    .calendar-icon {
        width: 45px;
        height: 45px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    .badge {
        font-weight: 500;
        padding: 0.5em 0.85em;
    }
    
    .table td {
        vertical-align: middle;
    }
</style>
@endsection