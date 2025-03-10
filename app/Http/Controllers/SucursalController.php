<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use Illuminate\Http\Request;

class SucursalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sucursales = Sucursal::all();
        return view('sucursales.index', compact('sucursales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sucursales.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'direccion' => 'required|string',
            'telefono' => 'nullable|string|max:20',
            'encargado' => 'nullable|string|max:100',
            'horario_apertura' => 'nullable',
            'horario_cierre' => 'nullable',
        ]);

        Sucursal::create($request->all());
        
        return redirect()->route('sucursales.index')
            ->with('success', 'Sucursal creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sucursal $sucursal)
    {
        return view('sucursales.show', compact('sucursal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sucursal $sucursal)
    {
        return view('sucursales.edit', compact('sucursal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sucursal $sucursal)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'direccion' => 'required|string',
            'telefono' => 'nullable|string|max:20',
            'encargado' => 'nullable|string|max:100',
            'horario_apertura' => 'nullable',
            'horario_cierre' => 'nullable',
        ]);

        $sucursal->update($request->all());
        
        return redirect()->route('sucursales.show', $sucursal->id)
            ->with('success', 'Sucursal actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sucursal $sucursal)
    {
        $sucursal->delete();
        
        return redirect()->route('sucursales.index')
            ->with('success', 'Sucursal eliminada exitosamente');
    }
}