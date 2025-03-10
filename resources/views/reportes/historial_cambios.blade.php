@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Historial de Cambios - Sucursal: {{ $sucursal->nombre }}</h2>
    <div>
        <a href="{{ route('reportes.historial.sucursal.pdf', $sucursal->id) }}" class="btn btn-danger">
            <i class="bi bi-file-pdf"></i> Generar PDF
        </a>
        <a href="{{ route('sucursales.show', $sucursal->id) }}" class="btn btn-secondary">
            Volver a Sucursal
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if(count($todosCambios) > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Acción</th>
                            <th>Detalles</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($todosCambios as $cambio)
                            <tr>
                                <td>{{ $cambio->created_at->format('d/m/Y H:i:s') }}</td>
                                <td>
                                    @if($cambio->modelo_tipo == 'App\Models\Sucursal')
                                        Sucursal
                                    @elseif($cambio->modelo_tipo == 'App\Models\Empleado')
                                        Empleado
                                    @else
                                        {{ class_basename($cambio->modelo_tipo) }}
                                    @endif
                                </td>
                                <td>
                                    @if($cambio->accion == 'crear')
                                        <span class="badge bg-success">Creación</span>
                                    @elseif($cambio->accion == 'actualizar')
                                        <span class="badge bg-warning">Actualización</span>
                                    @elseif($cambio->accion == 'eliminar')
                                        <span class="badge bg-danger">Eliminación</span>
                                    @endif
                                </td>
                                <td>
                                    @if($cambio->accion == 'crear')
                                        Se creó un nuevo registro.
                                    @elseif($cambio->accion == 'actualizar')
                                        Campo <strong>{{ $cambio->campo }}</strong> cambió de 
                                        <strong>"{{ $cambio->valor_anterior }}"</strong> a 
                                        <strong>"{{ $cambio->valor_nuevo }}"</strong>
                                    @elseif($cambio->accion == 'eliminar')
                                        Se eliminó un registro.
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">
                No hay cambios registrados para esta sucursal.
            </div>
        @endif
    </div>
</div>
@endsection