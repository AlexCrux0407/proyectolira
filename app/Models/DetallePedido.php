<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    protected $table = 'detalles_pedido';
    protected $fillable = [
        'pedido_id',
        'producto_servicio',
        'cantidad',
        'precio_unitario',
        'subtotal'
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'pedido_id');
    }
}