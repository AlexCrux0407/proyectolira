<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitaProveedor extends Model
{
    protected $table = 'visitas_proveedor';
    
    protected $fillable = [
        'proveedor_id',
        'sucursal_id',
        'fecha_visita',
        'hora_inicio',
        'hora_fin',
        'motivo',
        'estado',
        'notas'
    ];

    protected $casts = [
        'fecha_visita' => 'date',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }
}