@extends('layouts.app')

@section('content')
<h2 class="mb-4">Nueva Sucursal</h2>

<div class="card">
    <div class="card-body">
        <form action="{{ route('sucursales.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre de la Sucursal</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <textarea class="form-control" id="direccion" name="direccion" required></textarea>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono">
            </div>
            <div class="mb-3">
                <label for="encargado" class="form-label">Encargado</label>
                <input type="text" class="form-control" id="encargado" name="encargado">
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="horario_apertura" class="form-label">Horario de Apertura</label>
                    <input type="time" class="form-control" id="horario_apertura" name="horario_apertura">
                </div>
                <div class="col-md-6">
                    <label for="horario_cierre" class="form-label">Horario de Cierre</label>
                    <input type="time" class="form-control" id="horario_cierre" name="horario_cierre">
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <a href="{{ route('sucursales.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection