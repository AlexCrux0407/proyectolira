@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Empleados</h2>
    <a href="{{ route('empleados.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Nuevo Empleado
    </a>
</div>

@if(isset($empleados) && count($empleados) > 0)
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Puesto</th>
                        <th>Sucursal</th>
                        <th>Fecha Contratación</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($empleados as $empleado)
                    <tr>
                        <td>{{ $empleado->id }}</td>
                        <td>{{ $empleado->nombre }} {{ $empleado->apellidos }}</td>
                        <td>{{ $empleado->puesto }}</td>
                        <td>{{ $empleado->sucursal ? $empleado->sucursal->nombre : 'N/A' }}</td>
                        <td>{{ $empleado->fecha_contratacion }}</td>
                        <td>{{ $empleado->telefono }}</td>
                        <td>
                            <a href="{{ route('empleados.edit', $empleado->id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteEmpleadoModal" onclick="setEmpleadoId('{{ $empleado->id }}')">
                                <i class="bi bi-trash"></i>
                            </button>
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
    <p>No hay empleados registrados.</p>
</div>
@endif

<!-- Delete Empleado Modal -->
<div class="modal fade" id="deleteEmpleadoModal" tabindex="-1" aria-labelledby="deleteEmpleadoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteEmpleadoModalLabel">Confirmar eliminación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Está seguro que desea eliminar este empleado?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <form id="deleteEmpleadoForm" action="" method="POST">
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
function setEmpleadoId(id) {
    document.getElementById('deleteEmpleadoForm').action = '/web/empleados/' + id;
}
</script>
@endsection