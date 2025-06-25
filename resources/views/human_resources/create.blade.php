@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <h1 class="h2">Crear nueva vacante</h1>
    <form action="{{ route('human_resources.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="task_name" class="form-label">Nombre de la vacante</label>
            <input type="text" class="form-control" id="task_name" name="task_name" required>
        </div>   
        <div class="mb-3">
            <label for="assigned_to" class="form-label">Área laboral</label>
            <input type="text" class="form-control" id="assigned_to" name="assigned_to">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Estado</label>
            <input type="text" class="form-control" id="status" name="status">
        </div>
        <div class="mb-3">
            <label for="due_date" class="form-label">Fecha limite</label>
            <input type="date" class="form-control" id="due_date" name="due_date">
        </div>
        <button type="submit" class="btn btn-primary">Crear vacante</button>
    </form>
</div>
@endsection