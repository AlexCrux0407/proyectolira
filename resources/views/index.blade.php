@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center mb-4">
        <div class="col-lg-8 text-center">
            <h1 class="display-5 fw-bold mb-3">Sistema de Administración de Restaurantes</h1>
            <p class="lead text-muted">Bienvenido al sistema de gestión para sus sucursales. Seleccione una opción para continuar.</p>
        </div>
    </div>
    
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
        <!-- Tarjeta Sucursales -->
        <div class="col">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="icon-container mb-3">
                        <i class="bi bi-shop text-primary" style="font-size: 2.5rem;"></i>
                    </div>
                    <h5 class="card-title mb-2">Sucursales</h5>
                    <p class="card-text small text-muted mb-3">Administre todas sus sucursales, desde información básica hasta métricas de desempeño.</p>
                    <div class="d-grid">
                        <a href="{{ route('sucursales.index') }}" class="btn btn-primary">
                            <i class="bi bi-building-fill me-1"></i> Gestionar
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tarjeta Empleados -->
        <div class="col">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="icon-container mb-3">
                        <i class="bi bi-people text-success" style="font-size: 2.5rem;"></i>
                    </div>
                    <h5 class="card-title mb-2">Empleados</h5>
                    <p class="card-text small text-muted mb-3">Gestione su personal, horarios, asignaciones a sucursales y toda la información relevante.</p>
                    <div class="d-grid">
                        <a href="{{ route('empleados.index') }}" class="btn btn-success">
                            <i class="bi bi-person-badge-fill me-1"></i> Gestionar
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tarjeta Calendario -->
        <div class="col">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="icon-container mb-3">
                        <i class="bi bi-calendar3 text-info" style="font-size: 2.5rem;"></i>
                    </div>
                    <h5 class="card-title mb-2">Calendario</h5>
                    <p class="card-text small text-muted mb-3">Agenda visitas de proveedores, eventos especiales y otras actividades importantes.</p>
                    <div class="d-grid">
                        <a href="{{ route('calendario.index') }}" class="btn btn-info text-white">
                            <i class="bi bi-calendar-check me-1"></i> Gestionar
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tarjeta Proveedores -->
        <div class="col">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="icon-container mb-3">
                        <i class="bi bi-truck text-warning" style="font-size: 2.5rem;"></i>
                    </div>
                    <h5 class="card-title mb-2">Proveedores</h5>
                    <p class="card-text small text-muted mb-3">Administre sus proveedores, pedidos, historial de compras y catálogos de productos.</p>
                    <div class="d-grid">
                        <a href="{{ route('proveedores.index') }}" class="btn btn-warning">
                            <i class="bi bi-box-seam me-1"></i> Gestionar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('head')
<style>
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    
    .icon-container {
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn {
        padding: 0.5rem 1rem;
        font-weight: 500;
    }
</style>
@endsection