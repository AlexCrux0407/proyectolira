@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Revisar Solicitudes Recibidas</h1>
    <p>Aquí se mostrarán las solicitudes recibidas para revisión.</p>
    <!-- Example placeholder content, to be replaced with actual application data -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre del Solicitante</th>
                <th>Posición Solicitada</th>
                <th>Fecha de Solicitud</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Juan Pérez</td>
                <td>Gerente de Restaurante</td>
                <td>2025-04-01</td>
                <td>En revisión</td>
                <td>
                    <a href="#" class="btn btn-primary btn-sm">Ver Detalles</a>
                    <a href="#" class="btn btn-success btn-sm">Aprobar</a>
                    <a href="#" class="btn btn-danger btn-sm">Rechazar</a>
                </td>
            </tr>
            <!-- More rows as needed -->
        </tbody>
    </table>
</div>
@endsection