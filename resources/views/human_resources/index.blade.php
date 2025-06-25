@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Recursos Humanos</h1>

    <ul class="nav nav-tabs mb-4" id="hrTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="vacantes-tab" data-bs-toggle="tab" data-bs-target="#vacantes" type="button" role="tab" aria-controls="vacantes" aria-selected="true">Enviar Vacante a Marketing</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="solicitudes-tab" data-bs-toggle="tab" data-bs-target="#solicitudes" type="button" role="tab" aria-controls="solicitudes" aria-selected="false">Revisar Solicitudes</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="otras-tab" data-bs-toggle="tab" data-bs-target="#otras" type="button" role="tab" aria-controls="otras" aria-selected="false">Otras Funciones</button>
        </li>
    </ul>

    <div class="tab-content" id="hrTabsContent">
        <div class="tab-pane fade show active" id="vacantes" role="tabpanel" aria-labelledby="vacantes-tab">
            <h3>Enviar Vacante Disponible a Marketing</h3>
            <a href="{{ route('human_resources.create') }}" class="btn btn-primary mb-3">Crear Nueva Vacante</a>
            
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Área Laboral</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Fecha Límite</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vacantes as $vacante)
                        <tr>
                            <td>{{ $vacante->nombre }}</td>
                            <td>{{ $vacante->area_laboral }}</td>
                            <td>{{ $vacante->descripcion }}</td>
                            <td>{{ $vacante->estado }}</td>
                            <td>{{ $vacante->fecha_limite }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="tab-pane fade" id="solicitudes" role="tabpanel" aria-labelledby="solicitudes-tab">
            <h3>Revisar Solicitudes de Postulados</h3>
            
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Vacante</th>
                            <th>Fecha Solicitud</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($solicitudes as $solicitud)
                        <tr>
                            <td>{{ $solicitud->nombre_solicitante }}</td>
                            <td>{{ $solicitud->vacante->nombre }}</td>
                            <td>{{ $solicitud->fecha_solicitud }}</td>
                            <td>{{ $solicitud->estado }}</td>
                            <td>
                                <a href="#" class="btn btn-primary btn-sm">Ver</a>
                                <a href="#" class="btn btn-success btn-sm">Aprobar</a>
                                <a href="#" class="btn btn-danger btn-sm">Rechazar</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


    </div>
</div>
@endsection