@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">
                <i class="bi bi-truck text-primary me-2"></i>Proveedores
            </h2>
            <p class="text-muted">Gestione sus proveedores y contactos comerciales</p>
        </div>
        <div>
            <a href="{{ route('proveedores.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle me-1"></i> Nuevo Proveedor
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-light py-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0">Lista de Proveedores</h5>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" id="searchInput" class="form-control" placeholder="Buscar proveedor...">
                        <button class="btn btn-outline-primary" type="button">
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
                            <th style="width: 20%">Nombre Empresa</th>
                            <th style="width: 15%">Contacto</th>
                            <th style="width: 10%">Teléfono</th>
                            <th style="width: 15%">Email</th>
                            <th style="width: 20%">Productos/Servicios</th>
                            <th class="text-center" style="width: 15%">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($proveedores as $proveedor)
                        <tr>
                            <td class="ps-3 fw-medium">{{ $proveedor->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-container bg-primary bg-opacity-10 text-primary me-2 rounded-circle">
                                        <i class="bi bi-building"></i>
                                    </div>
                                    <span class="fw-medium">{{ $proveedor->nombre_empresa }}</span>
                                </div>
                            </td>
                            <td>{{ $proveedor->contacto_nombre }}</td>
                            <td>{{ $proveedor->telefono }}</td>
                            <td>
                                <a href="mailto:{{ $proveedor->email }}" class="text-decoration-none">
                                    {{ $proveedor->email }}
                                </a>
                            </td>
                            <td>
                                <div class="text-truncate" style="max-width: 200px;" title="{{ $proveedor->productos_servicios }}">
                                    {{ $proveedor->productos_servicios }}
                                </div>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('proveedores.show', $proveedor->id) }}" class="btn btn-sm btn-info text-white" title="Ver detalles">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('proveedores.edit', $proveedor->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" 
                                        onclick="confirmDelete('{{ $proveedor->id }}', '{{ $proveedor->nombre_empresa }}')" 
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
                    Mostrando {{ count($proveedores) }} proveedores
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
</div>

<!-- Modal para confirmar eliminación -->
<div class="modal fade" id="deleteProveedorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Confirmar Eliminación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <p class="mb-0">¿Está seguro que desea eliminar al proveedor <strong id="proveedorNombre"></strong>?</p>
                <p class="small text-muted mt-2 mb-0">Esta acción no se puede deshacer.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteProveedorForm" action="" method="POST">
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
</style>
@endsection

@section('scripts')
<script>
    function confirmDelete(id, nombre) {
        document.getElementById('proveedorNombre').textContent = nombre;
        document.getElementById('deleteProveedorForm').action = `/web/proveedores/${id}`;
        
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteProveedorModal'));
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