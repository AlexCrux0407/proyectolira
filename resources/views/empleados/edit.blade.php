@extends('layouts.app')

@section('content')
<h2 class="mb-4">Editar Empleado</h2>

<div class="card">
    <div class="card-body">
        <form action="{{ route('empleados.update', $empleado->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $empleado->nombre }}" required>
                </div>
                <div class="col-md-6">
                    <label for="apellidos" class="form-label">Apellidos</label>
                    <input type="text" class="form-control" id="apellidos" name="apellidos" value="{{ $empleado->apellidos }}" required>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="sucursal_id" class="form-label">Sucursal</label>
                <select class="form-control" id="sucursal_id" name="sucursal_id" required>
                    <option value="">Seleccione una sucursal</option>
                    @foreach($sucursales as $sucursal)
                        <option value="{{ $sucursal->id }}" {{ $empleado->sucursal_id == $sucursal->id ? 'selected' : '' }}>
                            {{ $sucursal->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-3">
                <label for="puesto" class="form-label">Puesto</label>
                <input type="text" class="form-control" id="puesto" name="puesto" value="{{ $empleado->puesto }}" required>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="fecha_contratacion" class="form-label">Fecha de Contratación</label>
                    <input type="date" class="form-control" id="fecha_contratacion" name="fecha_contratacion" value="{{ $empleado->fecha_contratacion }}">
                </div>
                <div class="col-md-6">
                    <label for="salario" class="form-label">Salario</label>
                    <input type="number" step="0.01" class="form-control" id="salario" name="salario" value="{{ $empleado->salario }}">
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" value="{{ $empleado->telefono }}">
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $empleado->email }}">
                </div>
            </div>
            
            <input type="hidden" name="from_sucursal" value="{{ request()->has('from_sucursal') ? '1' : '0' }}">
            
            <div class="d-flex justify-content-between">
                @if(request()->has('from_sucursal'))
                    <a href="{{ route('sucursales.show', $empleado->sucursal_id) }}" class="btn btn-secondary">Cancelar</a>
                @else
                    <a href="{{ route('empleados.index') }}" class="btn btn-secondary">Cancelar</a>
                @endif
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>
@endsection