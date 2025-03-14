@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Proveedores</h2>
    <a href="{{ route('proveedores.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Nuevo Proveedor
    </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(isset($proveedores) && count($proveedores) > 0)
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre Empresa</th>
                        <th>Contacto</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Productos/Servicios</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($proveedores as $proveedor)
                    <tr>
                        <td>{{ $proveedor->id }}</td>
                        <td>{{ $proveedor->nombre_empresa }}</td>
                        <td>{{ $proveedor->contacto_nombre }}</td>
                        <td>{{ $proveedor->telefono }}</td>
                        <td>{{ $proveedor->email }}</td>
                        <td>{{ Str::limit($proveedor->productos_servicios, 30) }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('proveedores.show', $proveedor->id) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('proveedores.edit', $proveedor->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" 
                                    onclick="confirmDelete('{{ $proveedor->id }}', '{{ $proveedor->nombre_empresa }}')" 
                                    data-bs-toggle="modal" data-bs-target="#deleteProveedorModal">
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
</div>
@else
<div class="alert alert-info">
    <p>No hay proveedores registrados. ¡Crea un nuevo proveedor para comenzar!</p>
</div>
@endif

<!-- Modal para eliminar proveedor -->
<div class="modal fade" id="deleteProveedorModal" tabindex="-1" aria-labelledby="deleteProveedorModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteProveedorModalLabel">Confirmar eliminación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Está seguro que desea eliminar al proveedor <span id="proveedorNombre" class="fw-bold"></span>?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <form id="deleteProveedorForm" action="" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Eliminar</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
    function confirmDelete(id, nombre) {
        document.getElementById('proveedorNombre').textContent = nombre;
        document.getElementById('deleteProveedorForm').action = `/web/proveedores/${id}`;
    }
</script>
@endsection