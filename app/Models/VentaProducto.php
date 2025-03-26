<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VentaProducto extends Model
{
    protected $table = 'ventas_productos';
    
    protected $fillable = [
        'sucursal_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'total',
        'fecha_venta'
    ];

    protected $casts = [
        'fecha_venta' => 'date',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }
}