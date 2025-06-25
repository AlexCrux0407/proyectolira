@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <h1 class="h2">HR Task Details</h1>
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">{{ $task->task_name }}</h5>
            <p class="card-text"><strong>Description:</strong> {{ $task->description }}</p>
            <p class="card-text"><strong>Assigned To:</strong> {{ $task->assigned_to ?? 'Not assigned' }}</p>
            <p class="card-text"><strong>Status:</strong> {{ $task->status ?? 'Pending' }}</p>
            <p class="card-text"><strong>Due Date:</strong> {{ $task->due_date ? $task->due_date->format('Y-m-d') : 'No due date' }}</p>
            <a href="{{ route('human_resources.edit', $task->id) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('human_resources.destroy', $task->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    </div>
    <a href="{{ route('human_resources.index') }}" class="btn btn-secondary mt-3">Back to Tasks</a>
</div>
@endsection