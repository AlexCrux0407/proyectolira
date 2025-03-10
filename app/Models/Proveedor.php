<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';
    protected $fillable = [
        'nombre_empresa',
        'contacto_nombre',
        'telefono',
        'email',
        'direccion',
        'productos_servicios'
    ];

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'proveedor_id');
    }
}