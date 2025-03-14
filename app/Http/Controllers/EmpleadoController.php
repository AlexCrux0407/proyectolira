<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Sucursal;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empleados = Empleado::with('sucursal')->get();
        return view('empleados.index', compact('empleados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $sucursales = Sucursal::all();
        $sucursal_id = $request->sucursal;
        return view('empleados.create', compact('sucursales', 'sucursal_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'sucursal_id' => 'required|exists:sucursales,id',
            'puesto' => 'required|string|max:50',
            'fecha_contratacion' => 'nullable|date',
            'salario' => 'nullable|numeric',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
        ]);
    
        // Crear el empleado
        $empleado = Empleado::create($request->all());
        
        // Registrar para depuración
        \Log::info('Empleado creado', [
            'id' => $empleado->id,
            'nombre' => $empleado->nombre,
            'sucursal_id' => $empleado->sucursal_id
        ]);
        
        // Redireccionar a la sucursal si viene de allí
        if ($request->has('from_sucursal') && $request->from_sucursal) {
            return redirect()->route('sucursales.show', $request->sucursal_id)
                ->with('success', 'Empleado creado exitosamente');
        }
        
        return redirect()->route('empleados.index')
            ->with('success', 'Empleado creado exitosamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Empleado $empleado)
    {
        $sucursales = Sucursal::all();
        return view('empleados.edit', compact('empleado', 'sucursales'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Empleado $empleado)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'sucursal_id' => 'required|exists:sucursales,id',
            'puesto' => 'required|string|max:50',
            'fecha_contratacion' => 'nullable|date',
            'salario' => 'nullable|numeric',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
        ]);

        $empleado->update($request->all());
        
        if ($request->has('from_sucursal') && $request->from_sucursal) {
            return redirect()->route('sucursales.show', $empleado->sucursal_id)
                ->with('success', 'Empleado actualizado exitosamente');
        }
        
        return redirect()->route('empleados.index')
            ->with('success', 'Empleado actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empleado $empleado)
    {
        $sucursal_id = $empleado->sucursal_id;
        $empleado->delete();
        
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->back()->with('success', 'Empleado eliminado exitosamente');
    }
}