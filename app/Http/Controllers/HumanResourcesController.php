<?php

namespace App\Http\Controllers;

use App\Models\HumanResources;
use Illuminate\Http\Request;

class HumanResourcesController extends Controller
{
    /**
     * Display a listing of the HR tasks.
     */
    public function index()
    {
        $tasks = HumanResources::all();
        $vacantes = HumanResources::where('status', 'Abierta')->get();
        $solicitudes = HumanResources::where('status', 'Solicitud')->get();
        return view('human_resources.index', compact('tasks', 'vacantes', 'solicitudes'));
    }

    /**
     * Show the form for creating a new HR task.
     */
    public function create()
    {
        return view('human_resources.create');
    }

    /**
     * Store a newly created HR task in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'task_name' => 'required|string|max:100',
            'description' => 'required|string',
            'assigned_to' => 'nullable|string|max:100',
            'status' => 'nullable|string|max:50',
            'due_date' => 'nullable|date',
        ]);

        HumanResources::create($request->all());
        
        return redirect()->route('human_resources.index')
            ->with('success', 'HR task created successfully');
    }

    /**
     * Display the specified HR task.
     */
    public function show(HumanResources $task)
    {
        return view('human_resources.show', compact('task'));
    }

    /**
     * Show the form for editing the specified HR task.
     */
    public function edit(HumanResources $task)
    {
        return view('human_resources.edit', compact('task'));
    }

    /**
     * Update the specified HR task in storage.
     */
    public function update(Request $request, HumanResources $task)
    {
        $request->validate([
            'task_name' => 'required|string|max:100',
            'description' => 'required|string',
            'assigned_to' => 'nullable|string|max:100',
            'status' => 'nullable|string|max:50',
            'due_date' => 'nullable|date',
        ]);

        $task->update($request->all());
        
        return redirect()->route('human_resources.index')
            ->with('success', 'HR task updated successfully');
    }

    /**
     * Remove the specified HR task from storage.
     */
    public function destroy(HumanResources $task)
    {
        $task->delete();
        return redirect()->route('human_resources.index')
            ->with('success', 'HR task deleted successfully');
    }

    /**
     * Send vacancies to marketing department.
     */
    public function sendVacanciesToMarketing()
    {
        // Logic to send vacancies to marketing
        // For example, notify marketing or create a record
        return redirect()->route('human_resources.index')
            ->with('success', 'Vacancies sent to marketing successfully');
    }

    /**
     * Review applications received.
     */
    public function reviewApplications()
    {
        // Logic to review applications
        // For example, fetch applications and show them
        return view('human_resources.review_applications');
    }
}