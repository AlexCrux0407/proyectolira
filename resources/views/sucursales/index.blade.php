@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Sucursales</h2>
    <a href="{{ route('sucursales.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Nueva Sucursal
    </a>
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
                <img src="{{ asset('img/restaurant.png') }}" alt="Sucursal" class="branch-image mb-3">
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
@endsection