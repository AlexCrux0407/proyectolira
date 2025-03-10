@extends('layouts.app')

@section('content')
<div class="card mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <img src="{{ asset('img/restaurant.png') }}" alt="Sucursal" class="img-fluid">
            </div>
            <div class="col-md-8">
                <h3>Sucursal: {{ $sucursal->nombre }}</h3>
                <p>ID: {{ $sucursal->id }}</p>
                <p>Dirección: {{ $sucursal->direccion }}</p>
                <p>Teléfono: {{ $sucursal->telefono }}</p>
                <p>Encargado: {{ $sucursal->encargado }}</p>
                <p>Horario: {{ $sucursal->horario_apertura }} - {{ $sucursal->horario_cierre }}</p>
                <p>No. de empleados: {{ $sucursal->empleados->count() }}</p>
                <p>No. de pedidos: {{ $sucursal->pedidos->count() }}</p>
                
                <div class="btn-group">
                    <a href="{{ route('sucursales.edit', $sucursal->id) }}" class="btn btn-warning">Modificar</a>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteSucursalModal">Eliminar</button>
                    <a href="{{ route('sucursales.index') }}" class="btn btn-secondary">Volver</a>
                </div>
            </div>
        </div>
    </div>
</div>

<h4 class="mb-3">Empleados</h4>
<div class="card mb-4">
    <div class="card-body">
        @if($sucursal->empleados->count() > 0)
            @foreach($sucursal->empleados as $empleado)
                <div class="row mb-2 p-2 border-bottom">
                    <div class="col-md-1">
                        <div class="user-icon bg-dark text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-person"></i>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <p class="mb-0"><strong>Nombre:</strong> {{ $empleado->nombre }} {{ $empleado->apellidos }}</p>
                        <p class="mb-0"><strong>ID:</strong> {{ $empleado->id }}</p>
                        <p class="mb-0"><strong>Puesto:</strong> {{ $empleado->puesto }}</p>
                        <p class="mb-0"><strong>Contratación:</strong> {{ $empleado->fecha_contratacion }}</p>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('empleados.edit', $empleado->id) }}" class="btn btn-sm btn-warning">Modificar</a>
                        <button class="btn btn-sm btn-danger" onclick="setEmpleadoId('{{ $empleado->id }}')" data-bs-toggle="modal" data-bs-target="#deleteEmpleadoModal">Eliminar</button>
                    </div>
                </div>
            @endforeach
        @else
            <p>No hay empleados registrados en esta sucursal.</p>
        @endif
        <div class="mt-3">
            <a href="{{ route('empleados.create', ['sucursal' => $sucursal->id]) }}" class="btn btn-success">Agregar Empleado</a>
        </div>
    </div>
</div>

<!-- Delete Sucursal Modal -->
<div class="modal fade" id="deleteSucursalModal" tabindex="-1" aria-labelledby="deleteSucursalModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteSucursalModalLabel">Confirmar eliminación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Está seguro que desea eliminar esta sucursal?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <form action="{{ route('sucursales.destroy', $sucursal->id) }}" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Eliminar</button>
        </form>
      </div>
    </div>
  </div>
</div>

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
let empleadoIdToDelete = null;

function setEmpleadoId(id) {
    empleadoIdToDelete = id;
    document.getElementById('deleteEmpleadoForm').action = '/web/empleados/' + id;
}
</script>
@endsection