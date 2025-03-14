@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Detalles del Proveedor</h2>
    <div>
        <a href="{{ route('proveedores.edit', $proveedor->id) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Editar
        </a>
        <a href="{{ route('proveedores.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="bg-light p-4 text-center rounded">
                    <i class="bi bi-building fs-1 mb-3"></i>
                    <h4>{{ $proveedor->nombre_empresa }}</h4>
                </div>
            </div>
            <div class="col-md-8">
                <h5 class="border-bottom pb-2 mb-3">Información de Contacto</h5>
                <p><strong>Contacto:</strong> {{ $proveedor->contacto_nombre ?: 'No especificado' }}</p>
                <p><strong>Teléfono:</strong> {{ $proveedor->telefono ?: 'No especificado' }}</p>
                <p><strong>Email:</strong> {{ $proveedor->email ?: 'No especificado' }}</p>
                <p><strong>Dirección:</strong> {{ $proveedor->direccion ?: 'No especificada' }}</p>
                
                <h5 class="border-bottom pb-2 mb-3 mt-4">Productos y Servicios</h5>
                <p>{{ $proveedor->productos_servicios ?: 'No hay productos o servicios especificados.' }}</p>
            </div>
        </div>
    </div>
</div>

<h4 class="mb-3">Pedidos Realizados</h4>
<div class="card">
    <div class="card-body">
        @if($pedidos->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Sucursal</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pedidos as $pedido)
                        <tr>
                            <td>{{ $pedido->id }}</td>
                            <td>{{ $pedido->sucursal ? $pedido->sucursal->nombre : 'N/A' }}</td>
                            <td>{{ $pedido->fecha_pedido }}</td>
                            <td>
                                @if($pedido->estado == 'pendiente')
                                    <span class="badge bg-warning">Pendiente</span>
                                @elseif($pedido->estado == 'entregado')
                                    <span class="badge bg-success">Entregado</span>
                                @elseif($pedido->estado == 'cancelado')
                                    <span class="badge bg-danger">Cancelado</span>
                                @endif
                            </td>
                            <td>${{ number_format($pedido->total, 2) }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted">Este proveedor no tiene pedidos registrados.</p>
        @endif
    </div>
</div>
@endsection