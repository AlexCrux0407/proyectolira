@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">
                <i class="bi bi-people text-success me-2"></i>Empleados
            </h2>
            <p class="text-muted">Gestione el personal de todas sus sucursales</p>
        </div>
        <div>
            <a href="{{ route('empleados.create') }}" class="btn btn-success">
                <i class="bi bi-person-plus me-1"></i> Nuevo Empleado
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-light py-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0 me-3">Personal Activo</h5>
                        <span class="badge bg-success rounded-pill">{{ count($empleados) }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" id="searchInput" class="form-control" placeholder="Buscar empleado...">
                        <button class="btn btn-outline-success" type="button">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3" style="width: 5%">ID</th>
                            <th style="width: 20%">Nombre</th>
                            <th style="width: 15%">Puesto</th>
                            <th style="width: 15%">Sucursal</th>
                            <th style="width: 15%">Fecha Contratación</th>
                            <th style="width: 15%">Teléfono</th>
                            <th class="text-center" style="width: 15%">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($empleados as $empleado)
                        <tr>
                            <td class="ps-3 fw-medium">{{ $empleado->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-container bg-success bg-opacity-10 text-success me-2 rounded-circle">
                                        <i class="bi bi-person"></i>
                                    </div>
                                    <div>
                                        <div class="fw-medium">{{ $empleado->nombre }} {{ $empleado->apellidos }}</div>
                                        <small class="text-muted">{{ $empleado->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $empleado->puesto }}</span>
                            </td>
                            <td>
                                @if($empleado->sucursal)
                                    <span class="d-flex align-items-center">
                                        <i class="bi bi-building me-1 text-secondary"></i>
                                        {{ $empleado->sucursal->nombre }}
                                    </span>
                                @else
                                    <span class="text-muted">No asignado</span>
                                @endif
                            </td>
                            <td>
                                @if($empleado->fecha_contratacion)
                                    <span class="d-flex align-items-center">
                                        <i class="bi bi-calendar-check me-1 text-secondary"></i>
                                        {{ \Carbon\Carbon::parse($empleado->fecha_contratacion)->format('d M, Y') }}
                                    </span>
                                @else
                                    <span class="text-muted">No especificada</span>
                                @endif
                            </td>
                            <td>
                                @if($empleado->telefono)
                                    <a href="tel:{{ $empleado->telefono }}" class="text-decoration-none d-flex align-items-center">
                                        <i class="bi bi-telephone me-1 text-secondary"></i>
                                        {{ $empleado->telefono }}
                                    </a>
                                @else
                                    <span class="text-muted">No especificado</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('empleados.edit', $empleado->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" 
                                        onclick="confirmDelete('{{ $empleado->id }}', '{{ $empleado->nombre }} {{ $empleado->apellidos }}')" 
                                        title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white py-3">
            <div class="row align-items-center">
                <div class="col-md-6 small text-muted">
                    Mostrando {{ count($empleados) }} empleados
                </div>
                <div class="col-md-6">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-end mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Anterior</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Siguiente</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-building text-primary me-2"></i>Distribución por Sucursal
                    </h5>
                    <div class="mt-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Sucursal Centro</span>
                            <span class="badge bg-primary rounded-pill">{{ $empleados->where('sucursal.nombre', 'Sucursal Centro')->count() }}</span>
                        </div>
                        <div class="progress mb-3" style="height: 8px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 45%"></div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Sucursal Sur</span>
                            <span class="badge bg-info rounded-pill">{{ $empleados->where('sucursal.nombre', 'Sucursal Sur')->count() }}</span>
                        </div>
                        <div class="progress mb-3" style="height: 8px;">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 30%"></div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Sucursal Norte</span>
                            <span class="badge bg-success rounded-pill">{{ $empleados->where('sucursal.nombre', 'Sucursal Norte')->count() }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 25%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-briefcase text-warning me-2"></i>Distribución por Puesto
                    </h5>
                    <div class="mt-3">
                        @php
                            $puestos = $empleados->groupBy('puesto');
                            $colores = ['primary', 'success', 'info', 'warning', 'danger'];
                        @endphp
                        
                        @foreach($puestos as $puesto => $grupo)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>{{ $puesto }}</span>
                                <span class="badge bg-{{ $colores[$loop->index % count($colores)] }} rounded-pill">{{ count($grupo) }}</span>
                            </div>
                            <div class="progress mb-3" style="height: 8px;">
                                <div class="progress-bar bg-{{ $colores[$loop->index % count($colores)] }}" role="progressbar" 
                                    style="width: {{ count($grupo) / count($empleados) * 100 }}%"></div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-calendar-range text-danger me-2"></i>Contrataciones Recientes
                    </h5>
                    <div class="mt-3">
                        @php
                            $recientes = $empleados->sortByDesc('fecha_contratacion')->take(5);
                        @endphp
                        
                        @foreach($recientes as $empleado)
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar-container bg-light rounded-circle me-2">
                                    <span class="fw-bold text-secondary">{{ substr($empleado->nombre, 0, 1) }}{{ substr($empleado->apellidos, 0, 1) }}</span>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-medium">{{ $empleado->nombre }} {{ $empleado->apellidos }}</div>
                                    <div class="d-flex justify-content-between">
                                        <small class="text-muted">{{ $empleado->puesto }}</small>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($empleado->fecha_contratacion)->format('d/m/Y') }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para confirmar eliminación -->
<div class="modal fade" id="deleteEmpleadoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Confirmar Eliminación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <p class="mb-0">¿Está seguro que desea eliminar al empleado <strong id="empleadoNombre"></strong>?</p>
                <p class="small text-muted mt-2 mb-0">Esta acción no se puede deshacer.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteEmpleadoForm" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('head')
<style>
    .avatar-container {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    
    .table td, .table th {
        white-space: nowrap;
    }
    
    .btn-sm {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .table tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }
    
    .progress {
        background-color: #f0f0f0;
    }
</style>
@endsection

@section('scripts')
<script>
    function confirmDelete(id, nombre) {
        document.getElementById('empleadoNombre').textContent = nombre;
        document.getElementById('deleteEmpleadoForm').action = `/web/empleados/${id}`;
        
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteEmpleadoModal'));
        deleteModal.show();
    }
    
    // Función de búsqueda para filtrar la tabla
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchText = this.value.toLowerCase();
        const table = document.querySelector('table');
        const rows = table.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchText) ? '' : 'none';
        });
    });
</script>
@endsection