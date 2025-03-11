@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h1 class="mb-4">Sistema de Administración de Restaurantes</h1>
            <p class="lead mb-5">Bienvenido al sistema de gestión para sus sucursales. Seleccione una opción para continuar.</p>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <i class="bi bi-shop fs-1 mb-3"></i>
                            <h5 class="card-title">Sucursales</h5>
                            <p class="card-text">Administre todas sus sucursales</p>
                            <a href="{{ route('sucursales.index') }}" class="btn btn-primary">Gestionar</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <i class="bi bi-people fs-1 mb-3"></i>
                            <h5 class="card-title">Empleados</h5>
                            <p class="card-text">Gestione su personal</p>
                            <a href="{{ route('empleados.index') }}" class="btn btn-primary">Gestionar</a>
                        </div>
                    </div>
                </div>


         <!-- En la sección donde tienes las tarjetas de opciones, agrega otra para el calendario -->
<div class="col-md-4">
    <div class="card mb-4">
        <div class="card-body text-center">
            <i class="bi bi-calendar3 fs-1 mb-3"></i>
            <h5 class="card-title">Calendario</h5>
            <p class="card-text">Agenda visitas de proveedores</p>
            <a href="{{ route('calendario.index') }}" class="btn btn-primary">Gestionar</a>
        </div>
    </div>
</div>
                
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <i class="bi bi-truck fs-1 mb-3"></i>
                            <h5 class="card-title">Proveedores</h5>
                            <p class="card-text">Administre sus proveedores</p>
                            <a href="{{ route('proveedores.index') }}" class="btn btn-primary">Gestionar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection