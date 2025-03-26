<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'categoria',
        'activo'
    ];

    public function ventas()
    {
        return $this->hasMany(VentaProducto::class, 'producto_id');
    }
}