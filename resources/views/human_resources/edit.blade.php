@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <h1 class="h2">Edit HR Task</h1>
    <form action="{{ route('human_resources.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="task_name" class="form-label">Task Name</label>
            <input type="text" class="form-control" id="task_name" name="task_name" value="{{ $task->task_name }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required>{{ $task->description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="assigned_to" class="form-label">Assigned To</label>
            <input type="text" class="form-control" id="assigned_to" name="assigned_to" value="{{ $task->assigned_to }}">
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <input type="text" class="form-control" id="status" name="status" value="{{ $task->status }}">
        </div>
        <div class="mb-3">
            <label for="due_date" class="form-label">Due Date</label>
            <input type="date" class="form-control" id="due_date" name="due_date" value="{{ $task->due_date ? $task->due_date->format('Y-m-d') : '' }}">
        </div>
        <button type="submit" class="btn btn-primary">Update Task</button>
    </form>
</div>
@endsection