@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2">Departamentos</h1>
        <div>
            <a href="{{ route('departamentos.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nuevo Departamento
            </a>
        </div>
    </div>

    @if(isset($departamentos) && count($departamentos) > 0)
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Responsable</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($departamentos as $departamento)
                        <tr>
                            <td>{{ $departamento->id }}</td>
                            <td>{{ $departamento->nombre }}</td>
                            <td>{{ Str::limit($departamento->descripcion, 50) }}</td>
                            <td>{{ $departamento->responsable ?? 'No asignado' }}</td>
                            <td>
                                <a href="{{ route('departamentos.show', $departamento->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('departamentos.edit', $departamento->id) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="alert alert-info">
        <p class="mb-0"><i class="bi bi-info-circle me-2"></i> No hay departamentos registrados.</p>
    </div>
    @endif
</div>
@endsection