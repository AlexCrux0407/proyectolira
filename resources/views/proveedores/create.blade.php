@extends('layouts.app')

@section('content')
<h2 class="mb-4">Nuevo Proveedor</h2>

<div class="card">
    <div class="card-body">
        <form action="{{ route('proveedores.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nombre_empresa" class="form-label">Nombre de la Empresa</label>
                <input type="text" class="form-control" id="nombre_empresa" name="nombre_empresa" required>
            </div>
            <div class="mb-3">
                <label for="contacto_nombre" class="form-label">Nombre de Contacto</label>
                <input type="text" class="form-control" id="contacto_nombre" name="contacto_nombre">
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" name="telefono">
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
            </div>
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <textarea class="form-control" id="direccion" name="direccion" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="productos_servicios" class="form-label">Productos o Servicios</label>
                <textarea class="form-control" id="productos_servicios" name="productos_servicios" rows="3"></textarea>
            </div>
            <div class="d-flex justify-content-between">
                <a href="{{ route('proveedores.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection