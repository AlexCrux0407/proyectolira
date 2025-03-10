<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ReporteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Ruta principal
Route::get('/', function () {
    return view('index');
});

// Rutas para sucursales
Route::prefix('web/sucursales')->group(function () {
    Route::get('/', [SucursalController::class, 'index'])->name('sucursales.index');
    Route::get('/nueva', [SucursalController::class, 'create'])->name('sucursales.create');
    Route::post('/nueva', [SucursalController::class, 'store'])->name('sucursales.store');
    Route::get('/{sucursal}', [SucursalController::class, 'show'])->name('sucursales.show');
    Route::get('/edit/{sucursal}', [SucursalController::class, 'edit'])->name('sucursales.edit');
    Route::put('/{sucursal}', [SucursalController::class, 'update'])->name('sucursales.update');
    Route::delete('/{sucursal}', [SucursalController::class, 'destroy'])->name('sucursales.destroy');
});

// Rutas para empleados
Route::prefix('web/empleados')->group(function () {
    Route::get('/', [EmpleadoController::class, 'index'])->name('empleados.index');
    Route::get('/new/{sucursal?}', [EmpleadoController::class, 'create'])->name('empleados.create');
    Route::post('/', [EmpleadoController::class, 'store'])->name('empleados.store');
    Route::get('/edit/{empleado}', [EmpleadoController::class, 'edit'])->name('empleados.edit');
    Route::put('/{empleado}', [EmpleadoController::class, 'update'])->name('empleados.update');
    Route::delete('/{empleado}', [EmpleadoController::class, 'destroy'])->name('empleados.destroy');
});

// Rutas para proveedores
Route::prefix('web/proveedores')->group(function () {
    Route::get('/', [ProveedorController::class, 'index'])->name('proveedores.index');
    Route::get('/nuevo', [ProveedorController::class, 'create'])->name('proveedores.create');
    Route::post('/', [ProveedorController::class, 'store'])->name('proveedores.store');
    Route::get('/{proveedor}', [ProveedorController::class, 'show'])->name('proveedores.show');
    Route::get('/edit/{proveedor}', [ProveedorController::class, 'edit'])->name('proveedores.edit');
    Route::put('/{proveedor}', [ProveedorController::class, 'update'])->name('proveedores.update');
    Route::delete('/{proveedor}', [ProveedorController::class, 'destroy'])->name('proveedores.destroy');
});

// Rutas para reportes
Route::get('/reportes/sucursal/{sucursal}/historial', [ReporteController::class, 'historialCambiosSucursal'])->name('reportes.historial.sucursal');
Route::get('/reportes/sucursal/{sucursal}/historial/pdf', [ReporteController::class, 'generarPDFHistorial'])->name('reportes.historial.sucursal.pdf');