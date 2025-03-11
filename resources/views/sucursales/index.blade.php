@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Sucursales</h2>
    <div>
        <a href="{{ route('exportar.finanzas') }}" class="btn btn-success me-2">
            <i class="bi bi-file-excel"></i> Exportar Finanzas
        </a>
        <a href="{{ route('sucursales.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Nueva Sucursal
        </a>
    </div>
</div>

<div class="mb-4">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d92784.73504747267!2d-99.29759048253521!3d18.932211950117146!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85cdde499b22afad%3A0xc9b6bcb5b9b790a1!2sCuernavaca%2C%20Mor.!5e0!3m2!1ses-419!2smx!4v1741033925280!5m2!1ses-419!2smx" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>

@if(isset($sucursales) && count($sucursales) > 0)
<div class="row">
    @foreach($sucursales as $sucursal)
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <img src="{{ asset('images/restaurant.png') }}" alt="Sucursal" class="branch-image mb-3">
                <h5 class="card-title">{{ $sucursal->nombre }}</h5>
                <p class="card-text">No. De empleados: {{ $sucursal->empleados->count() }}</p>
                <p class="card-text">ID: {{ $sucursal->id }}</p>
                <a href="{{ route('sucursales.show', $sucursal->id) }}" class="btn btn-primary">Ver detalles</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="alert alert-info">
    <p>No hay sucursales registradas. ¡Crea una nueva sucursal para comenzar!</p>
</div>
@endif

<!-- Modal para filtrar exportación -->
<div class="modal fade" id="exportarFinanzasModal" tabindex="-1" aria-labelledby="exportarFinanzasModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exportarFinanzasModalLabel">Exportar Reporte Financiero</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('exportar.finanzas') }}" method="GET">
        <div class="modal-body">
          <div class="mb-3">
            <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="{{ now()->subMonths(3)->format('Y-m-d') }}">
          </div>
          <div class="mb-3">
            <label for="fecha_fin" class="form-label">Fecha Fin</label>
            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="{{ now()->format('Y-m-d') }}">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Exportar</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection